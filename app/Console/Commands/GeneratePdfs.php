<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\IssueArticle;
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
    protected $description = 'Command to go through all pages with a download option and generate downkloadable PDFs.';

    /**
     * Array of models to generate PDFs for. Format is `route => model class`
     *
     * @var array
     */
    protected $models = [
        'issue-articles.show' => IssueArticle::class,
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->models as $route => $modelClass) {
            foreach ($modelClass::published()->get() as $model) {
                $path = route($route, ['id' => $model->id, 'slug' => $model->getSlug()]);

                // Check that the prince command exists
                $commandCheck = 'which ' . config('aic.prince_command');
                if (!`$commandCheck`) {
                    $this->error('Could not found prince command line command.');
                    exit(1);
                }

                // Now, produce the PDF
                $prince = new Prince(config('aic.prince_command'));
                $prince->setBaseURL(config('aic.protocol') . '://' . config('app.url'));
                $prince->setMedia('print');
                if (config('app.env') !== 'production')
                {
                    $prince->setVerbose(true);
                }

                if (config('app.debug')) {
                    $prince->setVerbose(true);
                    $prince->setLog(storage_path('logs/prince-' .date('Y-m-d') .'.log'));
                }

                set_time_limit(0);
                $html = file_get_contents($path . "?print=true");

                $prince->convert_string_to_file($html, storage_path('app/download-' . $route . '-' . $model->id . '.pdf'));
            }
        }
    }
}
