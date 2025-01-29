@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">{{ $studentTempRecords->name }} Temperature Records</h4>

            <a href="/students/index" class="btn btn-danger my-auto ms-2 ml-2s">Back</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Temperature</th>
                        <th>Date Recorded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($studentTempRecords->temperatureRecords->count() > 0)
                    @foreach ($studentTempRecords->temperatureRecords as $tempRecord)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tempRecord->body_temperature }} &deg;C</td>
                        <td>{{ $tempRecord->created_at->format('F d, Y h:i a') }}</td>
                        <td>
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$tempRecord->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('students.modal.temperatureDelete')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center">No Temperature Records</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection