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
            <h3 class="card-title">Add School Student</h3>
            <form action="{{ route('studentedit',$student_data->id) }}" id="editstudent" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Student Name<span class="mandatory-symbol">*</span></label>
                        <input type="text" Name="Student_Name" class="form-control {{ $errors->has('Student_Name') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Student Name" value="{{ $student_data->name }}">
                        @error('Student_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label>Select Classes<span class="mandatory-symbol">*</span></label>
                        <div>
                            <select class="js-example-basic-single w-100 select2-hidden-accessible" id="selectclasses" name="class">
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}" calssname="{{ $student_data->class_name }}" {{ $student_data->class == $class->id  ?'selected':''}}>
                                    {{ $class->class_name }}
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
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary col-3">Submit</button>
                </div>
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

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Function to format date
                function formatDate(dateString) {
                    var dateParts = dateString.split("-");
                    var dob = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);

                    // Format the date as dd-mm-yyyy
                    var formattedDate = dob.getDate().toString().padStart(2, '0') + "-" +
                        (dob.getMonth() + 1).toString().padStart(2, '0') + "-" +
                        dob.getFullYear();

                    return formattedDate;
                }

                // Get the value of the input field for each field you want to format
                var dobValue = document.getElementById("dob").value;
                var addminson_date = document.getElementById("addminson_date").value;

                // Format each date
                var formattedDOB = formatDate(dobValue);
                var formattedOtherDate = formatDate(addminson_date);

                // Update the input field values with the formatted dates
                document.getElementById("dob").value = formattedDOB;
                document.getElementById("addminson_date").value = formattedOtherDate;
            });
        </script>
        @endsection