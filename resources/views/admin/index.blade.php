@php
$sitedata = sitedata();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SCHOOL Admin Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('/')}}vendors/feather/feather.css">
  <link rel="stylesheet" href="{{asset('/')}}vendors/ti-icphp ons/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('/')}}vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="{{asset('/')}}css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('storage/site/'.$sitedata->site_fav_icon)}}" />
  <style>
    .is-invalid {
      border-color: red;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{asset($sitedata->site_logo)}}" alt="logo">
              </div>
              <h4>Hello! Admin Manage Everything</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" action="{{route('login')}}" method="POST">
                @csrf
                <div class="form-group">
                  @error('email_or_number')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                  <input type="text" class="form-control form-control-lg {{$errors->has('email_or_number') ? 'is-invalid':''}}" id="exampleInputEmail1" placeholder="Email Or Number" name="email_or_number" value="{{old('email_or_number')}}">
                </div>
                <div class="form-group">
                  @error('password')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                  <input type="password" class="form-control form-control-lg {{$errors->has('password') ? 'is-invalid':''}}" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="text-danger">
                  @if(session()->has('error'))
                  {{ session()->get('error') }}
                  @endif
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{asset('/')}}vendors/js/vendor.bundle.base.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Focus on the input field with validation error
      $('.is-invalid').first().focus();
    });
  </script>
  <script src="{{asset('/')}}js/off-canvas.js"></script>
  <script src="{{asset('/')}}js/hoverable-collapse.js"></script>
  <script src="{{asset('/')}}js/template.js"></script>
  <script src="{{asset('/')}}js/settings.js"></script>
  <script src="{{asset('/')}}js/todolist.js"></script>
</body>

</html>