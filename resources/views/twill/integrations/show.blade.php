@extends('twill::layouts.free')

@section('customPageContent')
    <table id="integrations">
        <thead>
            <tr>
                <th>Connection</th><th>Service</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $integration)
                <tr>
                    <td>
                        @if($integration['connection'] && $integration['connection']['enabled'] ?? false)
                            <span style="color: green">&#11044;</span>
                        @elseif($integration['connection'])
                            <span style="color: yellow">&#11044;</span>
                        @else
                            <span style="color: red">&#11044;</span>
                        @endif
                    </td>
                    <td>
                        {{ $integration['name'] }}
                    </td>
                    <td>
                        {{ $integration['status'] }}
                    </td>
                    <td>
                        @foreach($integration['actions'] as $action)
                            <a href="{{ $action['url'] }}">{{ $action['name'] }}</a>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @push('extra_css')
        <style>
            table#integrations {
                width: 75%;
                border: 1px solid black;
            }
            table#integrations thead {
                border-bottom: 1px solid black;
                font-weight: bold;
            }
            table#integrations tbody tr td {
                border-left: 1px solid black;
                border-right: 1px solid black;
                padding: 1em;
                text-align: center;
            }
        </style>
    @endpush
@stop
