<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\FeeRepository;
use App\Models\FeeCategory;
use App\Models\FeeAge;

use Illuminate\Routing\Controller;


class FeeController extends Controller
{
    public function __construct(FeeRepository $fees)
    {
        $this->fees = $fees;
    }

    public function index()
    {
        $feeCategories = FeeCategory::ordered()->get();
        $feeAges       = FeeAge::ordered()->get();

        return view('admin.fees.index', [
            'form_fields'   => $this->fees->getFormFields(),
            'feeCategories' => $feeCategories,
            'feeAges'       => $feeAges,
        ]);
    }

    public function update()
    {
        $this->fees->update(request()->except('_token'));

        return redirect()->back();
    }
}
