@extends('app')

@section('content')

<style>
    .hidden {
        display: none;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header">Update Student Record</h5>
        <div class="card-body">
            <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
                <div class="col-auto text-center">
                    <img src="{{ $students->avatar ? asset('storage/' . $students->avatar) : asset('assets/img/students.png') }}" id="change_studentAvatar{{ $students->id }}" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                    <div style="margin-top: 5px;"><label>Avatar</label></div>
                </div>
            </div>
            <!-- Form Start -->
            <form action="{{ route('students.update', $students->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <div class="row mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="avatar" id="edit_student_avatarInput{{ $students->id }}" aria-describedby="name_help" />
                        </div>
                        <small id="userAvatarFileError" class="form-text text-danger text-wrap hidden">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                    </div>

                    <div class="row mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="student_id" id="edit_student_id" placeholder="Scan your RFID Card" value="{{ $students->student_id }}" aria-describedby="student_id_help" readonly />
                            <span class="input-group-text" id="iconEdit">
                                <i class="bx bx-id-card text-success" id="card"></i>
                                <i class="bx bx-check text-success hidden" id="success"></i>
                                <i class="bx bx-x-circle text-danger hidden" id="failed"></i>
                            </span>
                        </div>
                        <div id="rfid-warning" class="form-text hidden text-danger">
                            <strong>Warning:</strong> This RFID Card is already registered. Please use a different RFID card.
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" id="name" value="{{ $students->name }}" placeholder="Enter Name" aria-describedby="name_help" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="defaultSelect" class="form-label">Course</label>
                        <div class="input-group">
                            <select name="course" class="form-select">
                                <option value="" disabled {{ !$students->course ? 'selected' : '' }}>Choose Course</option>
                                <option value="BSIT" {{ $students->course == 'BSIT' ? 'selected' : '' }}>BSIT</option>
                                <option value="BEED" {{ $students->course == 'BEED' ? 'selected' : '' }}>BEED</option>
                                <option value="BSED-SS" {{ $students->course == 'BSED-SS' ? 'selected' : '' }}>BSED-SS</option>
                                <option value="BSED-MATH" {{ $students->course == 'BSED-MATH' ? 'selected' : '' }}>BSED-MATH</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="year_level" class="form-label">Year Level</label>
                        <div class="input-group">
                            <select id="defaultSelect" name="year_level" class="form-select">
                                <option value="" disabled {{ !$students->year_level ? 'selected' : '' }}>Year Level</option>
                                <option value="1" {{ $students->year_level == '1' ? 'selected' : '' }}>1st Year</option>
                                <option value="2" {{ $students->year_level == '2' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3" {{ $students->year_level == '3' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4" {{ $students->year_level == '4' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-danger">Close</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"][id^="edit_student_avatarInput"]');
        const imageElements = document.querySelectorAll('img[id^="change_studentAvatar"]');

        fileInputs.forEach((input) => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const userId = input.id.replace('edit_student_avatarInput', '');
                const errorMessage = document.getElementById('userAvatarFileError');
                const imageElement = document.getElementById('change_studentAvatar' + userId);

                if (!file) return;

                if (file.size > 2 * 1024 * 1024) {
                    if (errorMessage) {
                        errorMessage.textContent = 'The selected file exceeds 2 MB. Please choose a smaller file.';
                        errorMessage.style.display = 'block';
                    }

                    event.target.value = '';
                    return;
                } else {
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (imageElement) {

                        imageElement.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        });

        var scanCard = pusher.subscribe("new-user");
        scanCard.bind("new-user", function(data) {
            if (data.status == 200) {
                document.getElementById("edit_student_id").value = data.data;
                document.getElementById("rfid-warning").classList.add('hidden');
                document.getElementById("success").classList.remove('hidden');
                document.getElementById("card").classList.add('hidden');
            } else if (data.status == 409) {
                document.getElementById("rfid-warning").classList.remove('hidden');
                document.getElementById("success").classList.add('hidden');
                document.getElementById("failed").classList.remove('hidden');
            } else {
                console.error("Failed to retrieve RFID tag.");
            }
        });

        scanCard.bind("pusher:subscription_error", function(status) {
            console.error("Subscription error:", status);
        });
    });
</script>
@endsection