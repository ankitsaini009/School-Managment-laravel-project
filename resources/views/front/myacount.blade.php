@extends('front.layouts.main')
@section('main-container')
<div class="col-12 grid-margin stretch-card">
  <style>
    .select2-container {
      width: 100% !important;
      /* Adjust width as needed */
    }

    .select2-selection {
      height: 46px !important;
    }

    .is-invalid+.select2-container {
      border-color: #dc3545 !important;
      /* Red border color */
    }

    .invalid-feedback {
      color: #dc3545;
      /* Red text color for error message */
    }
  </style>
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Add School Teacher</h3>
      <form action="{{ route('proupdate', $user->id) }}" method="POST" enctype="multipart/form-data" class="forms-sample">
        @csrf
        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputName1">Teacher Name<span class="mandatory-symbol">*</span></label>
            <input type="text" Name="Teacher_Name" class="form-control {{ $errors->has('Teacher_Name') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Name" value="{{$user->name}}">
            @error('Teacher_Name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputEmail3">Teacher Email<span class="mandatory-symbol">*</span></label>
            <input type="email" Name="Teacher_Email" class="form-control {{ $errors->has('Teacher_Email') ? 'is-invalid' : '' }}" id="exampleInputEmail3" placeholder="Email" value="{{ $user->email }}">
            @error('Teacher_Email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="exampleInputEmail3">Contact Number<span class="mandatory-symbol">*</span></label>
            <input type="Number" Name="Teacher_Number" class="form-control {{ $errors->has('Teacher_Number') ? 'is-invalid' : '' }}" id="exampleInputEmail3" placeholder="Number" value="{{ $user->phone_number }}">
            @error('Teacher_Number')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          </div>
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
      </form>
    </div>
    @endsection
    @section('scripts')
    <script>
      $(document).ready(function() {
        if ($('.js-example-basic-multiple-subjects').length > 0) {
          $('.js-example-basic-multiple-subjects').select2();
        } else {
          console.error("Select element with class 'js-example-basic-multiple-subjects' not found.");
        }
      });
      $(document).ready(function() {
        if ($('.js-example-basic-multiple-classes').length > 0) {
          $('.js-example-basic-multiple-classes').select2();
        } else {
          console.error("Select element with class 'js-example-basic-multiple-classes' not found.");
        }
      });

      count = 0;

      function adddocument() {
        html = `<div class='row'>
                                <div class='form-group col-md-5 col-sm-12'>
                                    <label for='exampleInputEmail3'>Document Name</label>
                                    <input type='text' Name='document_name[` + count + `]' class='form-control'
                                        id='exampleInputEmail3' placeholder='Document Name' value=''>
                                </div>
        
                                <div class='form-group col-md-5 col-sm-12'>
                                    <label>Document Photo</label>
                                    <input type='file' name='document_photo[` + count + `]' class='file-upload-default fileupload'>
                                    <div class='input-group col-xs-12'>
                                        <input type='text' class='form-control file-upload-info' disabled=''
                                            placeholder='Upload Image'>
                                        <span class='input-group-append'>
                                            <button class='file-upload-browse btn btn-primary' type='button'>Choose</button>
                                        </span>
                                    </div>
                                </div>
                                <div class='form-group col-2'>
                                    <label for='exampleInputFile' style='visibility: hidden;'>Action</label><br>
                                    <a class='btn btn-danger rounded-pill remove' href='javascript:void(0);'>Remove</a>
                                  </div>
                              </div>`;
        $('.documents').append(html)
        count++;
      }
    </script>
    <script>
      $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
      });
      $(document).ready(function() {
        $(document).on('click', '.file-upload-browse', function() {
          $(this).closest('.form-group').find('.file-upload-default').click();
        });

        $(document).on('change', '.file-upload-default', function() {
          var filename = $(this).val().split('\\').pop(); // Get the file name
          $(this).closest('.form-group').find('.file-upload-info').val(
            filename); // Set the file name as the input value
        });
      });
    </script>
    <script>
      $(document).on('change', '#selectsubjects', function() {
        subval = $(this).val();
        if (subval && subval.length > 0) {
          $.ajax({
            url: '{{route("class.control")}}',
            method: 'get',
            data: {
              ids: subval
            },
            success: function(response) {
              $('#selectclasses').empty();
              response.forEach(function(classData) {
                $('#selectclasses').append('<option value="' + classData.id + '">' + classData.class_name + '</option>');
              });
              $('#selectclasses').trigger('change.select2');
            }
          });
        } else {

          $('#selectclasses').empty();
          $('#selectclasses').trigger('change.select2');
        }
      });
    </script>
    @endsection