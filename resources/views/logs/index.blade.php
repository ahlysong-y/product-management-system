@extends('layouts.app')

@section('content')
    <h2 class="mb-4">
        Activity Logs
    </h2>

    <table class="table table-bordered">

        <thead class="table-dark">

            <tr>

                <th>User</th>
                <th>Activity</th>
                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($logs as $log)
                <tr>

                    <td>{{ $log->user }}</td>

                    <td>{{ $log->activity }}</td>

                    <td>{{ $log->created_at }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>
@endsection
