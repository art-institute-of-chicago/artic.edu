<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\Article;
use App\Repositories\ExperienceRepository;
use App\Repositories\SlideRepository;

class ExperienceSlideController extends ModuleController
{
    protected $moduleName = 'experiences.slides';
    protected $modelName = 'Slide';
    protected $previewView = 'site.experienceDetail';

    protected function getParentModuleForeignKey()
    {
        return 'experience_id';
    }

    protected $indexOptions = [
        'reorder' => true,
        'permalink' => false,
    ];

    protected function indexData($request)
    {
        $experience = app(ExperienceRepository::class)->getById(request('experience'));
        $interactiveFeature = $experience->interactiveFeature;
        return [
            'breadcrumb' => [
                [
                    'label' => 'Groupings',
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'index'),
                ],
                [
                    'label' => $interactiveFeature->title,
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'edit', $interactiveFeature->id),
                ],
                [
                    'label' => 'Experiences',
                    'url' => moduleRoute('interactiveFeatures.experiences', 'collection', 'index', $experience->interactiveFeature->id),
                ],
                [
                    'label' => $experience->title,
                    'url' => moduleRoute('interactiveFeatures.experiences', 'collection', 'edit', [$interactiveFeature->id, $experience->id]),
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
        $interactiveFeature = $experience->interactiveFeature;
        $slide = app(SlideRepository::class)->getById(request('slide'));
        $slides = $this->repository->get([], ['experience_id' => $experience->id], ['position' => 'asc']);
        $currentSlideIndex = $slides->search($slide);
        return [
            'parentPreviousUrl' => $currentSlideIndex !== false && $currentSlideIndex > 0 ? $this->getModuleRoute($slides[$currentSlideIndex - 1], 'edit') : '',
            'parentNextUrl' => $currentSlideIndex !== false && $currentSlideIndex < $slides->count() - 1 ? $this->getModuleRoute($slides[$currentSlideIndex + 1], 'edit') : '',
            'parents' => $slides->map(function ($slide) {
                return [
                    'id' => $slide->id,
                    'name' => $slide->title,
                    'edit' => $this->getModuleRoute($slide->id, 'edit')
                ];
            }),
            'breadcrumb' => [
                [
                    'label' => 'Groupings',
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'index'),
                ],
                [
                    'label' => $interactiveFeature->title,
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'edit', $interactiveFeature->id),
                ],
                [
                    'label' => 'Experiences',
                    'url' => moduleRoute('interactiveFeatures.experiences', 'collection', 'index', $experience->interactiveFeature->id),
                ],
                [
                    'label' => $experience->title,
                    'url' => moduleRoute('interactiveFeatures.experiences', 'collection', 'edit', [$interactiveFeature->id, $experience->id]),
                ],
                [
                    'label' => 'Slides',
                    'url' => moduleRoute('experiences.slides', 'collection', 'index', $experience->id),
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

    public function destroy($id, $submoduleId = null)
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
