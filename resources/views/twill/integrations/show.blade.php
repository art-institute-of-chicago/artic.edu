@extends('twill::layouts.free')

@section('customPageContent')
    <h4>Integrations</h4>

    <table class="output">
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

    <h4>Services</h4>

    <table class="output">
        <thead>
            <tr>
                <th>Status</th><th>Service</th><th>Last succeeded</th><th>Last failed</th><th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $name => $service)
                <tr>
                    <td>
                        @if(\Carbon\Carbon::parse($service['last_succeeded_at'])->gt($service['last_failed_at']))
                            <span style="color: green">&#11044;</span>
                        @else
                            <span style="color: red">&#11044;</span>
                        @endif
                    </td>
                    <td>
                        {{ $name }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($service['last_succeeded_at'])->tz('UTC')->toDayDateTimeString() }}
                    </td>
                    <td>
                        @if(\Carbon\Carbon::parse($service['last_failed_at'])->gt($service['last_succeeded_at']))
                            {{ \Carbon\Carbon::parse($service['last_failed_at'])->tz('UTC')->toDayDateTimeString() }}
                        @endif
                    </td>
                    <td>
                        @if(\Carbon\Carbon::parse($service['last_failed_at'])->gt($service['last_succeeded_at']))
                            {{ $service['last_failed_reason'] }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @push('extra_css')
        <style>
            table.output {
                width: 75%;
                border: 1px solid black;
                margin-bottom: 30px;
            }
            table.output thead {
                border-bottom: 1px solid black;
                font-weight: bold;
            }
            table.output tbody tr td {
                border-left: 1px solid black;
                border-right: 1px solid black;
                padding: 1em;
                text-align: center;
            }
            h4 {
                margin: 0 0 10px;
                font-size: 16px;
                font-weight: bold;
            }
        </style>
    @endpush
@stop
