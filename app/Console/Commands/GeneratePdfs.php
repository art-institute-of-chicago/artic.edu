<?php

namespace App\Console\Commands;

use App\Models\MyMuseumTour;
use App\Models\DigitalPublicationSection;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Prince\Prince;

class GeneratePdfs extends Command
{
    public const BUCKET_PATH = '/pdf/static/';

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
        'my-museum-tour.pdf-layout' => MyMuseumTour::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (self::$models as $route => $modelClass) {
            $models = method_exists($modelClass, 'published') ? $modelClass::published()->get() : $modelClass::get();

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
        $route = empty($route) ? self::route($model) : $route;
        if (empty($route)) {
            return false;
        }
        $baseUrl = config('aic.protocol') . '://' . config('app.url');
        $fullUrl = $baseUrl . $this->path($model, $route);

        // Now, produce the PDF
        $prince = new Prince(config('aic.prince_command'));
        $prince->setBaseURL($baseUrl);
        $prince->setMedia('print');
        $prince->setFailMissingResources(true);

        if (config('app.debug') || config('aic.pdf_debug')) {
            $prince->setVerbose(true);
            $prince->setLog(storage_path('logs/prince-' . date('Y-m-d') . '.log'));
        }

        set_time_limit(0);
        $html = Http::get($fullUrl, ['print' => true])->body();
        $fileName = self::fileName($model);
        $class = class_basename($model);
        if ($prince->convertStringToFile($html, self::localPath($fileName))) {
            $this->storePdf($fileName);
        } else {
            throw new \Exception("Prince was unable to generate a PDF for {$class} with ID {$model->id}");
        }

        $model->pdf_download_path = self::downloadPath($fileName);
        if ($model->isDirty('pdf_download_path')) {
            $model->save();
        }

        $this->info("Generated PDF for {$class} with ID {$model->id}");
    }

    protected function path($model, $route): string
    {
        return route($route, [
            'pubId' => $model?->digitalPublication?->id,
            'pubSlug' => $model?->digitalPublication ? $model?->digitalPublication?->getSlug() : null,
            'id' => $model->id,
            'slug' => method_exists($model, 'getSlug') ? $model->getSlug() : null,
        ], false);
    }

    /**
     * Stream the file to S3 then remove the local copy. Be sure to set
     * `AWS_BUCKET` in `.env` and otherwise configure credentials.
     */
    protected function storePdf($fileName): void
    {
        if (config('aic.pdf_s3_enabled')) {
            $localPath = self::localPath($fileName);
            Storage::disk('pdf_s3')->putFileAs(
                self::BUCKET_PATH,
                new File($localPath),
                $fileName,
                'public'
            );
            unlink($localPath);
        }
    }

    public static function fileName(Model $model): string
    {
        $route = self::route($model);
        return 'download-' . $route . '-' . $model->id . '.pdf';
    }

    public static function localPath($fileName): string
    {
        return storage_path('app/' . $fileName);
    }

    public static function downloadPath($fileName): string
    {
        return self::BUCKET_PATH . $fileName;
    }

    protected static function route($model): string
    {
        return array_search(get_class($model), self::$models);
    }
}
