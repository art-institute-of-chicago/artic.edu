<?php

namespace App\Console\Commands;

use App\Models\MyMuseumTour;
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
        'my-museum-tour.show' => MyMuseumTour::class,
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

        $this->send($model);
        $model->confirmation_sent = true;
        $model->save();

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

    protected function send($model)
    {
        $to = $model->creator_email;
        $apiCode = config('sendgrid.api_key');
        $sender = config('sendgrid.email');
        $templateId = config('sendgrid.template_id');

        $baseUrl = config('aic.protocol') . '://' . config('app.url');
        $tourUrl = $baseUrl . route('my-museum-tour.show', [ 'id' => $model->id ], false);

        $dynamicContent = [
            'personalizations' => [
                [
                    'to' => [
                        [
                            'email' => $to
                        ]
                    ],
                    'dynamic_template_data' => [
                        'name' => $model->tour_json['creatorName'],
                        'tour_name' => $model->tour_json['title'],
                        'tour_url' => $tourUrl,
                    ]
                ]
            ],
            'from' => [
                'email' => $sender
            ],
            'template_id' => $templateId,
        ];

        if (!\App::environment('local')) {
            $dynamicContent = array_merge($dynamicContent, [
                'attachments' => [
                    [
                        'content' => base64_encode(file_get_contents($baseUrl . $model->pdf_download_path)),
                        'type' => 'application/pdf',
                        'filename' => 'my_museum_tour-' . $model->id . '.pdf',
                        'disposition' => 'attachment'
                    ],
                ],
            ]);
        }

        $sendgridurl = config('sendgrid.api_url');

        $sendmail = curl_init();
        curl_setopt($sendmail, CURLOPT_POST, 1);
        curl_setopt($sendmail, CURLOPT_POSTFIELDS, json_encode($dynamicContent));
        curl_setopt($sendmail, CURLOPT_URL, $sendgridurl);
        curl_setopt($sendmail, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($sendmail, CURLOPT_HTTPHEADER, array("Authorization: Bearer $apiCode", "Content-Type: application/json;charset=UTF-8"));
        curl_setopt($sendmail, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $createResult = curl_exec($sendmail);
        curl_close($sendmail);
        $result = json_decode($createResult);
        return response()->json(["result" => $result, "message" => "Mail sent successfully"], 200);
    }
}
