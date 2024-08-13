@extends('admin.layouts.main')
@section('main-container')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Site Setting</h3>
      <p class="card-description">
        Customize Your Site Settings
      </p>
      <form action="{{route('site.setting.update')}}" method="POST" enctype="multipart/form-data" class="forms-sample">
        @csrf
        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputName1">Site Name</label>
            <input type="text" name="site_name" class="form-control {{$errors->has('site_name') ? 'is-invalid':''}}" id="exampleInputName1" placeholder="Name" value="{{$sitedata->site_name ? $sitedata->site_name:old('site_name')}}">
            @error('site_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputEmail3">Site Email</label>
            <input type="email" name="site_email" class="form-control {{$errors->has('site_email') ? 'is-invalid':''}}" id="exampleInputEmail3" placeholder="Email" value="{{$sitedata->site_email ? $sitedata->site_email:old('site_email')}}">
            @error('site_email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputPassword4">Site Contact Number</label>
            <input type="text" name="site_contact" class="form-control {{$errors->has('site_contact') ? 'is-invalid':''}}" id="exampleInputPassword4" placeholder="Contanct Number" value="{{$sitedata->site_contact ? $sitedata->site_contact:old('site_contact')}}">
          </div>

          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputPassword4">Adress</label>
            <textarea class="form-control" name="site_address" id="exampleTextarea1" rows="1" placeholder="Address">{{$sitedata->site_address ? $sitedata->site_address:old('site_address')}}</textarea>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label>Site Logo</label>
            <input type="file" name="site_logo" class="file-upload-default">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Choose</button>
              </span>
            </div>
            <img src="{{url($sitedata->site_logo)}}" style="width: 200px" class="mt-2" alt='profile'>
          </div>

          <div class="form-group col-md-6 col-sm-12">
            <label>Site Icon</label>
            <input type="file" name="site_fav_icon" class="file-upload-default">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Choose</button>
              </span>
            </div>
            <img src="{{url($sitedata->site_fav_icon)}}" class="mt-2" alt="" style="width: 200px">
          </div>
        </div>
        <div class="form-group">
          <label for="exampleTextarea1">Header Code</label>
          <textarea class="form-control" name="header_code" id="exampleTextarea1" rows="4">{{$sitedata->header_code ? $sitedata->header_code:old('header_code')}}</textarea>
        </div>
        <div class="form-group">
          <label for="exampleTextarea1">Footer Code</label>
          <textarea class="form-control" name="footer_code" id="exampleTextarea1" rows="4">
          {{$sitedata->footer_code ? $sitedata->footer_code:old('footer_code')}}
          </textarea>
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
      </form>
    </div>
    @section('scripts')
    <script>
      $(document).ready(function() {
        $('.file-upload-browse').click(function() {
          $(this).closest('.form-group').find('.file-upload-default').click();
        });

        $('.file-upload-default').change(function() {
          var filename = $(this).val().split('\\').pop(); // Get the file name
          $(this).closest('.form-group').find('.file-upload-info').val(filename); // Set the file name as the input value
        });
      });
    </script>
    @endsection
    @endsection