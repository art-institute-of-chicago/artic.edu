@extends('twill::layouts.form', [
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
                <x-twill::input
                    label='{{ $feeCategory->title }}'
                    name='price[{{ $feeAge->id }}][{{ $feeCategory->id }}]'
                />
            @endforeach
        @else
            @break
        @endif
    @endforeach
@stop

@section('fieldsets')
    @foreach($feeAges as $feeAge)
        @if(!$loop->first)
            <x-twill::formFieldset id="fieldset{{ $feeAge->id }}" title="{{ $feeAge->title }}">
                @foreach($feeCategories as $feeCategory)
                    <x-twill::input
                        label='{{ $feeCategory->title }}'
                        name='price[{{ $feeAge->id }}][{{ $feeCategory->id }}]'
                    />
                @endforeach
            </x-twill::formFieldset>
        @endif
    @endforeach
@stop

@push('vuexStore')
window['{{ config('twill.js_namespace') }}'].STORE.publication.submitOptions = {
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
