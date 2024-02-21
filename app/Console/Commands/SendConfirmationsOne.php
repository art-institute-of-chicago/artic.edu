<?php

namespace App\Console\Commands;

use App\Models\MyMuseumTour;
use App\Mail\MyMuseumTourConfirmation;
use Illuminate\Support\Facades\Mail;

use App\Models\AbstractModel;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class SendConfirmationsOne extends SendConfirmations
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:confirmations-one {model} {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to go send a single My Museum Tours email confirmations';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!empty($this->argument('model')) && !empty($this->argument('id'))) {
            $modelClass = $this->argument('model');
            $id = $this->argument('id');
            $model = $modelClass::find($id);

            if ($model) {
                try {
                    $this->sendConfirmation($model);
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    return 1;
                }
            }
        }
    }
}
