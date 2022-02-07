<?php

namespace App\Observers;

use A17\Twill\Models\File;
use DB;
use Exception;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileObserver
{
    /**
     * Handle the file "created" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function created(File $file)
    {
        $this->handleImageSequenceZip($file);
    }

    /**
     * Handle the file "updated" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function updated(File $file)
    {

    }

    /**
     * Handle the file "deleted" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function deleted(File $file)
    {

    }

    /**
     * Handle the file "restored" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function restored(File $file)
    {

    }

    /**
     * Handle the file "force deleted" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function forceDeleted(File $file)
    {

    }

    public function handleImageSequenceZip($file)
    {
        if (!$this->checkZipType($file)) {
            return;
        }

        try {
            $zipFile = $this->downloadZip($file);
            $zipFolderName = $this->unzip($zipFile);
            $this->uploadToS3($zipFolderName, $file);
            $this->cleanAssets();
        } catch (Exception $e) {
            debug($e);
        }
    }

    private function checkZipType($file)
    {
        $filenameArray = explode('.', $file->filename);
        if (count($filenameArray) < 2) {
            return false;
        }
        $ext = end($filenameArray);

        return $ext === 'zip';
    }

    private function downloadZip($file)
    {
        $fileUrl = ($file->toCmsArray())['src'];
        $zipFile = storage_path('app') . '/tempFile.zip';
        file_put_contents($zipFile, fopen($fileUrl, 'r'));

        return $zipFile;
    }

    private function unzip($zipFile)
    {
        $zip = new ZipArchive();
        if ($zip->open($zipFile) === true) {
            $zip->extractTo(storage_path('app') . '/tempDir');
            $zipFolderName = trim($zip->getNameIndex(0), '/');
            $zip->close();
            if (strpos($zipFolderName, '.')) {
                return '';
            }

            return $zipFolderName;
        }

            throw new Exception('Cannot read the zip file');

    }

    private function uploadToS3($zipFolderName, $file)
    {
        $files = Storage::disk('local')->allFiles('/tempDir\/' . $zipFolderName);
        $images = array_values(Arr::sort(array_filter($files, function ($filePath) {
            $fileNameArray = explode('.', basename($filePath));
            if (count($fileNameArray) < 2) {
                return false;
            }

            return in_array(end($fileNameArray), ['jpg', 'png', 'jpeg']) && strlen($fileNameArray[0]) > 0;
        })));
        foreach ($images as $index => $imageName) {
            $image_size = getimagesize(storage_path('app') . '/' . $imageName);
            $uploaded = Storage::disk('s3')->putFile('seq', new HttpFile(storage_path('app') . '/' . $imageName), 'public');
            DB::table('seamless_images')->insert(
                [
                    'file_name' => substr($uploaded, 4),
                    'zip_file_id' => $file->id,
                    'frame' => $index,
                    'width' => $image_size[0],
                    'height' => $image_size[1],
                ]
            );
        }
    }

    private function cleanAssets()
    {
        Storage::disk('local')->delete('tempFile.zip');
        Storage::disk('local')->deleteDirectory('tempDir');
    }
}
