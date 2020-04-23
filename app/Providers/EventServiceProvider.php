<?php

namespace App\Providers;

use Auth;
use A17\Twill\Repositories\UserRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\Event' => [
        //     'App\Listeners\EventListener',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('App\Events\TileMedia', function ($event) {
            $iiifMedia = $event->item;

            $iiifMediaUuid = get_clean_media_uuid($iiifMedia);

            $s3 = Storage::disk(config('twill.media_library.disk'));
            $local = Storage::disk('local');
            $iiifS3 = Storage::disk('iiif_s3');

            $localFilename = $iiifMediaUuid;

            // No need to do all this work if the tiles have been generated..?
            // if ($iiifS3->exists('iiif/static/' . $localFilename)) {
            //     return true;
            // }

            if ($local->exists('tiles/src/' . $localFilename)) {
                $local->delete('tiles/src/' . $localFilename);
            }

            // https://stackoverflow.com/questions/47581934/copying-a-file-using-2-disks-with-laravel
            $local->writeStream('tiles/src/' . $localFilename, $s3->readStream($iiifMedia->uuid));

            exec(base_path() . '/bin/tile.sh ' . escapeshellarg($localFilename) . ' ' . config('aic.iiif_s3_endpoint') . ' >> ' . base_path() . '/bin/tile.log');

            // This won't happen since we exited early, but if that check is removed, we need this
            if ($iiifS3->exists('iiif/static/' . $localFilename)) {
                $iiifS3->deleteDirectory('iiif/static/' . $localFilename);
            }

            // There's probably a quicker way to transfer an entire directory to S3, but this'll do for now
            // https://bakerstreetsystems.com/blog/post/recursively-transfer-entire-directory-amazon-s3-laravel-52
            // https://stackoverflow.com/questions/44900585/aws-s3-copy-and-replicate-folder-in-laravel
            $files = $local->allFiles('tiles/out/iiif/static/' . $localFilename);
            foreach ($files as $file) {
                $iiifS3->writeStream(substr($file, 10) , $local->readStream($file));
            }

            $local->delete('tiles/src/' . $localFilename);
            $local->deleteDirectory('tiles/tmp/' . $localFilename);
            $local->deleteDirectory('tiles/out/iiif/static/' . $localFilename);
        });

        Event::listen('Aacotroneo\Saml2\Events\Saml2LoginEvent', function ($event) {
            $messageId = $event->getSaml2Auth()->getLastMessageId();
            // your own code preventing reuse of a $messageId to stop replay attacks
            $user = $event->getSaml2User();
            $userData = [
                // 'id' => $user->getUserId(),
                'email' => Arr::first($user->getAttribute('email')),
                'name' => Arr::first($user->getAttribute('email')),
                'role' => 'VIEW_ONLY',
            ];

            $aicUser = app(UserRepository::class)->firstOrCreate(['email' => $userData['email']], $userData);
            Auth::login($aicUser);
        });

        Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function ($event) {
            Auth::logout();
            Session::save();
        });
    }
}
