<?php

namespace App\Jobs;

use A17\Twill\Models\Media;
use Illuminate\Support\Facades\Storage;

class TileMedia extends BaseJob
{
    private $item;

    private $forceRetile;

    public function __construct(Media $item, bool $forceRetile)
    {
        $this->item = $item;
        $this->forceRetile = $forceRetile;
    }

    public function handle()
    {
        $iiifMedia = $this->item;

        $iiifMediaUuid = get_clean_media_uuid($iiifMedia);

        $s3 = Storage::disk(config('twill.media_library.disk'));
        $local = Storage::disk('local');
        $iiifS3 = Storage::disk('iiif_s3');

        $localFilename = $iiifMediaUuid;

        // Clean up first if this job failed
        if ($local->exists('tiles/src/' . $localFilename)) {
            $local->delete('tiles/src/' . $localFilename);
        }

        if ($local->exists('tiles/out/' . $localFilename)) {
            $local->deleteDirectory('tiles/out/' . $localFilename);
        }

        // No need to do all this work if the tiles have been generated..?
        if (!$this->forceRetile && $iiifS3->exists($localFilename)) {
            return true;
        }

        // https://stackoverflow.com/questions/47581934/copying-a-file-using-2-disks-with-laravel
        $local->writeStream('tiles/src/' . $localFilename, $s3->readStream($iiifMedia->uuid));

        exec(base_path() . '/bin/tile.sh ' . escapeshellarg($localFilename) . '  2>&1');

        // This won't happen since we exited early, but if that check is removed, we need this
        if ($iiifS3->exists($localFilename)) {
            $iiifS3->deleteDirectory($localFilename);
        }

        // There's probably a quicker way to transfer an entire directory to S3, but this'll do for now
        // https://bakerstreetsystems.com/blog/post/recursively-transfer-entire-directory-amazon-s3-laravel-52
        // https://stackoverflow.com/questions/44900585/aws-s3-copy-and-replicate-folder-in-laravel
        $s3Client = $iiifS3->getDriver()->getAdapter()->getClient();
        $s3Client->uploadDirectory(storage_path() . '/app/tiles/out', config('filesystems.disks.iiif_s3.bucket'));

        // Clean up on success
        $local->delete('tiles/src/' . $localFilename);
        $local->deleteDirectory('tiles/out/' . $localFilename);
    }
}
