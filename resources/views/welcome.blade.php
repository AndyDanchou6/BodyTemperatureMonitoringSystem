<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Body Temperature Monitor System</title>


    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/bs-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/boxicons/boxicons.css') }}" rel="stylesheet">

</head>

<body style="overflow: hidden;">
    <header class="bg-secondary w-100">
        <div class="container-fluid bg-dark">
            <div class="row">
                <div class="p-3 px-md-5">
                    <h4 class="text-white text-center">Body Temperature Monitoring System</h4>
                </div>
            </div>
        </div>
    </header>
    <main style="overflow-y: auto; overflow-x: hidden;">
        <div class="container my-4">
            <div id="id-searchbar" class="mb-4">
                <form class="d-flex justify-content-center">
                    <input type="text" class="form-control w-50" placeholder="Enter Student ID" aria-label="Student ID">
                    <button class="btn btn-primary ms-2" type="submit">Search</button>
                </form>
            </div>

            <div class="row">
                <div class="temp-details col-md-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5>Student Info</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="studentName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="studentName" placeholder="Student Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="studentID" class="form-label">ID</label>
                                    <input type="text" class="form-control" id="studentID" placeholder="Student ID" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="studentCourse" class="form-label">Course</label>
                                    <input type="text" class="form-control" id="studentCourse" placeholder="Course" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="age" placeholder="Age" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="student-info col-md-8">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5>Temperature Details</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="temperature" class="form-label">Temperature</label>
                                    <input type="text" class="form-control" id="temperature" placeholder="Temperature" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="time" class="form-label">Timestamp</label>
                                    <input type="text" class="form-control" id="timestamp" placeholder="Recorded Timestamp" readonly>
                                </div>
                                <div class="mb-4">
                                    <button class="btn btn-danger ms-2" type="submit">Check Temperature</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>