<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Student Temperature Monitoring System</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin.jpg ') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center" style="font-size: 25px; word-wrap: break-word; overflow-wrap: break-word;">
                                Student Temperature Monitoring System
                            </div>
                        </div>


                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                @if (Route::has('login'))
                                @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bx bx-dashboard text-primary"></i>
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bx bx-log-in text-danger"></i>
                                </a>
                            </li>
                            @endauth
                            @endif
                        </ul>
                        </li>
                        <!--/ User -->
                        </ul>

                    </div>
                </nav>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <h5 class="card-header">Student Info</h5>
                                    <div class="card-body">
                                        <div>
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-auto text-center">
                                                    <img src="{{ asset('assets/img/admin.jpg') }}" id="profile_img" alt="Student Avatar" class="rounded-circle" style="width: 150px; height: 150px;">
                                                    <div style="margin-top: 5px;"><label>Avatar</label></div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="student_id" class="form-label">Student ID</label>
                                                <input type="text" class="form-control text-primary" name="student_id" id="student_id" placeholder="21-008083" readonly />
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control text-primary" name="name" id="name" placeholder="John Doe" readonly />
                                            </div>
                                            <div class="mb-3">
                                                <label for="course" class="form-label">Course</label>
                                                <input type="text" class="form-control text-primary" name="course" id="course" placeholder="BSIT" readonly />
                                            </div>
                                            <div class="mb-3">
                                                <label for="year_level" class="form-label">Year Level</label>
                                                <input type="number" class="form-control text-primary" name="year_level" id="year_level" placeholder="4" readonly />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <h5 class="card-header">Temparature Details</h5>
                                    <div class="card-body">
                                        <div>
                                            <form id="temp-reading" method="POST">
                                                <div class="mb-3">
                                                    <label for=temperature" class="form-label">Temparature</label>
                                                    <input id="inputFahrenheit" type="number" placeholder="Fahrenheit" oninput="temperatureConverter(this.value)" onchange="temperatureConverter(this.value)" class="form-control" step="any">
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-success" id="recordTempBtn" type="button">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
        </div>
        <!-- / Layout wrapper -->


        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

        <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script>
            function temperatureConverter(valNum) {
                valNum = parseFloat(valNum);
                document.getElementById("outputCelsius").innerHTML = (valNum - 32) / 1.8;
            }
        </script>

        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            Pusher.logToConsole = true;

            var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            });

            pusher.unsubscribe('rfid-scanner_channel');

            var scanCard = pusher.subscribe('idSensor_channel');
            scanCard.bind('id-detected', function(data) {

                if (data.status == 200) {
                    console.log(data.data.student_id);

                    document.getElementById('profile_img').src = "{{ asset('/storage/') }}" + "/" + data.data.avatar || '';
                    document.getElementById('student_id').value = data.data.student_id;
                    document.getElementById('name').value = data.data.name;
                    document.getElementById('course').value = data.data.course;
                    document.getElementById('year_level').value = data.data.year_level;

                } else {
                    swal({
                        title: data.message,
                        text: "Please register your RFID card or use a different one.",
                        icon: "warning",
                        button: "Ok",
                    });
                }
            });
            scanCard.bind('pusher:subscription_error', function(status) {
                console.error('Subscription error:', status);
            });
        </script>
        <script>
            Pusher.logToConsole = true;

            var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            });

            var tempRead = pusher.subscribe('temp_reading_channel');
            tempRead.bind('temp_reading_channel', function(data) {

                if (data.status == 200) {
                    document.getElementById('inputFahrenheit').value = data.data;

                    var student_id = document.querySelector('#student_id').value;
                    var submitBtn = document.querySelector('#recordTempBtn');
                    var studentTemp = {
                        student_id: student_id,
                        temp: data.data,
                    }

                    submitBtn.addEventListener('click', function() {
                        fetch('https://bodytempmonitor.test/api/temperature_records/store', {
                                method: 'POST', // Set the method to POST
                                headers: {
                                    'Content-Type': 'application/json', // The type of data you're sending
                                },
                                body: JSON.stringify(studentTemp), // Convert the data object to a JSON string
                            })
                            .then(response => response.json()) // Parse the response as JSON
                            .then(data => {
                                console.log('Success:', data);
                                if (data.status_code == 200) {
                                    swal({
                                        title: data.message,
                                        text: "Student " + studentTemp.student_id + " with " + studentTemp.temp + " has been recorded",
                                        icon: "success",
                                        button: "Ok",
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    swal({
                                        title: data.message,
                                        text: "Student " + studentTemp.student_id + " with " + studentTemp.temp + " not recorded",
                                        icon: "danger",
                                        button: "Ok",
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });

                    })
                }
            });
            tempRead.bind('pusher:subscription_error', function(status) {
                console.error('Subscription error:', status);
            });
        </script>
</body>

</html>