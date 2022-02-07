<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\EducatorAdmissionRequest;

use App\Models\Form\EducatorAdmission;

use App\Mail\FormEducatorAdmission;

class EducatorAdmissionController extends FormController
{
    public function index()
    {
        $this->title = 'Educator Admission Request';
        $this->seo->setTitle($this->title);

        $blocks = [];
        $formBlocks = [];
        $registrationInformationFields = [];

        $errors = session('errors');

        // Registration information
        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'date-select',
                    'variation' => '',
                    'id' => 'visit_date',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('visit_date'),
                    'error' => (!empty($errors) && $errors->first('visit_date')) ? $errors->first('visit_date') : null,
                    'optional' => null,
                    'hint' => 'Please review the museum’s current <a href="/visit">hours of operation</a>',
                    'disabled' => false,
                    'label' => 'Visit date *',
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $registrationInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'captcha',
                    'variation' => null,
                    'id' => 'captcha',
                    'error' => (!empty($errors) && $errors->first('captcha')) ? $errors->first('captcha') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
            ],
        ];

        array_push($formBlocks, [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $registrationInformationFields,
            'legend' => 'Registration Information',
        ]);

        array_push($blocks, [
            'type' => 'text',
            'content' => '<p>Free admission to the Art Institute of Chicago is available to current Illinois educators, including pre-K–12 teachers, teaching artists working in schools, and homeschool parents. Educators can register here to receive a voucher for a complimentary ticket to the museum. This voucher must be presented at one of the museum’s admission counters with a valid educator ID.</p>'
            . '<p>Museum hours are subject to change. Please review the museum\'s current <a href="/visit"> hours of operation</a> before reserving your free admission.</p>'
            . '<p>A complimentary ticket will not be granted without one of the following forms of acceptable identification:</p>'
            . '<p>Pre-K–12 teachers'
            . '<ul>'
            . '<li>Current school ID</li>'
            . '<li>Current Illinois Education Association ID card</li>'
            . '</ul>'
            . '</p>'

            . '<p>Teaching Artist Working in Schools'
            . '<ul>'
            . '<li>Letter on school letterhead indicating that the teaching artist is currently working in an Illinois pre-K–12 school</li>'
            . '</ul>'
            . '</p>'

            . '<p>Homeschool Parents'
            . '<ul>'
            . '<li>Illinois homeschool co-op member ID card</li>'
            . '<li>Illinois homeschool legal defense association member ID card</li>'
            . '</ul>'
            . '</p>'

            . '<p>Illinois Educator Admission Requests may not be used in conjunction with Student Tours or Groups. For more information, visit <a href="/learn-with-us/educators/visit-with-my-students">Student Tours</a>.</p>'
        ]);

        array_push($blocks, [
            'type' => 'form',
            'variation' => null,
            'action' => '/educators/visit-on-my-own/educator-admission-request',
            'method' => 'POST',
            'blocks' => $formBlocks,
            'actions' => [
                [
                    'variation' => null,
                    'type' => 'submit',
                    'label' => 'Submit',
                ]
            ]
        ]);

        $breadcrumbs = [
            [
                'label' => 'Learn with Us',
                'href' => '/learn-with-us',
            ],
            [
                'label' => 'Educators',
                'href' => '/learn-with-us/educators',
            ],
            [
                'label' => 'Visit on My Own',
                'href' => '/learn-with-us/educators/visit-on-my-own',
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


    public function store(EducatorAdmissionRequest $request)
    {
        $validated = $request->validated();

        $educatorAdmission = new EducatorAdmission();

        $educatorAdmission->name = $validated['name'] ?? '';
        $educatorAdmission->email = $validated['email'] ?? '';
        $educatorAdmission->visit_date = $this->getDateField($validated, 'visit_date');
        $educatorAdmission->school_location = $validated['school_location'] ?? '';
        $educatorAdmission->type_of_educator = $validated['type_of_educator'] ?? '';
        $educatorAdmission->grades_taught = $validated['grades_taught'] ?? '';
        $educatorAdmission->subjects_taught = $validated['subjects_taught'] ?? '';

        Mail::to($educatorAdmission->email)
            ->send(new FormEducatorAdmission($educatorAdmission));

        return redirect(route('forms.educator-admission-request.thanks'));
    }

    private function getSchoolLocationArray()
    {
        $topics = ['Chicago Public Schools (CPS)',
            'Other Chicago schools',
            'Suburbs (Cook County)',
            'Suburbs (DuPage, Kane, Lake, McHenry, Will County)',
            'Other Illinois',
        ];

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach ($topics as $value => $label) {
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
        $topics = ['Pre-K–12 teacher',
            'Teaching artist in a pre-K–12 school',
            'Homeschool educator',
        ];

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach ($topics as $value => $label) {
            $item = [
                'value' => $label
                ,   'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }
}
