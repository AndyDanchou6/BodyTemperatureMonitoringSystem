@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">List of all temperature records</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Temperature</th>
                        <th>Date Recorded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @if($temperature->count() > 0)
                    @foreach ($temperature as $list)
                    <tr class="student_info">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $list->studentInfo->name }}</td>
                        <td>{{ $list->body_temperature }} &deg;C</td>
                        <td>{{ $list->created_at->format('F d, Y h:i a') }}</td>
                        <td>

                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$list->id}}">
                                <i class="fas fa-trash"></i>
                            </a>

                            @include('records.modal.delete')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Temperature Record found!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script>
    const studentInfoRows = document.querySelectorAll('.student_info');

    studentInfoRows.forEach(info => {
        info.addEventListener('click', function() {
            let id = info.querySelector('.id').textContent;
            // window.location.href = '/students/tempRecords/' + id;

            console.log(info.querySelector('.id').textContent);
        })
    })
</script> -->
@endsection