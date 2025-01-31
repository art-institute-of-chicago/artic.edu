<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Columns\Relation;

class FeeController extends \App\Http\Controllers\Twill\ModuleController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->setModuleName('fees');
        $this->setTitleColumnKey('fee_category.title');
        $this->setTitleColumnLabel('Category');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = new TableColumns();
        $columns->add(
            Relation::make()
                ->field('title')
                ->title('Age')
                ->relation('fee_age')
        );

        $columns->add(
            Text::make()
                ->title('Price')
                ->field('price')
                ->optional()
        );

        return $columns;
    }

    // protected FeeRepository $fees;

    // public function __construct(FeeRepository $fees)
    // {
    //     $this->fees = $fees;
    //     $this->request = request();
    // }

    // public function index($parentModuleId = null): mixed
    // {
    //     $feeCategories = FeeCategory::ordered()->get();
    //     $feeAges = FeeAge::ordered()->get();

    //     return view('twill.fees.index', [
    //         'customForm' => true,
    //         'editableTitle' => false,
    //         'customTitle' => 'Update admission fees',
    //         'form_fields' => $this->fees->getFormFields(),
    //         'feeCategories' => $feeCategories,
    //         'feeAges' => $feeAges,
    //         'saveUrl' => route('twill.visit.fees.update'),
    //         'publish' => false,
    //     ]);
    // }

    // public function update($id, $submoduleId = null): \Illuminate\Http\JsonResponse
    // {
    //     if (array_key_exists('cancel', request()->all())) {
    //         return redirect()->route('twill.visit.fees.update');
    //     }

    //     $this->fees->update(request()->except('_token'));

    //     $this->fireEvent();

    //     return redirect()->route('twill.visit.fees.update');
    // }
}
