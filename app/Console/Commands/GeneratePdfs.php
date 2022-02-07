<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\IssueArticle;
use App\Models\DigitalPublicationSection;
use Prince\Prince;

class GeneratePdfs extends Command
{
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
     *
     * @var array
     */
    protected $models = [
        'issue-articles.show' => IssueArticle::class,
        'collection.publications.digital-publications-sections.show' => DigitalPublicationSection::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->models as $route => $modelClass) {
            $models = $modelClass::published()->get();

            foreach ($models as $model) {
                $this->generatePdf($model, $route);
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
            $route = array_search(get_class($model), $this->models);
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

        // Check that the prince command exists
        $commandCheck = 'command -v ' . config('aic.prince_command');

        if (!shell_exec($commandCheck)) {
            throw new \Exception('Could not found prince command line command.');
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
        $html = file_get_contents($fullUrl . '?print=true');

        $pdfFileName = 'download-' . $route . '-' . $model->id . '.pdf';
        $pdfPath = storage_path('app/' . $pdfFileName);
        $prince->convert_string_to_file($html, $pdfPath);

        if (config('aic.pdf_s3_enabled')) {
            // Stream the file to S3; be sure to set `AWS_BUCKET` in `.env` and otherwise configure credentials
            Storage::disk('pdf_s3')->putFileAs('/pdf/static', new File($pdfPath), $pdfFileName, 'public');
        }

        if ($model->pdf_download_path != '/pdf/static/' . $pdfFileName) {
            $model->pdf_download_path = '/pdf/static/' . $pdfFileName;
            $model->save();
        }
    }
}
