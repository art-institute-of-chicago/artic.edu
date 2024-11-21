<?php

namespace App\Http\Controllers\Twill;

use App\Models\FeeAge;
use App\Models\FeeCategory;
use App\Repositories\FeeRepository;

class FeeController extends \App\Http\Controllers\Twill\ModuleController
{
    public function __construct(FeeRepository $fees)
    {
        $this->fees = $fees;
        $this->request = request();
    }

    public function index($parentModuleId = null): mixed
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
            'saveUrl' => route('admin.visit.fees.update'),
            'publish' => false,
        ]);
    }

    public function update($id, $submoduleId = null): \Illuminate\Http\JsonResponse
    {
        if (array_key_exists('cancel', request()->all())) {
            return redirect()->route('admin.visit.fees.update');
        }

        $this->fees->update(request()->except('_token'));

        $this->fireEvent();

        return redirect()->route('admin.visit.fees.update');
    }
}
