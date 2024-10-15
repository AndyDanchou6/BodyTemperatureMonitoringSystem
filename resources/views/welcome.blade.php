<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/bs-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/boxicons/boxicons.css') }}" rel="stylesheet">

</head>

<body style="overflow: hidden;">
    <header class="bg-secondary w100">
        <div class="container-fluid bg-dark">
            <div class="row">
                <div class="p-3 px-md-5">
                    <h4 class="text-white text-center">Body Temperature Monitoring System</h4>
                </div>
            </div>
        </div>
    </header>
    <main style="overflow-y: auto; overflow-x: hidden;">
        <div id="id-searchbar">
            <!-- Id Search Bar  -->
        </div>
        <div style="height: 100vh; width: 100vw;">
            <div class="container-fluid">
                <div class="row">
                    <div class="temp-details col-md-4">
                        <div id="temperature-details">
                            Temp Details
                        </div>
                    </div>
                    <div class="student-info col-md-8">
                        <div id="student-info">
                            Student Info
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div></div>
    </footer>
</body>

</html>