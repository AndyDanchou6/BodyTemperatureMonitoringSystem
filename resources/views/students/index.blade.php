@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Student Info</h4>

            <a href="{{ route('students.create') }}" class="btn btn-primary my-auto ms-2 ml-2s">Register New Student</a>

        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Student_id</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @if($students->count() > 0)
                    @foreach ($students as $list)
                    <tr class="student_info">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($list->avatar)
                            <img src="{{ asset('storage/' . $list->avatar) }}" style="width: 45px; height: 45px" alt="User Avatar" class="rounded-circle">
                            @else
                            <img src="{{ asset('assets/img/user.png') }}" style="width: 45px; height: 45px" alt="Default Avatar" class="rounded-circle">
                            @endif
                        </td>
                        <td> <span class="id badge bg-info">{{ $list->student_id }}</span></td>
                        <td>{{ $list->name }}</td>
                        <td>{{ $list->course }}</td>
                        <td>{{ $list->year_level }}</td>

                        <td>
                            <a class="bx bi-thermometer" href="{{ url('/students/tempRecords/' . $list->student_id) }}"></a>
                            <a class="bx bx-edit-alt me-1" href="{{ route('students.edit', $list->id) }}"></a>

                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$list->id}}">
                                <i class="fas fa-trash"></i>
                            </a>

                            @include('students.modal.delete')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Students Record found!</td>
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