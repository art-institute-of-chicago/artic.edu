<?php

namespace App\Console\Commands;

use App\Models\CustomTour;
use App\Mail\MyMuseumTourConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class SendConfirmations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to go through My Museum Tours and send email confirmations';

    /**
     * Array of models to generate PDFs for. Format is `route => model class`
     */
    protected static array $models = [
        'custom-tours.show' => CustomTour::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (self::$models as $route => $modelClass) {
            $models = $modelClass::notSent()->get();

            foreach ($models as $model) {
                try {
                    $this->sendConfirmation($model, $route);
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    return 1;
                }
            }
        }
    }

    protected function sendConfirmation($model, $route = null)
    {
        $route = empty($route) ? self::route($model) : $route;
        if (empty($route)) {
            return false;
        }

        set_time_limit(0);

        Mail::to($model->creator_email)->send(new MyMuseumTourConfirmation($model));

        $model->confirmation_sent = true;
        if ($model->isDirty('confirmation_sent')) {
            $model->save();
        }

        $class = class_basename($model);
        $this->info("Confirmation sent for {$class} ID {$model->id}");
    }

    protected function path($model, $route): string
    {
        return route($route, ['id' => $model->id], false);
    }

    protected static function route($model): string
    {
        return array_search(get_class($model), self::$models);
    }
}
