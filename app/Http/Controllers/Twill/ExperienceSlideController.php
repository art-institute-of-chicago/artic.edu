<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Article;
use App\Repositories\ExperienceRepository;
use App\Repositories\SlideRepository;

class ExperienceSlideController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->enableReorder();
        $this->setModelName('Slide');
        $this->setModuleName('experiences.slides');
        $this->setPreviewView('site.experienceDetail');
    }

    // Replace the default title field with an unsortable version.
    protected function getIndexTableColumns(): TableColumns
    {
        $columns = parent::getIndexTableColumns();
        return $columns->map(function ($column) {
            if ($column->getKey() == $this->titleColumnKey) {
                $column = Text::make()
                    ->field($this->titleColumnKey)
                    ->title($this->titleColumnLabel)
                    ->linkToEdit()
                    ->sortable(false);
            }
            return $column;
        });
    }

    protected function getParentModuleForeignKey()
    {
        return 'experience_id';
    }

    protected function indexData($request)
    {
        $experience = app(ExperienceRepository::class)->getById(request('experience'));

        return [
            'breadcrumb' => [
                [
                    'label' => 'Experiences',
                    'url' => moduleRoute('experiences', 'collection.interactiveFeatures', 'index'),
                ],
                [
                    'label' => $experience->title,
                    'url' => moduleRoute('experiences', 'collection.interactiveFeatures', 'edit', [$experience->id]),
                ],
                [
                    'label' => 'Slides',
                ],

            ],
        ];
    }

    protected function formData($request)
    {
        $experience = app(ExperienceRepository::class)->getById(request('experience'));
        $slide = app(SlideRepository::class)->getById(request('slide'));
        $slides = $this->repository->get([], ['experience_id' => $experience->id], ['position' => 'asc']);
        $currentSlideIndex = $slides->search($slide);

        return [
            'parentPreviousUrl' => $currentSlideIndex !== false && $currentSlideIndex > 0 ? moduleRoute($this->moduleName, $this->routePrefix, 'edit', ['slide' => $slides[$currentSlideIndex - 1]]) : '',
            'parentNextUrl' => $currentSlideIndex !== false && $currentSlideIndex < $slides->count() - 1 ? moduleRoute($this->moduleName, $this->routePrefix, 'edit', ['slide' => $slides[$currentSlideIndex + 1]]) : '',
            'parents' => $slides->map(function ($slide) {
                return [
                    'id' => $slide->id,
                    'name' => $slide->title,
                    'edit' => moduleRoute($this->moduleName, $this->routePrefix, 'edit', ['slide' => $slide->id])
                ];
            }),
            'breadcrumb' => [
                [
                    'label' => 'Experiences',
                    'url' => moduleRoute('experiences', 'collection.interactiveFeatures', 'index'),
                ],
                [
                    'label' => $experience->title,
                    'url' => moduleRoute('experiences', 'collection.interactiveFeatures', 'edit', [$experience->id]),
                ],
                [
                    'label' => 'Slides',
                    'url' => moduleRoute('experiences.slides', 'collection.interactiveFeatures', 'index', [$experience->id]),
                ],
                [
                    'label' => $slide->title,
                ],

            ],
        ];
    }

    protected function previewData($item)
    {
        $experience = $item->experience;

        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->paginate(4);

        return [
            'singleSlide' => true,
            'contrastHeader' => true,
            'experience' => $experience,
            'slide' => $item,
            'furtherReading' => $articles,
            'canonicalUrl' => route('interactiveFeatures.show', ['id' => $experience->id, 'slug' => $experience->titleSlug]),
        ];
    }

    public function destroy($id, $submoduleId = null): \Illuminate\Http\JsonResponse
    {
        $item = $this->repository->getById($submoduleId);

        if ($this->repository->delete($submoduleId ?? $id)) {
            $this->fireEvent();
            activity()->performedOn($item)->log('deleted');

            return $this->respondWithSuccess($this->modelTitle . ' moved to trash!');
        }

        return $this->respondWithError($this->modelTitle . ' was not moved to trash. Something wrong happened!');
    }
}
