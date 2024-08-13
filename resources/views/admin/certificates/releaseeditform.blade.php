@php
@endphp
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
                <h3 class="card-title">Release Certificates</h3>
                <form action="" id="certificateform" method="POST" enctype="multipart/form-data" class="forms-sample">
                    @csrf
                    <input type="hidden" name="old_data" value="{{ $releasecertificate->id }}">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Select Certificate<span class="mandatory-symbol">*</span></label>
                            <div>
                                <select class="js-example-basic-single-certificate w-100 select2-hidden-accessible"
                                    tabindex="-1" aria-hidden="true" id="selectcertificate" name="certificate_id">
                                    <option value="">Select Certificate</option>
                                    @foreach ($certificates as $certificate)
                                        <option value="{{ $certificate->id }}"
                                            {{ $certificate->certificate_name == $releasecertificate->certificate_name ? 'selected' : '' }}>
                                            {{ $certificate->certificate_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('certificate_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Select Candidate<span class="mandatory-symbol">*</span></label>
                            <div>
                                <select class="js-example-basic-single-student w-100 select2-hidden-accessible"
                                    tabindex="-1" aria-hidden="true" id="selectcandidate" name="student_id">
                                    <option value="">Select Candidate</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ $releasecertificate->holder_id == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('student_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Set Name X-axis Position<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="name_x_position"
                                class="form-control {{ $errors->has('name_x_position') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->name_x_position }}" placeholder="Name X-axis Position">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Set Name Y-axis Position<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="name_y_position"
                                class="form-control {{ $errors->has('name_y_position') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->name_y_position }}" placeholder="Name Y-axis Position">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Set Name Font Size<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="name_fontsize"
                                class="form-control {{ $errors->has('name_fontsize') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->name_font_size }}" placeholder="Name Y-axis Position">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Certificate Discription<span class="mandatory-symbol">*</span></label>
                            <textarea name="student_discription" id="student_discription" class="form-control" rows="4">{{ $releasecertificate->discription }}</textarea>
                            @error('student_discription')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Set Discription X-axis Position<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="discrip_x_position"
                                class="form-control {{ $errors->has('discrip_x_position') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->discription_x_position }}"
                                placeholder="Discription X-axis Position">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Set Discription Y-axis Position<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="discrip_y_position"
                                class="form-control {{ $errors->has('discrip_y_position') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->discription_y_position }}"
                                placeholder="Discription Y-axis Position">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Discription Font Size<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="discription_fontsize"
                                class="form-control {{ $errors->has('discription_fontsize') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->discription_font_size }}"
                                placeholder="Discription Y-axis Position">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Give Line Length Break From<span class="mandatory-symbol">*</span></label>
                            <input type="number" name="line_length"
                                class="form-control {{ $errors->has('line_length') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->discription_line_lenght }}"
                                placeholder="Discription Y-axis Position">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Release Date<span class="mandatory-symbol">*</span></label>
                            <input type="text" name="release_date" id="release_date"
                                class="form-control {{ $errors->has('release_date') ? 'is-invalid' : '' }}"
                                value="{{ $releasecertificate->release_date ? $releasecertificate->release_date : '' }}"
                                placeholder="Release Date">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="exampleInputName1">Name Text Color<span class="mandatory-symbol">*</span></label>
                            <div class="d-flex">
                                <div id="colorPicker" class=""></div>
                                <input type="hidden" name="name_color" id="colorInput"
                                    value="{{ $releasecertificate->name_color ? $releasecertificate->name_color : '' }}"
                                    class="">
                            </div>
                            @error('name_color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 col-sm-8">
                            <label for="exampleInputName1" style="visibility: hidden;">Name Text Color</label>
                            <button type="button" onclick="addtext()" class="btn btn-success">Add More Text</button>
                        </div>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($addedtexts as $addedtext)
                            <div class='row'>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label for='exampleInputEmail3'>Enter Text</label>
                                    <input type='text' name="text_data[{{ $i }}]" class='form-control '
                                        id='exampleInputEmail3' placeholder='Enter Text' value='{{ $addedtext->text }}'>
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Text X-axix</label>
                                    <input type="number" name="text_x_position[{{ $i }}]"
                                        class="form-control" value="{{ $addedtext->text_x_position }}">
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Text Y-axix</label>
                                    <input type="number" name="text_y_position[{{ $i }}]"
                                        class="form-control " value="{{ $addedtext->text_y_position }}">
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Text Font Size</label>
                                    <input type="number" name="text_font_size[{{ $i }}]"
                                        class="form-control " value="{{ $addedtext->text_font_size }}">
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Select Font File</label>
                                    <select id="" name="text_font_file[{{ $i }}]"
                                        class="form-control ">
                                        <option value="">Select File</option>
                                        <option value="name_font"
                                            {{ $addedtext->text_font_file == 'name_font' ? 'selected' : '' }}>Name Font
                                            File
                                        </option>
                                        <option value="discription_font"
                                            {{ $addedtext->text_font_file == 'discription_font' ? 'selected' : '' }}>
                                            Discription Font File</option>
                                    </select>
                                </div>
                                <div class='form-group col-1'>
                                    <label for='exampleInputFile' style='visibility: hidden;'>Action</label><br>
                                    <a class='btn btn-danger rounded-pill'
                                        onclick="deleteitem('Are You Sure To Delete The Text ?',{{ $addedtext->id }},'{{ route('delete.item') }}','text_delete')"
                                        href='javascript:void(0);'>Remove</a>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                        <div id="addmoretext">
                        </div>
                    </div>
                </form>
                <div class="d-flex row">
                    <div class="col-md-5 offset-2">
                        <button type="button" id="genrateBtn" class="btn btn-success col-6 mr-2">Genrate</button>
                    </div>
                    <div class="col-md-5">
                        <button type="button" id="submitBtn" class="btn btn-primary col-6 mr-2">Submit</button>
                    </div>
                </div>
            </div>
            <div id="contact-modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel-2"></h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <a class="close" data-dismiss="modal">X</a>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add.class') }}" id="classForm" method="POST" class="forms-sample">
                                <div class="card">
                                    <style>
                                        .select2-container {
                                            width: 100% !important;
                                            /* Adjust width as needed */
                                        }

                                        .select2-selection {
                                            height: 46px !important;
                                        }
                                    </style>
                                    <div class="card-body">
                                        <div class="modal-content">
                                            <img id="modalImage" src="" alt="Image">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endsection
                    @section('scripts')
                        <script>
                            count = {{ $i }};

                            function addtext() {
                                html = `<div class='row'>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label for='exampleInputEmail3'>Enter Text</label>
                                    <input type='text'  Name='text_data[` + count + `]' class='form-control '
                                        id='exampleInputEmail3' placeholder='Enter Text' value='' required>
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Text X-axix</label>
                                    <input type="number"  name="text_x_position[` + count + `]" class="form-control " value="">
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Text Y-axix</label>
                                    <input type="number" name="text_y_position[` + count + `]" class="form-control " value="">
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Text Font Size</label>
                                    <input type="number" name="text_font_size[` + count + `]" class="form-control " value="">
                                </div>
                                <div class='form-group col-md-2 col-sm-12'>
                                    <label>Select Font File</label>
                                    <select name="text_font_file[` + count + `]"  id="" class="form-control ">
                                        <option value="">Select File</option>
                                        <option value="name_font">Name Font File</option>
                                        <option value="discription_font">Discription Font File</option>
                                    </select>
                                </div>
                                <div class='form-group col-1'>
                                    <label for='exampleInputFile' style='visibility: hidden;'>Action</label><br>
                                    <a class='btn btn-danger rounded-pill remove' href='javascript:void(0);' data-row-id='${count}'>Remove</a>
                                </div>
                                </div>`;
                                $('#addmoretext').append(html)
                                count++;
                            }
                            $(document).on('click', '.remove', function() {
                                var rowId = $(this).data('row-id'); // Get the unique row ID
                                $(`#row-${rowId}`).remove(); // Remove the corresponding row from DOM
                                // Remove the associated data from the form data
                                $('input[name^="text_data[' + rowId + ']"]').remove();
                                $('input[name^="text_x_position[' + rowId + ']"]').remove();
                                $('input[name^="text_y_position[' + rowId + ']"]').remove();
                                $('input[name^="text_font_size[' + rowId + ']"]').remove();
                                $('select[name^="text_font_file[' + rowId + ']"]').remove();
                                $(this).parent().parent().remove();
                            });

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
                                var dobValue = document.getElementById("release_date").value;
                                var formattedDOB = formatDate(dobValue);
                                document.getElementById("release_date").value = formattedDOB;
                            });
                            $(document).ready(function() {
                                $('#submitBtn').click(function() {
                                    var formData = $('#certificateform').serialize();
                                    $.ajax({
                                        url: '{{ route('release.certificate') }}',
                                        type: 'POST',
                                        data: formData,
                                        success: function(response) {
                                            imagename = response.image_name;
                                            $('#old_certificate').val(imagename);
                                            $('#modalImage').attr('src', ''); // Reset image source
                                            // Set the image source in the modal
                                            $('#modalImage').attr('src', response.image_url);
                                            $('#contact-modal').modal('show');
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Failed to submit form');
                                        }
                                    });
                                });
                            });
                            $(document).ready(function() {
                                $('#genrateBtn').click(function() {
                                    var formData = $('#certificateform').serialize();
                                    $.ajax({
                                        url: '{{ route('genrate.certificate') }}',
                                        type: 'POST',
                                        data: formData,
                                        success: function(response) {
                                            imagename = response.image_name;
                                            $('#modalImage').attr('src', ''); // Reset image source
                                            $('#modalImage').attr('src', response.image_url);
                                            $('#contact-modal').modal('show');
                                            $('#contact-modal').on('hidden.bs.modal', function() {
                                                // Trigger an AJAX request to delete the image file
                                                $.ajax({
                                                    url: '{{ route('delete.item') }}', // Replace this with your server endpoint to delete the image
                                                    type: 'get',
                                                    data: {
                                                        name: 'certificate_img',
                                                        id: imagename,
                                                    },
                                                    success: function(response) {
                                                        console.log(
                                                            'Image deleted successfully');
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error('Failed to delete image');
                                                    }
                                                });
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Failed to submit form');
                                        }
                                    });
                                });
                            });
                            const pickr = Pickr.create({
                                el: '#colorPicker',
                                theme: 'classic', // or 'monolith', or 'nano'
                                swatches: [
                                    'rgba(244, 67, 54, 1)',
                                    'rgba(233, 30, 99, 0.95)',
                                    'rgba(156, 39, 176, 0.9)',
                                    'rgba(103, 58, 183, 0.85)',
                                    'rgba(63, 81, 181, 0.8)',
                                    'rgba(33, 150, 243, 0.75)',
                                    'rgba(3, 169, 244, 0.7)',
                                    'rgba(0, 188, 212, 0.7)',
                                    'rgba(0, 150, 136, 0.75)',
                                    'rgba(76, 175, 80, 0.8)',
                                    'rgba(139, 195, 74, 0.85)',
                                    'rgba(205, 220, 57, 0.9)',
                                    'rgba(255, 235, 59, 0.95)',
                                    'rgba(255, 193, 7, 1)'
                                ],
                                components: {
                                    preview: true,
                                    opacity: true,
                                    hue: true,
                                    interaction: {
                                        hex: true,
                                        rgba: true,
                                        hsla: true,
                                        hsva: true,
                                        cmyk: true,
                                        input: true,
                                        clear: true,
                                        save: true
                                    }
                                }
                            });
                            pickr.on('change', (color, instance) => {
                                const hexValue = color.toHEXA().toString();
                                document.getElementById('colorInput').value = hexValue;
                            });

                            $(document).ready(function() {
                                if ($('.js-example-basic-single-certificate').length > 0) {
                                    $('.js-example-basic-single-certificate').select2();
                                } else {
                                    console.error("Select element with class 'js-example-basic-single-certificate' not found.");
                                }
                            });
                            $(document).ready(function() {
                                if ($('.js-example-basic-single-student').length > 0) {
                                    $('.js-example-basic-single-student').select2();
                                } else {
                                    console.error("Select element with class 'js-example-basic-single-student' not found.");
                                }
                            });
                            $(document).ready(function() {
                                $('#release_date').datepicker({
                                    autoclose: true,
                                    endDate: new Date(),
                                    format: 'dd-mm-yyyy',
                                });
                            });

                            $('#selectcandidate').on('change', function() {
                                student_id = $(this).val();
                                certificate_id = $('#selectcertificate').val();
                                if (certificate_id == '') {
                                    alert('Please Select Certificate First');
                                    student_id.val('');
                                } else {
                                    $.ajax({
                                        url: '{{ route('certificate.data') }}',
                                        method: 'get',
                                        data: {
                                            student_id: student_id,
                                            certificate_id: certificate_id
                                        },
                                        success: function(response) {
                                            var newValue = response;
                                            $('#student_discription').val('');
                                            $('#student_discription').val(newValue);
                                        }
                                    });
                                }
                            });
                        </script>
                        <script>
                            $('.removetext').on('click', function() {
                                text_id = $(this).attr('text_id');
                                alert(text_id);
                            });
                        </script>
                    @endsection
