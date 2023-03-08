<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\FilmingProposalRequest;

use App\Models\Form\FilmingProposal;

use App\Mail\FormFilmingProposal;

class FilmingAndPhotoShootProposalController extends FormController
{
    public function index()
    {
        $this->title = 'Filming and Photo Shoot Proposal Form';
        $this->seo->setTitle($this->title);

        $blocks = [];
        $formBlocks = [];
        $contactInformationFields = [];
        $projectDescriptionFields = [];

        $errors = session('errors');

        // Contact information
        $contactInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'name',
                    'placeholder' => '',
                    'autocomplete' => 'name',
                    'textCount' => false,
                    'value' => old('name'),
                    'error' => (!empty($errors) && $errors->first('name')) ? $errors->first('name') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Name *',
                ],
            ],
        ];

        $contactInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'email',
                    'variation' => null,
                    'id' => 'email',
                    'placeholder' => 'your@email.com',
                    'autocomplete' => 'email',
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

        $contactInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'tel',
                    'variation' => null,
                    'id' => 'phone_number',
                    'placeholder' => '',
                    'autocomplete' => 'tel',
                    'textCount' => false,
                    'value' => old('phone_number'),
                    'error' => (!empty($errors) && $errors->first('phone_number')) ? $errors->first('phone_number') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Phone number',
                ],
            ],
        ];

        // Project description
        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'textarea',
                    'variation' => null,
                    'id' => 'description',
                    'value' => old('description'),
                    'error' => (!empty($errors) && $errors->first('description')) ? $errors->first('description') : null,
                    'optional' => false,
                    'hint' => 'Provide a brief description of your project',
                    'disabled' => false,
                    'label' => 'Project Description *',
                ],
            ],
        ];

        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'text',
                    'content' => '<p>Provide up to three (3) preferred dates for filming *:</p>'
                ],
            ],
        ];

        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'date-select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'preferred_date_1',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('preferred_date_1'),
                    'error' => (!empty($errors) && $errors->first('preferred_date_1')) ? $errors->first('preferred_date_1') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
                [
                    'type' => 'date-select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'preferred_date_2',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('preferred_date_2'),
                    'error' => (!empty($errors) && $errors->first('preferred_date_2')) ? $errors->first('preferred_date_2') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
                [
                    'type' => 'date-select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'preferred_date_3',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('preferred_date_3'),
                    'error' => (!empty($errors) && $errors->first('preferred_date_3')) ? $errors->first('preferred_date_3') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
            ],
        ];

        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'textarea',
                    'variation' => null,
                    'id' => 'locations',
                    'placeholder' => '',
                    'value' => old('locations'),
                    'error' => (!empty($errors) && $errors->first('locations')) ? $errors->first('locations') : null,
                    'optional' => false,
                    'hint' => 'Provide a list of locations in the museum you plan to shoot',
                    'disabled' => false,
                    'label' => 'Museum Locations *',
                ],
            ],
        ];

        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'required_time',
                    'textCount' => false,
                    'value' => old('required_time'),
                    'error' => (!empty($errors) && $errors->first('required_time')) ? $errors->first('required_time') : null,
                    'optional' => false,
                    'hint' => 'Provide the amount of time you need to shoot in the museum',
                    'disabled' => false,
                    'label' => 'Required Time *',
                ],
            ],
        ];

        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'textarea',
                    'variation' => null,
                    'id' => 'crew_members',
                    'value' => old('crew_members'),
                    'error' => (!empty($errors) && $errors->first('crew_members')) ? $errors->first('crew_members') : null,
                    'optional' => false,
                    'hint' => 'Include names of all crew members that will need access to the museum',
                    'disabled' => false,
                    'label' => 'Crew Members *',
                ],
            ],
        ];

        $projectDescriptionFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'textarea',
                    'variation' => null,
                    'id' => 'equipment_list',
                    'value' => old('equipment_list'),
                    'error' => (!empty($errors) && $errors->first('equipment_list')) ? $errors->first('equipment_list') : null,
                    'optional' => false,
                    'hint' => 'Provide a detailed list of all equipment that you will be bringing into the museum',
                    'disabled' => false,
                    'label' => 'Equipment List *',
                ],
            ],
        ];

        $projectDescriptionFields[] = [
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
            'fields' => $contactInformationFields,
            'legend' => 'Contact Information',
        ]);

        array_push($formBlocks, [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $projectDescriptionFields,
            'legend' => 'Project Description',
        ]);

        array_push($blocks, [
            'type' => 'text',
            'content' => '<p>Please read the <a href="/press/filming-policy">Filming Policy</a> before submitting a request. If you have additional questions, call (312) 443-3363 or e-mail publicaffairs@artic.edu.</p>'
        ]);

        array_push($blocks, [
            'type' => 'form',
            'variation' => null,
            'action' => '/press/filming-policy/filming-photo-shoot-proposal-form',
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
                'label' => 'Press',
                'href' => '/press',
            ],
            [
                'label' => 'Filming Policy',
                'href' => '/press/filming-policy',
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

    public function store(FilmingProposalRequest $request)
    {
        $validated = $request->validated();

        $filmingProposal = new FilmingProposal();
        $filmingProposal->name = $validated['name'] ?? '';
        $filmingProposal->email = $validated['email'] ?? '';
        $filmingProposal->phone_number = $validated['phone_number'] ?? '';
        $filmingProposal->description = $validated['description'] ?? '';
        $filmingProposal->preferred_date_1 = $this->getDateField($validated, 'preferred_date_1');
        $filmingProposal->preferred_date_2 = $this->getDateField($validated, 'preferred_date_2');
        $filmingProposal->preferred_date_3 = $this->getDateField($validated, 'preferred_date_3');
        $filmingProposal->locations = $validated['locations'] ?? '';
        $filmingProposal->required_time = $validated['required_time'] ?? '';
        $filmingProposal->crew_members = $validated['crew_members'] ?? '';
        $filmingProposal->equipment_list = $validated['equipment_list'] ?? '';

        Mail::to(config('forms.email_filming_proposal_to'))
            ->send(new FormFilmingProposal($filmingProposal));

        return redirect(route('forms.filming-proposal.thanks'));
    }
}
