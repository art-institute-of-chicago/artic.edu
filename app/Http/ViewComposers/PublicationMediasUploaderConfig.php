<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use A17\Twill\Http\ViewComposers\MediasUploaderConfig;

class PublicationMediasUploaderConfig extends MediasUploaderConfig
{
    /**
     * Binds data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $libraryDisk = $this->config->get('twill.publication_media_library.disk');
        $endpointType = $this->config->get('twill.publication_media_library.endpoint_type');
        $allowedExtensions = $this->config->get('twill.publication_media_library.allowed_extensions');

        // anonymous functions are used to let configuration dictate
        // the execution of the appropriate implementation
        $endpointByType = [
            'local' => function () {
                return $this->urlGenerator->route('admin.media-library.publication-medias.store');
            },
            's3' => function () use ($libraryDisk) {
                return s3Endpoint($libraryDisk);
            },
            'azure' => function () use ($libraryDisk) {
                return azureEndpoint($libraryDisk);
            },
        ];

        $signatureEndpointByType = [
            'local' => null,
            's3' => $this->urlGenerator->route('admin.media-library.sign-s3-upload'),
            'azure' => $this->urlGenerator->route('admin.media-library.sign-azure-upload'),
        ];

        $publicationMediasUploaderConfig = [
            'endpointType' => $endpointType,
            'endpoint' => $endpointByType[$endpointType](),
            'successEndpoint' => $this->urlGenerator->route('admin.media-library.publication-medias.store'),
            'signatureEndpoint' => $signatureEndpointByType[$endpointType],
            'endpointBucket' => $this->config->get('filesystems.disks.' . $libraryDisk . '.bucket', 'none'),
            'endpointRegion' => $this->config->get('filesystems.disks.' . $libraryDisk . '.region', 'none'),
            'endpointRoot' => $endpointType === 'local' ? '' : $this->config->get('filesystems.disks.' . $libraryDisk . '.root', ''),
            'accessKey' => $this->config->get('filesystems.disks.' . $libraryDisk . '.key', 'none'),
            'csrfToken' => $this->sessionStore->token(),
            'acl' => $this->config->get('twill.media_library.acl'),
            'filesizeLimit' => $this->config->get('twill.media_library.filesize_limit'),
            'allowedExtensions' => $allowedExtensions,
        ];

        $view->with(compact('publicationMediasUploaderConfig'));
    }
}
