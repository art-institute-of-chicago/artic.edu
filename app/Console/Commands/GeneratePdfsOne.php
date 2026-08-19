<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;

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
     */
    public function handle()
    {
        if (!$this->initializePrince()) {
            return 1;
        }
        if (!empty($this->argument('model')) && !empty($this->argument('id'))) {
            $modelClass = $this->argument('model');
            $id = $this->argument('id');
            $model = $modelClass::find($id);

            if ($model) {
                try {
                    $this->generatePdf($model);
                } catch (\Exception $exception) {
                    $command = class_basename($this);
                    $class = class_basename($modelClass);
                    $message = "$class $model->id: {$exception->getMessage()}";
                    Log::channel('sentry_logs')->error("$command: $message");
                    $this->error($message);
                    return 1;
                }

                $this->call('cache:invalidate-cdn', [
                    'urls' => [
                        $model->pdf_download_path,
                    ],
                ]);
            }
        }
    }
}
