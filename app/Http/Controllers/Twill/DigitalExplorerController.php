<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\DigitalExplorerRepository;

class DigitalExplorerController extends BaseController
{

  protected function setUpController(): void
  {
    $this->setModuleName('digitalExplorers');
  }

  protected function formData($request)
    {
        $item = $this->repository->getById(request('digitalExplorer') ?? request('id'));
        $baseUrl = config('app.url') . '/digitalExplorers/' . $item->id . '/';

        return [
            // 'autoRelated' => $this->getAutoRelated($item),
            // 'featuredRelated' => $this->getFeatureRelated($item),
            'categoriesList' => app(DigitalExplorerRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }

}