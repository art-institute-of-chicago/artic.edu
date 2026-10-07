@extends('twill::layouts.free')

@section('customPageContent')
    <div class="bc" data-block-copy data-bc-csrf="{{ csrf_token() }}" data-bc-state="{{ json_encode($blockCopyData) }}">
        <header class="bc__head">
            <h1 class="bc__title">Block Copy</h1>
            <p class="bc__lede">Copy a block &mdash; with its repeaters and images &mdash; from one record to another. Load a source and a target, then drag a block from the source column onto the target column.</p>
        </header>

        @if($errors->any())
            <div class="bc__alert bc__alert--error">{{ $errors->first() }}</div>
        @endif

        @if(session('status'))
            <div class="bc__alert bc__alert--ok">{{ session('status') }}</div>
        @endif

        <div class="bc__alert" data-bc-alert aria-live="polite" hidden></div>

        <div class="bc__columns">
            <section class="bc__column">
                <h2 class="bc__columnTitle">Source <span class="bc__count" data-bc-count="source">{{ count($sourceBlocks) }} blocks</span></h2>

                <p class="bc__hintline">Drag a block onto the target column to copy it.</p>

                <form class="bc__picker" data-bc-picker="source" method="GET" action="{{ route('twill.general.blockCopy.index') }}">
                    @foreach(['target_module', 'target_record'] as $param)
                        @if(request($param) !== null && request($param) !== '')
                            <input type="hidden" name="{{ $param }}" value="{{ request($param) }}" />
                        @endif
                    @endforeach

                    <div class="bc__field">
                        <label for="source-module">Module</label>
                        <select id="source-module" name="source_module" data-bc-module>
                            <option value="">&mdash; select &mdash;</option>
                            @foreach($modules as $alias => $module)
                                <option value="{{ $alias }}" @selected($sourceModule === $alias)>{{ $module['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bc__field">
                        <label for="source-record">Record</label>
                        <input id="source-record" name="source_record" list="source-records" data-bc-record
                            value="{{ request('source_record') }}" autocomplete="off" />
                        <datalist id="source-records" data-bc-options>
                            @foreach($sourceOptions as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <button class="bc__btn bc__btn--ghost" type="submit" data-bc-load>Load source</button>
                </form>

                @if($sourceRecord)
                    <p class="bc__record">{{ $sourceModule }}:{{ $sourceRecord->getKey() }} &mdash; {{ $sourceRecord->title ?? '' }}</p>
                @endif

                <ul class="bc__list" data-bc-list="source">
                    @include('twill.blockCopy._blocks', [
                        'blocks' => $sourceBlocks,
                        'column' => 'source',
                        'targetChosen' => $targetChosen,
                        'sourceModule' => $sourceModule,
                        'sourceRecord' => $sourceRecord,
                        'targetModule' => $targetModule,
                        'targetRecord' => $targetRecord,
                    ])
                </ul>
            </section>

            <section class="bc__column" data-bc-dropzone="target">
                <h2 class="bc__columnTitle">Target <span class="bc__count" data-bc-count="target">{{ count($targetBlocks) }} blocks</span></h2>

                <p class="bc__hintline">Drop a source block here to copy it.</p>

                <form class="bc__picker" data-bc-picker="target" method="GET" action="{{ route('twill.general.blockCopy.index') }}">
                    @foreach(['source_module', 'source_record'] as $param)
                        @if(request($param) !== null && request($param) !== '')
                            <input type="hidden" name="{{ $param }}" value="{{ request($param) }}" />
                        @endif
                    @endforeach

                    <div class="bc__field">
                        <label for="target-module">Module</label>
                        <select id="target-module" name="target_module" data-bc-module>
                            <option value="">&mdash; select &mdash;</option>
                            @foreach($modules as $alias => $module)
                                <option value="{{ $alias }}" @selected($targetModule === $alias)>{{ $module['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bc__field">
                        <label for="target-record">Record</label>
                        <input id="target-record" name="target_record" list="target-records" data-bc-record
                            value="{{ request('target_record') }}" autocomplete="off" />
                        <datalist id="target-records" data-bc-options>
                            @foreach($targetOptions as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <button class="bc__btn bc__btn--ghost" type="submit" data-bc-load>Load target</button>
                </form>

                @if($targetRecord)
                    <p class="bc__record">{{ $targetModule }}:{{ $targetRecord->getKey() }} &mdash; {{ $targetRecord->title ?? '' }}</p>
                @endif

                <ul class="bc__list" data-bc-list="target">
                    @include('twill.blockCopy._blocks', [
                        'blocks' => $targetBlocks,
                        'column' => 'target',
                        'targetChosen' => $targetChosen,
                        'sourceModule' => $sourceModule,
                        'sourceRecord' => $sourceRecord,
                        'targetModule' => $targetModule,
                        'targetRecord' => $targetRecord,
                    ])
                </ul>
            </section>
        </div>
    </div>

    @push('extra_js')
        @include('twill.blockCopy._script')
    @endpush

    @push('extra_css')
        <style>
            .bc { color: #262626; font-size: 15px; }
            .bc__head { margin-bottom: 20px; }
            .bc__title { margin: 0 0 6px; font-size: 22px; font-weight: 600; }
            .bc__lede { margin: 0; max-width: 760px; color: #8c8c8c; font-size: 13px; }

            .bc__alert { margin-bottom: 16px; padding: 10px 14px; border: 1px solid #e5e5e5; border-radius: 2px; font-size: 13px; }
            .bc__alert--error { color: #8a1f1f; background: #fdf3f3; border-color: #ecd0d0; }
            .bc__alert--ok { color: #262626; background: #fbfbfb; }

            .bc__columns { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; align-items: start; }
            .bc__column { border: 1px solid #e5e5e5; border-radius: 2px; background: #fff; overflow: hidden; }

            .bc__columnTitle { display: flex; align-items: center; justify-content: space-between; margin: 0; padding: 12px 16px; background: #e5e5e5; font-size: 13px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
            .bc__count { font-weight: 400; color: #8c8c8c; letter-spacing: 0; text-transform: none; }

            .bc__picker { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px; padding: 16px; border-bottom: 1px solid #e5e5e5; background: #fbfbfb; }
            .bc__field { display: flex; flex: 1 1 140px; min-width: 120px; flex-direction: column; gap: 4px; }
            .bc__field label { color: #8c8c8c; font-size: 13px; letter-spacing: .03em; text-transform: uppercase; }
            .bc__field select,
            .bc__field input { box-sizing: border-box; width: 100%; height: 45px; padding: 0 10px; border: 1px solid #e5e5e5; border-radius: 2px; background: #fff; color: #262626; font-size: 15px; }
            .bc__field select:focus,
            .bc__field input:focus { outline: none; border-color: #333; }

            .bc__btn { height: 45px; padding: 0 18px; border: 1px solid transparent; border-radius: 2px; font-size: 13px; font-weight: 600; cursor: pointer; }
            .bc__btn--ghost { background: #fbfbfb; border-color: #e5e5e5; color: #262626; }
            .bc__btn--ghost:hover { background: #fff; border-color: #333; }

            .bc__record { margin: 0; padding: 12px 16px; color: #8c8c8c; font-size: 13px; }

            .bc__list { margin: 0; padding: 0; list-style: none; }
            .bc__row { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-top: 1px solid #e5e5e5; }
            .bc__row:hover { background: #fbfbfb; }
            .bc__row--new { border-left: 2px solid #333; background: #f6f6f6; }
            .bc__pos { min-width: 20px; color: #8c8c8c; font-size: 13px; text-align: right; }
            .bc__badge { padding: 2px 6px; border-radius: 2px; background: #f2f2f2; color: #262626; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 12px; white-space: nowrap; }
            .bc__preview { flex: 1 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .bc__id { color: #8c8c8c; font-size: 13px; white-space: nowrap; }
            .bc__meta { color: #8c8c8c; font-size: 13px; white-space: nowrap; }
            .bc__action { display: flex; align-items: center; margin-left: auto; }
            .bc__hint { color: #8c8c8c; font-size: 13px; white-space: nowrap; }
            .bc__chip { padding: 2px 8px; border-radius: 2px; background: #333; color: #fff; font-size: 11px; white-space: nowrap; }
            .bc__empty { padding: 16px; border-top: 1px solid #e5e5e5; color: #8c8c8c; font-size: 13px; }

            .bc__handle { display: inline-flex; flex: none; align-items: center; width: 16px; color: #8c8c8c; cursor: grab; }
            .bc__handle:focus { outline: 2px solid #333; outline-offset: 2px; }
            .bc__handle:active { cursor: grabbing; }

            .bc__row--dragging { opacity: .5; }
            .bc__row--drop-before { box-shadow: inset 0 2px 0 0 #333; }
            .bc__row--drop-after { box-shadow: inset 0 -2px 0 0 #333; }

            .bc__column--drop { outline: 2px dashed #333; outline-offset: -2px; background: #fbfbfb; }
            .bc--busy { opacity: .7; }

            .bc__hintline { margin: 0; padding: 10px 16px 0; color: #8c8c8c; font-size: 13px; }
            .bc--copying [data-bc-dropzone="target"] { outline: 2px dashed #333; outline-offset: -4px; }
            .bc__column--drop { background: #f6f6f6; }

            .bc__groupLabel { padding: 6px 16px; color: #8c8c8c; font-size: 13px; letter-spacing: .04em; text-transform: uppercase; }

            .bc__undo { margin-left: 8px; padding: 2px 8px; border: 1px solid #e5e5e5; border-radius: 2px; background: #fff; color: #262626; font-size: 12px; cursor: pointer; }
            .bc__undo:hover { border-color: #333; }

            @media (max-width: 999px) {
                .bc__columns { grid-template-columns: minmax(0, 1fr); }
            }
        </style>
    @endpush
@stop
