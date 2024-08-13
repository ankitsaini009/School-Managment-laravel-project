@extends('layouts.main')
@section('main-container')
@php
$sitedata = sitedata();
@endphp

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
              <h4>Hello! Teacher Manage Everything</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" action="{{route('teachers.login')}}" method="POST">
                @csrf
                <div class="form-group">
                  @error('email')
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

                <div class="d-flex justify-content-between align-items-center">
                  <!-- Checkbox -->
                  <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                    <label class="form-check-label" for="form2Example3">
                      Remember me
                    </label>
                  </div>
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                  <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{route('registertion')}}" class="link-danger">Register</a></p>
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
  @endsection