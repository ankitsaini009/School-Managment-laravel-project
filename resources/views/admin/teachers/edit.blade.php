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
            <h3 class="card-title">Add School Teacher</h3>
            <form action="{{ route('edit.teacher') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="row">
                    <input type="hidden" name="id" value="{{ $teacher->id }}">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputName1">Teacher Name</label>
                        <input type="text" Name="Teacher_Name" class="form-control {{ $errors->has('Teacher_Name') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Name" value="{{ $teacher->name ? $teacher->name : old('Teacher_Name') }}">
                        @error('Teacher_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputEmail3">Teacher Email</label>
                        <input type="email" Name="Teacher_Email" class="form-control {{ $errors->has('Teacher_Email') ? 'is-invalid' : '' }}" id="exampleInputEmail3" placeholder="Email" value="{{ $teacher->email ? $teacher->email : old('Teacher_Email') }}">
                        @error('Teacher_Email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label>Select Subjects</label>
                        <div>
                            <select class="js-example-basic-multiple-subjects select2-hidden-accessible form-control" data-select2-id="4" id="selectsubjects" tabindex="-1" aria-hidden="true" name="subjects[]">
                                @php
                                if(!empty($subjectids)){
                                $subjectids = json_decode($classes_subject->subject_ids);
                                }
                                @endphp
                                @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (isset($subjectids) &&  in_array($subject->id, $subjectids) ? 'selected' : '')}}>
                                    {{ $subject->subject_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('subjects')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label>Select Classes</label>
                        <div>
                            <select class="js-example-basic-multiple-classes select2-hidden-accessible form-control" data-select2-id="3" id="selectclasses" tabindex="-1" aria-hidden="true" name="classes[]" multiple>
                                @php
                                if(!empty($classids)){
                                $classids = json_decode($classes_subject->class_ids);
                                }
                                @endphp
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ (isset($classids) && in_array($class->id, $classids) ? 'selected' : '')}}>
                                    {{ $class->class_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('classes')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputEmail3">Contact Number</label>
                        <input type="Number" Name="Teacher_Number" class="form-control {{ $errors->has('Teacher_Number') ? 'is-invalid' : '' }}" id="exampleInputEmail3" placeholder="Number" value="{{ $teacher->phone_number ? $teacher->phone_number : old('Teacher_Number') }}">
                        @error('Teacher_Number')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputEmail3">Teacher Password<span class="mandatory-symbol">*</span></label>
                        <input type="password" Name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="exampleInputEmail3" placeholder="password" value="{{old('password')}}">
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputName1">Teacher Monthly Salary</label>
                        <input type="number" Name="Teacher_Salary" class="form-control {{ $errors->has('Teacher_Salary') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Salary" value="{{ $teacher->salary ? $teacher->salary : old('Teacher_Salary') }}">
                        @error('Teacher_Salary')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleInputName1">Teacher Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1" {{ $teacher->status == 1 ? 'selected':'' }}>Active</option>
                            <option value="0" {{ $teacher->status == 0 ? 'selected':'' }}>Inactive</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label>Select School<span class="mandatory-symbol">*</span></label>
                        <div>
                            <select name="school" id="" class="form-control">
                                <option value="">Select School</option>
                                @foreach ($schools as $subject)
                                <option value="{{ $subject->id }}" {{($subject->id == $teacher->school? 'selected' : '')}}>{{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('subjects')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="exampleTextarea1">Adress</label>
                        <textarea class="form-control" name="address" rows="5" id="exampleTextarea1">{{$teacher->address}}</textarea>
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
                                        id='exampleInputEmail3' placeholder='Document Name' value='' required>
                                </div>
        
                                <div class='form-group col-md-5 col-sm-12'>
                                    <label for='document_photo'>Document Photo <span class='text-danger'>*</span></label>
                                    <input type='file' name='document_photo[` + count + `]' class='file-upload-default fileupload' id='document_photo' required>
                                    <div class='input-group col-xs-12'>
                                        <input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image'>
                                        <span class='input-group-append'>
                                            <button class='file-upload-browse btn btn-primary' type='button'>Choose</button>
                                        </span>
                                    </div>
                                    <small id='document_photo_error' class='form-text text-danger d-none'>Please select a document photo.</small>
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
        @endsection