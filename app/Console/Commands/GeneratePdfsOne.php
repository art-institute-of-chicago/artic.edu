<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\IssueArticle;
use Prince\Prince;

class GeneratePdfsOne extends GeneratePdfs
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdfs:generate-one {model} {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate downloadable PDF for a single record.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!empty($this->argument('model')) && !empty($this->argument('id'))) {
            $modelClass = $this->argument('model');
            $id = $this->argument('id');
            $model = $modelClass::published()->find($id);

            if ($model) {
                $this->generatePdf($model);

                $this->call('cache:invalidate-cloudfront', [
                    'urls' => [
                        $model->pdf_download_path,
                    ],
                ]);
            }
        }
    }
}
