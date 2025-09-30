@extends('twill::layouts.free')

@section('customPageContent')
    <table id="integrations">
        <thead>
            <tr>
                <th>Status</th><th>Service</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $integration)
                <tr>
                    <td>
                        @if($integration['isConnected'])
                            <span style="color: green">&#11044;</span>
                        @else
                            <span style="color: red">&#11044;</span>
                        @endif
                    </td>
                    <td>
                        {{ $integration['name'] }}
                    </td>
                    <td>
                        @if($integration['authorizationUrl'])
                            <a href="{{ $integration['authorizationUrl'] }}" target="_blank">Connect</a>
                        @elseif($integration['connectedSince'])
                            {{ $integration['connectedSince'] }}
                            (<a href="{{ route('twill.general.integrations.disconnect', $integration['provider']) }}">Disconnect</a>)
                        @endif
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
