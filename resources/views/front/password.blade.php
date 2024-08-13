@extends('front.layouts.main')
@section('main-container')
<!-- Content -->
<br>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Change Your Password</div>

        <div class="card-body">
          <form action="{{ route('passedit')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label for="old_password">Old Password</label>
              <input id="old_password" class="form-control" type="password" name="old_password" placeholder="Enter your old password" value="">
              @error('old_password')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div><br>

            <div class="form-group">
              <label for="new_password">New Password</label>
              <input id="new_password" class="form-control" type="password" name="new_password" placeholder="Enter your new password" value="">
              @error('new_password')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div><br>

            <div class="form-group">
              <label for="conform_password">Confirm New Password</label>
              <input id="conform_password" class="form-control" type="password" name="confirm_password" placeholder="Confirm your new password" value="">
              @error('confirm_password')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div><br>
            <div class="form-group">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection