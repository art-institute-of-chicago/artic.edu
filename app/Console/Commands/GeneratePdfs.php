<?php

namespace App\Console\Commands;

use App\Models\AbstractModel;
use App\Models\DigitalPublicationSection;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Prince\Prince;

class GeneratePdfs extends Command
{
    public const STORAGE_PATH = '/pdf/static/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdfs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to go through all pages with a download option and generate downloadable PDFs.';

    /**
     * Array of models to generate PDFs for. Format is `route => model class`
     */
    protected static array $models = [
        'collection.publications.digital-publications-sections.show' => DigitalPublicationSection::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (self::$models as $route => $modelClass) {
            $models = $modelClass::published()->get();

            foreach ($models as $model) {
                try {
                    $this->generatePdf($model, $route);
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    return 1;
                }
            }

            $urls = $models->pluck('pdf_download_path')->all();

            if (!empty($urls)) {
                $this->call('cache:invalidate-cloudfront', [
                    'urls' => $urls,
                ]);
            }
        }
    }

    protected function generatePdf($model, $route = null)
    {
        if (empty($route)) {
            $route = self::route($model);
        }

        if (empty($route)) {
            return false;
        }

        $path = null;

        if (get_class($model) == DigitalPublicationSection::class) {
            $path = route($route, [
                'pubId' => $model->digitalPublication->id,
                'pubSlug' => $model->digitalPublication->getSlug(),
                'id' => $model->id,
                'slug' => $model->getSlug(),
            ], false);
        } else {
            $path = route($route, [
                'id' => $model->id,
                'slug' => $model->getSlug(),
            ], false);
        }

        $baseUrl = config('aic.protocol') . '://' . config('app.url');
        $fullUrl = $baseUrl . $path;

        // Now, produce the PDF
        $prince = new Prince(config('aic.prince_command'));
        $prince->setBaseURL($baseUrl);
        $prince->setMedia('print');

        if (config('app.debug') || config('aic.pdf_debug')) {
            $prince->setVerbose(true);
            $prince->setLog(storage_path('logs/prince-' . date('Y-m-d') . '.log'));
        }

        set_time_limit(0);
        $html = Http::get($fullUrl, ['print' => true])->body();

        $pdfFileName = self::pdfFileName($model);
        $pdfPath = storage_path('app/' . $pdfFileName);
        $prince->convertStringToFile($html, $pdfPath);

        if (config('aic.pdf_s3_enabled')) {
            // Stream the file to S3; be sure to set `AWS_BUCKET` in `.env` and otherwise configure credentials
            Storage::disk('pdf_s3')->putFileAs(self::STORAGE_PATH, new File($pdfPath), $pdfFileName, 'public');
        }

        if ($model->pdf_download_path != self::pdfDownloadPath($pdfFileName)) {
            $model->pdf_download_path = self::pdfDownloadPath($pdfFileName);
            $model->save();
        }
        $class = class_basename($model);
        $this->info("Generated PDF for {$class} with ID {$model->id}");
    }

    public static function pdfFileName(AbstractModel $model): string
    {
        $route = self::route($model);
        return 'download-' . $route . '-' . $model->id . '.pdf';
    }

    public static function pdfDownloadPath($pdfFileName): string
    {
        return self::STORAGE_PATH . $pdfFileName;
    }

    public static function route($model): string
    {
        return array_search(get_class($model), self::$models);
    }
}
