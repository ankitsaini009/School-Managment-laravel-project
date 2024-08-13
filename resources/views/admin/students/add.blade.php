@extends('admin.layouts.main')
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
            <h3 class="card-title">Add School Student</h3>
            <form action="{{ route('add.student') }}" id="addstudent" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Student Name<span class="mandatory-symbol">*</span></label>
                        <input type="text" Name="Student_Name" class="form-control {{ $errors->has('Student_Name') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Student Name" value="{{ old('Student_Name') }}">
                        @error('Student_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 col-sm-12">
                        <label>Select Classes<span class="mandatory-symbol">*</span></label>
                        <div>
                            <select class="js-example-basic-single w-100 select2-hidden-accessible form-control" id="selectclasses" name="student_class">
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}" calssname="{{ $class->class_name }}">
                                    {{ $class->class_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('student_class')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputName1">Student Status<span class="mandatory-symbol">*</span></label>
                        <select name="status" id="" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 col-sm-12">
                        <label>Select Teacher<span class="mandatory-symbol">*</span></label>
                        <div>
                            <select class="js-example-basic-single w-100 select2-hidden-accessible" id="selectclasses" name="teacher_id">
                                <option value="">Select Teacher</option>
                                @foreach ($Teacher as $Teachers)
                                <option value="{{ $Teachers->id }}">
                                    {{ $Teachers->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('class')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="documents">
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
                if ($('.js-example-basic-single').length > 0) {
                    $('.js-example-basic-single').select2();
                } else {
                    console.error("Select element with class 'js-example-basic-single' not found.");
                }
            });
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
                    var filename = $(this).val().split('\\').pop();
                    $(this).closest('.form-group').find('.file-upload-info').val(filename);
                });
            });
        </script>
        <script>
            $(document).on('change', '#selectclasses', function() {
                classval = $(this).val();
                if (classval && classval.length > 0) {
                    $.ajax({
                        url: '{{ route("class.subjects") }}',
                        method: 'get',
                        data: {
                            id: classval
                        },
                        success: function(response) {
                            $('#selectsubjects').empty();
                            $('#selectsubjects').append(response).select2();
                            $('#selectsubjects').trigger('change.select2');
                        }
                    });
                } else {
                    $('#selectsubjects').empty();
                    $('#selectsubjects').trigger('change.select2');
                }
            });

            $(document).ready(function() {
                $('#dob').datepicker({
                    autoclose: true,
                    endDate: new Date(),
                    format: 'dd-mm-yyyy',
                });
            });
            $(document).ready(function() {
                $('#addminson_date').datepicker({
                    autoclose: true,
                    endDate: new Date(),
                    format: 'dd-mm-yyyy',
                });
            });
        </script>
        @endsection