@extends('cms-toolkit::layouts.form', [
    'contentFieldsetLabel' => $feeAges->isEmpty() ? 'Please create Admission ages and categories' : $feeAges->first()->title,
    'additionalFieldsets' => $feeAges->reject(function ($feeAge, $index) {
        return $index == 0;
    })->map(function ($feeAge) {
        return [
            'fieldset' => 'fieldset' . $feeAge->id,
            'label' => $feeAge->title
        ];
    })->toArray()
])

@section('contentFields')
    @foreach($feeAges as $feeAge)
        @if($loop->first)
            @foreach($feeCategories as $feeCategory)
                @formField('input', [
                    'label' => $feeCategory->title,
                    'name' => 'price['. $feeAge->id .']['. $feeCategory->id .']'
                ])
            @endforeach
        @else
            @break
        @endif
    @endforeach
@stop

@section('fieldsets')
    @foreach($feeAges as $feeAge)
        @if(!$loop->first)
            <a17-fieldset id="fieldset{{ $feeAge->id }}" title="{{ $feeAge->title }}">
                @foreach($feeCategories as $feeCategory)
                    @formField('input', [
                        'label' => $feeCategory->title,
                        'name' => 'price['. $feeAge->id .']['. $feeCategory->id .']'
                    ])
                @endforeach
            </a17-fieldset>
        @endif
    @endforeach
@stop

@push('vuexStore')
window.STORE.publication.submitOptions = {
    update: [
      {
        name: 'update',
        text: 'Update'
      },
      {
        name: 'cancel',
        text: 'Cancel'
      }
    ]
}
@endpush
