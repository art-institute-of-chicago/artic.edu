<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Models\FeeAge;
use App\Models\FeeCategory;
use App\Repositories\FeeRepository;

class FeeController extends ModuleController
{
    public function __construct(FeeRepository $fees)
    {
        $this->fees = $fees;
        $this->request = request();
    }

    public function index($parentModuleId = null)
    {
        $feeCategories = FeeCategory::ordered()->get();
        $feeAges = FeeAge::ordered()->get();

        return view('admin.fees.index', [
            'customForm' => true,
            'editableTitle' => false,
            'customTitle' => 'Update admission fees',
            'form_fields' => $this->fees->getFormFields(),
            'feeCategories' => $feeCategories,
            'feeAges' => $feeAges,
            'saveUrl' => route('admin.landing.visit.fees.update'),
            'publish' => false,
        ]);
    }

    public function update($id, $submoduleId = null)
    {
        if (array_key_exists('cancel', request()->all())) {
            return redirect()->route('admin.landing.visit.fees.update');
        }

        $this->fees->update(request()->except('_token'));

        $this->fireEvent();

        return redirect()->route('admin.landing.visit.fees.update');

    }
}
