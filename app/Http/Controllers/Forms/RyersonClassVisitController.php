<?php

namespace App\Http\Controllers\Forms;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\RyersonClassVisitRequest;

use App\Models\Form\RyersonClassVisit;

use App\Mail\FormRyersonClassVisit;

use App\Presenters\StaticObjectPresenter;

class RyersonClassVisitController extends FormController
{
    public function index()
    {

        $this->title = 'Schedule a Class Visit';
        $this->seo->setTitle($this->title);

        $blocks = array();
        $formBlocks = array();
        $contactInformationFields = array();
        $institutionInformationFields = array();
        $courseInformationFields = array();
        $visitInformationFields = array();

        $errors = session('errors');

        /*
         *
         *  Contact information
         *
         */
        $contactInformationFields[]= array(
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
                  'optional' => false,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Name *',
                ),
            ),
        );

        $contactInformationFields[]= array(
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

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'tel',
                  'variation' => null,
                  'id' => 'phone_number',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('phone_number'),
                  'error' => (!empty($errors) && $errors->first('phone_number')) ? $errors->first('phone_number') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Phone number',
                ),
            ),
        );

        /*
         *
         *  Institution information
         *
         */
        $affiliationFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('affiliation')) ? $errors->first('affiliation') : null,
                  'optional' => false,
                  'hint' => null,
                  'label' => 'Affiliation *',
                )
            ),
        ];
        foreach($this->getAffiliationArray(old('affiliation')) as $t) {
            array_push($affiliationFields['blocks'], $t);
        }
        $institutionInformationFields[] = $affiliationFields;

        $institutionInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'non_saic_institution',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('non_saic_institution'),
                  'error' => (!empty($errors) && $errors->first('non_saic_institution')) ? $errors->first('non_saic_institution') : null,
                  'optional' => null,
                  'hint' => 'If a Non-SAIC program, please provide the institution name.',
                  'disabled' => false,
                  'label' => 'Non-SAIC Institution',
                ),
            ),
        );

        $institutionInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'department',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('department'),
                  'error' => (!empty($errors) && $errors->first('department')) ? $errors->first('department') : null,
                  'optional' => false,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Department *',
                ),
            ),
        );

        $institutionInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'course_title',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('course_title'),
                  'error' => (!empty($errors) && $errors->first('course_title')) ? $errors->first('course_title') : null,
                  'optional' => false,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Course Title *',
                ),
            ),
        );

        $institutionInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'course_level',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('course_level'),
                  'error' => (!empty($errors) && $errors->first('course_level')) ? $errors->first('course_level') : null,
                  'optional' => false,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Course Level *',
                ),
            ),
        );

        /*
         *
         *  Course information
         *
         */
        $daysClassMeetsFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('days_class_meets')) ? $errors->first('days_class_meets') : null,
                  'optional' => false,
                  'hint' => '',
                  'label' => 'Days the Class Meets *',
                )
            ),
        ];
        foreach($this->getDaysOfWeekArray(old('days_class_meets'), 'days_class_meets') as $d) {
            array_push($daysClassMeetsFields['blocks'], $d);
        }
        $courseInformationFields[] = $daysClassMeetsFields;

        $noOfSessionsFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('no_of_sessions')) ? $errors->first('no_of_sessions') : null,
                  'optional' => false,
                  'hint' => '',
                  'label' => 'Number of Sessions *',
                )
            ),
        ];
        foreach($this->getNoOfSessionsArray(old('no_of_sessions')) as $d) {
            array_push($noOfSessionsFields['blocks'], $d);
        }
        $courseInformationFields[] = $noOfSessionsFields;

        $courseInformationFields[] = [
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'textarea',
                  'variation' => null,
                  'id' => 'multiple_sessions_description',
                  'placeholder' => '',
                  'value' => old('multiple_sessions_description'),
                  'error' => (!empty($errors) && $errors->first('multiple_sessions_description')) ? $errors->first('multiple_sessions_description') : null,
                  'optional' => false,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Please describe multiple sessions here',
                ),
            ),
        ];

        /*
         *
         *  Visit information
         *
         */
        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                    'type' => 'text',
                    'content' => '<span class="input s-disabled"><label class="label f-secondary">Preferred Dates *'
                    .'<em class="label__hint">Please select 3 options for the date of your visit. Monday through Friday only.</em></label></span>'
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'date-select',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'preferred_date_1',
                  'placeholder' => 'mm/dd/yy',
                  'value' => old('preferred_date_1'),
                  'error' => (!empty($errors) && $errors->first('preferred_date_1')) ? $errors->first('preferred_date_1') : null,
                  'optional' => false,
                  'hint' => null,
                  'disabled' => false,
                  'label' => '',
                ),
                array(
                  'type' => 'date-select',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'preferred_date_2',
                  'placeholder' => 'mm/dd/yy',
                  'value' => old('preferred_date_2'),
                  'error' => (!empty($errors) && $errors->first('preferred_date_2')) ? $errors->first('preferred_date_2') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => '',
                ),
                array(
                  'type' => 'date-select',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'preferred_date_3',
                  'placeholder' => 'mm/dd/yy',
                  'value' => old('preferred_date_3'),
                  'error' => (!empty($errors) && $errors->first('preferred_date_3')) ? $errors->first('preferred_date_3') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => '',
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'select',
                  'variation' => '',
                  'id' => 'preferred_time',
                  'error' => (!empty($errors) && $errors->first('preferred_time')) ? $errors->first('preferred_time') : null,
                  'value' => old('preferred_time'),
                  'optional' => false,
                  'hint' => 'Only available weekdays 10:30 am through 4:00 pm',
                  'disabled' => false,
                  'label' => 'Preferred Time *',
                  'options' => $this->getTimeArray(10, 12 + 4)
                ),
            ),
        );

        $visitInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'alt_times',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('alt_times'),
                  'error' => (!empty($errors) && $errors->first('alt_times')) ? $errors->first('alt_times') : null,
                  'optional' => null,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Alternate Time(s)',
                ),
            ),
        );

        $visitInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'number',
                  'pattern' => '\d*',
                  'variation' => null,
                  'id' => 'no_of_students',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('no_of_students'),
                  'error' => (!empty($errors) && $errors->first('no_of_students')) ? $errors->first('no_of_students') : null,
                  'optional' => false,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Number of Students *',
                ),
            ),
        );

        $typeOfVisitFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('type_of_visit')) ? $errors->first('type_of_visit') : null,
                  'optional' => false,
                  'hint' => 'View <a href="/library/request-a-visit">descriptions</a>',
                  'label' => 'Type of Visit *',
                )
            ),
        ];
        foreach($this->getTypeOfVisitArray(old('type_of_visit')) as $t) {
            array_push($typeOfVisitFields['blocks'], $t);
        }
        $visitInformationFields[] = $typeOfVisitFields;

        $sessionObjectiveFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('session_objective')) ? $errors->first('session_objective') : null,
                  'optional' => false,
                  'hint' => 'Select all that apply',
                  'label' => 'Objective for this Session *',
                )
            ),
        ];
        foreach($this->getSessionObjectiveArray(old('session_objective')) as $d) {
            array_push($sessionObjectiveFields['blocks'], $d);
        }
        $visitInformationFields[] = $sessionObjectiveFields;

        $visitInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'textarea',
                  'variation' => null,
                  'id' => 'collections_related_assignment_description',
                  'placeholder' => '',
                  'value' => old('collections_related_assignment_description'),
                  'error' => (!empty($errors) && $errors->first('collections_related_assignment_description')) ? $errors->first('collections_related_assignment_description') : null,
                  'optional' => false,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Collections-Related Assignment Description *',
                ),
            ),
        );

        $visitInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'textarea',
                  'variation' => null,
                  'id' => 'collection_materials_requested_for_visit',
                  'placeholder' => '',
                  'value' => old('collection_materials_requested_for_visit'),
                  'error' => (!empty($errors) && $errors->first('collection_materials_requested_for_visit')) ? $errors->first('collection_materials_requested_for_visit') : null,
                  'optional' => false,
                  'hint' => 'Please paste permalinks from the online catalog here or provide bibliographic citations.',
                  'disabled' => false,
                  'label' => 'Collection Materials Requested for Visit *',
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                    'type' => 'text',
                    'content' => '<span class="input s-disabled"><label class="label f-secondary">Three Potential Dates/Times for Instructor Materials Review *'
                    .'<em class="label__hint">Only available Monday through Friday, 10:30-3:30.</em></label></span>'
                ),
            ),
        );

        for ($i = 1; $i <= 3; $i++)
        {
            $visitInformationFields[] = array(
                'variation' => null,
                'blocks' => array(
                    array(
                        'type' => 'date-select',
                        'variation' => 'm-fieldset__input-narrow',
                        'id' => 'instructor_materials_review_date_' .$i,
                        'placeholder' => 'mm/dd/yy',
                        'value' => old('instructor_materials_review_date_' .$i),
                        'error' => (!empty($errors) && $errors->first('instructor_materials_review_date_' .$i)) ? $errors->first('instructor_materials_review_date_' .$i) : null,
                        'optional' => $i == 1 ? false : null,
                        'hint' => null,
                        'disabled' => false,
                        'label' => '',
                    ),
                    array(
                        'type' => 'select',
                        'variation' => 'm-fieldset__input-narrow',
                        'id' => 'instructor_materials_review_time_' .$i,
                        'error' => (!empty($errors) && $errors->first('instructor_materials_review_time_' .$i)) ? $errors->first('instructor_materials_review_time_' .$i) : null,
                        'value' => old('instructor_materials_review_time_' .$i),
                        'optional' => false,
                        'hint' => null,
                        'disabled' => false,
                        'label' => '',
                        'options' => $this->getTimeArray(10, 12 + 4)
                    ),
                ),
            );
        }

        $researchShelfFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('research_shelf_required')) ? $errors->first('research_shelf_required') : null,
                  'optional' => false,
                  'hint' => null,
                  'label' => 'Will you require a research shelf for this course? *',
                )
            ),
        ];
        foreach($this->getYesNoArray(old('research_shelf_required'), 'research_shelf_required') as $t) {
            array_push($researchShelfFields['blocks'], $t);
        }
        $visitInformationFields[] = $researchShelfFields;

        $visitInformationFields[] = array(
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
          'fields' => $contactInformationFields,
          'legend' => 'Contact Information',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $institutionInformationFields,
          'legend' => 'Institution Information',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $courseInformationFields,
          'legend' => 'Course Information',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $visitInformationFields,
          'legend' => 'Visit Information',
        ));

        array_push($blocks, array(
          'type' => 'text',
          'content' => '<p>Please fill out the form below to request an instruction session. If you have questions contact the reference desk at (312) 443-3666 or libinstruction@artic.edu. All requests for the semester must be received by the end of the fourth week in the semester <strong>Please allow at least 2 weeks between your request and proposed date of visit.</strong></p>'
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/library/request-a-class-visit/schedule',
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

        $breadcrumbs = [
            [
                'label' => 'Library',
                'href' => '/library',
            ],
            [
                'label' => 'Request a Class Visit',
                'href' => '/library/request-a-class-visit',
            ],
        ];

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => $this->title,
            'breadcrumb' => $breadcrumbs,
            'blocks' => $blocks
        ];

        return view('site.forms.form', $view_data);
    }

    /**
     * @param RyersonClassVisitRequest $request
     */
    public function store(RyersonClassVisitRequest $request)
    {

        $validated = $request->validated();

        $ryersonClassVisit = new RyersonClassVisit;
        $ryersonClassVisit->name = $validated['name'] ?? '';
        $ryersonClassVisit->email = $validated['email'] ?? '';
        $ryersonClassVisit->phone_number = $validated['phone_number'] ?? '';
        $ryersonClassVisit->affiliation = $validated['affiliation'] ?? '';
        $ryersonClassVisit->non_saic_institution = $validated['non_saic_institution'] ?? '';
        $ryersonClassVisit->department = $validated['department'] ?? '';
        $ryersonClassVisit->course_title = $validated['course_title'] ?? '';
        $ryersonClassVisit->course_level = $validated['course_level'] ?? '';
        $ryersonClassVisit->days_class_meets = $validated['days_class_meets'] ?? '';
        $ryersonClassVisit->no_of_session = $validated['no_of_session'] ?? '';
        $ryersonClassVisit->multiple_sessions_description = $validated['multiple_sessions_description'] ?? '';
        $ryersonClassVisit->preferred_date_1 = Carbon::parse($validated['preferred_date_1']) ?? '';
        $ryersonClassVisit->preferred_date_2 = $validated['preferred_date_2'] ? (Carbon::parse($validated['preferred_date_2']) ?? null) : null;
        $ryersonClassVisit->preferred_date_3 = $validated['preferred_date_3'] ? (Carbon::parse($validated['preferred_date_3']) ?? null) : null;
        $ryersonClassVisit->preferred_time = $validated['preferred_time'] ?? '';
        $ryersonClassVisit->alt_times = $validated['alt_times'] ?? '';
        $ryersonClassVisit->no_of_students = $validated['no_of_students'] ?? '';
        $ryersonClassVisit->type_of_visit = $validated['type_of_visit'] ?? '';
        $ryersonClassVisit->session_objective = $validated['session_objective'] ?? '';
        $ryersonClassVisit->collections_related_assignment_description = $validated['collections_related_assignment_description'] ?? '';
        $ryersonClassVisit->collection_materials_requested_for_visit = $validated['collection_materials_requested_for_visit'] ?? '';
        $ryersonClassVisit->instructor_materials_review_date_1 = Carbon::parse($validated['instructor_materials_review_date_1']) ?? '';
        $ryersonClassVisit->instructor_materials_review_time_1 = $validated['instructor_materials_review_time_1'] ?? '';
        $ryersonClassVisit->instructor_materials_review_date_2 = $validated['instructor_materials_review_date_2'] ? (Carbon::parse($validated['instructor_materials_review_date_2']) ?? null) : null;
        $ryersonClassVisit->instructor_materials_review_time_2 = $validated['instructor_materials_review_time_2'] ?? '';
        $ryersonClassVisit->instructor_materials_review_date_3 = $validated['instructor_materials_review_date_3'] ? (Carbon::parse($validated['instructor_materials_review_date_3']) ?? null) : null;
        $ryersonClassVisit->instructor_materials_review_time_3 = $validated['instructor_materials_review_time_3'] ?? '';
        $ryersonClassVisit->session_objective = $validated['session_objective'] ?? '';
        $ryersonClassVisit->research_shelf_required = $validated['research_shelf_required'] ?? '';

        Mail::to(config('forms.email_ryerson_class_visit_to'))
            ->send(new FormRyersonClassVisit($ryersonClassVisit));

        return redirect(route('forms.ryerson-class-visit.thanks'));

    }

    private function getAffiliationArray($selected)
    {
        $options = array('SAIC Undergraduate', 'SAIC Graduate', 'Non-SAIC');

        $list = [];
        foreach($options as $value) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'affiliation_'.$value,
              'name' => 'affiliation',
              'value' => $value,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => $value
            ];

            if ($selected == $value) {
                $item['checked'] = 'checked';
            }

            $list[] = $item;
        }

        return $list;
    }

    private function getNoOfSessionsArray($selected)
    {
        $options = array('Single Session' => 'Single Session',
                         'Multiple Sessions' => 'Multiple Sessions',
        );

        $list = [];
        foreach($options as $value) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'no_of_sessions-'.$value,
              'name' => 'no_of_sessions',
              'value' => $value,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => $value
            ];

            if ($selected == $value) {
                $item['checked'] = 'checked';
            }

            $list[] = $item;
        }

        return $list;
    }

    private function getTypeOfVisitArray($selected)
    {
        $options = array('Library Orientation', 'Course-Related Research Session', 'Library Tour');

        $list = [];
        foreach($options as $value) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'type_of_visit_'.$value,
              'name' => 'type_of_visit',
              'value' => $value,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => $value
            ];

            if ($selected == $value) {
                $item['checked'] = 'checked';
            }

            $list[] = $item;
        }

        return $list;
    }

    protected function getSessionObjectiveArray($selected)
    {
        $options = array('How to access library collections and services' => 'How to access library collections and services',
                         'How to use the online catalog' => 'How to use the online catalog',
                         'How to use a finding aid and archival digital collections' => 'How to use a finding aid and archival digital collections',
                         'Course-specific research strategies (eg, costume history resources at the RB Libraries; how to research a work of art)' => 'Course-specific research strategies (eg, costume history resources at the RB Libraries; how to research a work of art)',
                         'Use of RB collection materials to support course instruction' => 'Use of RB collection materials to support course instruction',
        );

        $list = [];
        foreach($options as $value => $label) {
            $item = [
              'type' => 'checkbox',
              'variation' => '',
              'id' => 'session_objective-' .$value,
              'name' => 'session_objective[]',
              'value' => $value,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => $label
            ];

            if ($selected) {
                if (in_array($value, $selected)) {
                    $item['checked'] = 'checked';
                }
            }

            $list[] = $item;
        }

        return $list;
    }
}
