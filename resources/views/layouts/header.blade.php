@php
$sitedata = sitedata();
@endphp
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('/frontcss/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/frontcss/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('/frontcss/css/media.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/')}}vendors/feather/feather.css">
    <link rel="stylesheet" href="{{asset('/')}}vendors/ti-icphp ons/css/themify-icons.css">
    <link rel="stylesheet" href="{{asset('/')}}vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{asset('/')}}css/vertical-layout-light/style.css">
    <!-- endinject -->
    <style>
        .is-invalid {
            border-color: red;
        }
  /* Custom styles for the navbar */
.navbar-custom {
    background-color: #e4e4e4 !important; /* Ensure background color is the same on all screen sizes */
}

/* Ensure navbar text color is appropriate */
.navbar-custom .nav-link {
    color: #000000 !important; /* Change to desired text color */
}

/* Ensure navbar toggler icon is visible */
.navbar-custom .navbar-toggler {
    border-color: #000000 !important; /* Change to desired border color */
}

.navbar-custom .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba(0, 0, 0, 1.0)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
}

/* Media query for small screens */
@media (max-width: 991.98px) {
    .navbar-custom .navbar-collapse {
        background-color: #e4e4e4 !important; /* Ensure background color is the same when navbar is collapsed */
    }
    .navbar-custom .nav-link {
        color: #000000 !important; /* Ensure text color is correct when navbar is collapsed */
    }
}

    </style>

    <link rel="shortcut icon" href="{{asset($sitedata->site_fav_icon)}}" />
    <title>{{ env('SITE_NAME') }}</title>
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light p-0 navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset($sitedata->site_logo)}}" style="width:123px;margin-left: -163px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('teacher.login.page')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('registertion')}}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    </header>