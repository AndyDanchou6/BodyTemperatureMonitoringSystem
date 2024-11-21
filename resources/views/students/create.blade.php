@extends('app')

@section('content')
<style>
    .hidden {
        display: none;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header">Student Registration Form</h5>
        <div class="card-body">
            <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
                <div class="col-auto text-center">
                    <img src="{{ asset('assets/img/user.png') }}" id="avatarPreview" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                    <div style="margin-top: 5px;"><label>Avatar</label></div>
                </div>
            </div>
            <!-- Form Start -->
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>

                    <div class="row mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="avatar" id="userAvatar" aria-describedby="name_help" />
                            <small id="userAvatarFileError" class="form-text text-danger text-wrap hidden">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Scan your RFID Card" aria-describedby="student_id_help" readonly />
                                <span class="input-group-text hidden" id="icon">
                                    <i class="bx bx-check text-success hidden" id="success"></i>
                                    <i class="bx bx-x-circle text-danger hidden" id="failed"></i>
                                </span>
                            </div>
                            <div id="rfid-warning" class="form-text hidden text-danger">
                                <strong>Warning:</strong> This RFID Card is already registered. Please use a different RFID card.
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" aria-describedby="name_help" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="defaultSelect" class="form-label">Course</label>
                        <div class="input-group">
                            <select id="defaultSelect" name="course" class="form-select">
                                <option value="" disabled selected>Choose Course</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BEED">BEED</option>
                                <option value="BSED-SS">BSED-SS</option>
                                <option value="BSED-MATH">BSED-MATH</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="defaultSelect" class="form-label">Year Level</label>
                        <div class="input-group">
                            <select id="defaultSelect" name="year_level" class="form-select">
                                <option value="" disabled selected>Year Level</option>
                                <option value="1">1st year</option>
                                <option value="2">2nd year</option>
                                <option value="3">3rd year</option>
                                <option value="4">4th year</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-danger">Close</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('userAvatar');
        const avatarPreview = document.getElementById('avatarPreview');
        const errorMessage = document.getElementById('userAvatarFileError');

        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            // Validate file size
            if (file && file.size > 2 * 1024 * 1024) {
                errorMessage.classList.remove('hidden');
                avatarInput.value = '';
                avatarPreview.src = "{{ asset('assets/img/user.png') }}"; // Reset to default avatar
                return;
            } else {
                errorMessage.classList.add('hidden');
            }

            // Preview avatar
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        });

        var scanCard = pusher.subscribe("rfid-scanner_channel");
        scanCard.bind("rfid-scanner_channel", function(data) {
            if (data.status == 200) {
                document.getElementById("student_id").value = data.data;
                document.getElementById("rfid-warning").classList.add('hidden');
                document.getElementById("icon").classList.remove('hidden');
                document.getElementById("success").classList.remove('hidden');
            } else if (data.status == 409) {
                document.getElementById("rfid-warning").classList.remove('hidden');
                document.getElementById("icon").classList.remove('hidden');
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

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection