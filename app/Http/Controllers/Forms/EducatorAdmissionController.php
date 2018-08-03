<?php

namespace App\Http\Controllers\Forms;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\EducatorAdmissionRequest;

use App\Models\Form\EducatorAdmission;

use App\Mail\FormEducatorAdmission;

use App\Presenters\StaticObjectPresenter;

class EducatorAdmissionController extends FormController
{
    public function index()
    {

        $blocks = array();
        $formBlocks = array();
        $registrationInformationFields = array();

        $errors = session('errors');

        /*
         *
         *  Registration information
         *
         */
        $registrationInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'name',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('name'),
                  'error' => (!empty($errors) && $errors->first('name')) ? $errors->first('name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Name *',
                ),
            ),
        );

        $registrationInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'email',
                  'variation' => null,
                  'id' => 'email',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('email'),
                  'error' => (!empty($errors) && $errors->first('email')) ? $errors->first('email') : null,
                  'optional' => false,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Email *',
                ),
            ),
        );

        $registrationInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'date-select',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'visit_date',
                  'placeholder' => 'mm/dd/yy',
                  'value' => old('visit_date'),
                  'error' => (!empty($errors) && $errors->first('visit_date')) ? $errors->first('visit_date') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Visit date *',
                ),
            ),
        );

        $registrationInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'select',
                  'variation' => null,
                  'id' => 'school_location',
                  'error' => (!empty($errors) && $errors->first('school_location')) ? $errors->first('school_location') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'value' => old('school_location'),
                  'label' => 'School Location *',
                  'options' => $this->getSchoolLocationArray(),
                ),
            ),
        );

        $registrationInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'select',
                  'variation' => null,
                  'id' => 'type_of_educator',
                  'error' => (!empty($errors) && $errors->first('type_of_educator')) ? $errors->first('type_of_educator') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'value' => old('type_of_educator'),
                  'label' => 'Type of Educator *',
                  'options' => $this->getTypeOfEducatorArray(),
                ),
            ),
        );

        $registrationInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'grades_taught',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('grades_taught'),
                  'error' => (!empty($errors) && $errors->first('grades_taught')) ? $errors->first('grades_taught') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Grades Taught *',
                ),
            ),
        );

        $registrationInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'subjects_taught',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('subjects_taught'),
                  'error' => (!empty($errors) && $errors->first('subjects_taught')) ? $errors->first('subjects_taught') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Subjects Taught *',
                ),
            ),
        );

        $registrationInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'captcha',
                  'variation' => null,
                  'id' => 'captcha',
                  'error' => (!empty($errors) && $errors->first('captcha')) ? $errors->first('captcha') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => '',
                ),
            ),
        );

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $registrationInformationFields,
          'legend' => 'Registration Information',
        ));

        array_push($blocks, array(
          'type' => 'text',
          'content' => '<p>Free admission to the Art Institute of Chicago is available to current Illinois educators, including pre-K–12 teachers, teaching artists working in schools, and homeschool parents. Educators can register here to receive a voucher for a complimentary ticket to the museum. This voucher must be presented at one of the museum’s admission counters with a valid educator ID.</p>'
          .'<p>A complimentary ticket will not be granted without one of the following forms of acceptable identification:</p>'
          .'<p>Pre-K–12 teachers'
          .'<ul>'
          .'<li>Current school ID</li>'
          .'<li>Current Illinois Education Association ID card</li>'
          .'</ul>'
          .'</p>'

          .'<p>Teaching Artist Working in Schools'
          .'<ul>'
          .'<li>Letter on school letterhead indicating that the teaching artist is currently working in an Illinois pre-K–12 school</li>'
          .'</ul>'
          .'</p>'

          .'<p>Homeschool Parents'
          .'<ul>'
          .'<li>Illinois homeschool co-op member ID card</li>'
          .'<li>Illinois homeschool legal defense association member ID card</li>'
          .'</ul>'
          .'</p>'

          .'<p>Illinois Educator Admission Requests may not be used in conjunction with Student Tours or Groups. For more information, visit <a href="/learn-with-us/educators/visit-with-my-students">Student Tours</a>.</p>'
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/educators/visit-on-my-own/educator-admission-request',
            'method' => 'POST',
            'blocks' => $formBlocks,
            'actions' => array(
                array(
                    'variation' => null,
                    'type' => 'submit',
                    'label' => "Submit",
                )
            )
        ));

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => 'Educator Admission Request',
            'breadcrumb' => [],
            'blocks' => $blocks
        ];

        return view('site.forms.form', $view_data);
    }

    /**
     * @param EducatorAdmissionRequest $request
     */
    public function store(EducatorAdmissionRequest $request)
    {

        $validated = $request->validated();

        $educatorAdmission = new EducatorAdmission;

        $educatorAdmission->name = $validated['name'] ?? '';
        $educatorAdmission->email = $validated['email'] ?? '';
        $educatorAdmission->visit_date = Carbon::parse($validated['visit_date']) ?? '';
        $educatorAdmission->phone_number = $validated['phone_number'] ?? '';
        $educatorAdmission->address_1 = $validated['address_1'] ?? '';
        $educatorAdmission->address_2 = $validated['address_2'] ?? '';
        $educatorAdmission->city = $validated['city'] ?? '';
        $educatorAdmission->state = $validated['state'] ?? '';
        $educatorAdmission->zipcode = $validated['zipcode'] ?? '';

        $educatorAdmission->school_name = $validated['school_name'] ?? '';
        $educatorAdmission->school_city = $validated['school_city'] ?? '';
        $educatorAdmission->school_state = $validated['school_state'] ?? '';
        $educatorAdmission->school_location = $validated['school_location'] ?? '';
        $educatorAdmission->type_of_educator = $validated['type_of_educator'] ?? '';
        $educatorAdmission->grades_taught = $validated['grades_taught'] ?? '';
        $educatorAdmission->subjects_taught = $validated['subjects_taught'] ?? '';

        Mail::to(config('forms.email_educator_admission_to'))
            ->send(new FormEducatorAdmission($educatorAdmission));

        return redirect(route('forms.educator-admission-request.thanks'));

    }

    private function getSchoolLocationArray()
    {
        $topics = array('Chicago Public Schools (CPS)',
                        'Other Chicago schools',
                        'Suburbs (Cook County)',
                        'Suburbs (DuPage, Kane, Lake, McHenry, Will County)',
                        'Other Illinois',
        );

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($topics as $value => $label) {
            $item = [
                'value' => $label
            ,   'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }

    private function getTypeOfEducatorArray()
    {
        $topics = array('Pre-K–12 teacher',
                        'Teaching artist in a pre-K–12 school',
                        'Homeschool educator',
        );

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($topics as $value => $label) {
            $item = [
                'value' => $label
            ,   'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }


}
