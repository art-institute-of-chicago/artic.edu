<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\CategoryRepository;

class VideoController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('videos');
        $this->setPreviewView('site.videoDetail');
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('video') ?? request('id'));
        $baseUrl = config('app.url') . '/videos/' . $item->id . '-';

        return [
            'baseUrl' => $baseUrl,
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
