@extends('twill::layouts.free')

@section('customPageContent')
    <table id="integrations">
        <thead>
            <tr>
                <th>Status</th><th>Service</th><th>Last succeeded</th><th>Last failed</th><th>Message</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $name => $integration)
                <tr>
                    <td>
                        <span style="color: {{ $integration['status'] ?? 'red' }}">&#11044;</span>
                    </td>
                    <td>
                        {{ $name }}
                    </td>
                    <td>
                        {{ $integration['last_succeeded_at'] ?? '' }}
                    </td>
                    <td>
                        {{ $integration['last_failed_at'] ?? '' }}
                    </td>
                    <td>
                        {{ $integration['message'] ?? '' }}
                    </td>
                    <td>
                        @foreach($integration['actions'] ?? [] as $action)
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
