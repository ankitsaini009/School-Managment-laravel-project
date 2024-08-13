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
                <h3 class="card-title">Add Certificates</h3>
                <form action="{{ route('edit.certificate') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                    @csrf
                    <input type="hidden" name="id" value="{{$certificate->id}}">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="exampleInputName1">Certificate Name</label>
                            <input type="text" Name="Certificate_Name"
                                class="form-control {{ $errors->has('Certificate_Name') ? 'is-invalid' : '' }}"
                                id="exampleInputName1" placeholder="Name" value="{{$certificate->certificate_name ? $certificate->certificate_name:''}}">
                            @error('Certificate_Name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="exampleInputName1">Certificate Status</label>
                            <select name="status" id="" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <option value="">Select Status</option>
                                <option value="1" {{$certificate->status ==1 ? 'selected':''}}>Active</option>
                                <option value="0" {{$certificate->status ==0 ? 'selected':''}}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Certificate Tamplate</label>
                            <input type="file" Name="Certificate_Template" id="certificate_tamp"
                                class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text"
                                    class="form-control file-upload-info {{ $errors->has('Certificate_Template') ? 'is-invalid' : '' }}"
                                    disabled="" placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Choose</button>
                                </span>
                            </div>
                            <a href="{{asset('storage/certificates/' . $certificate->certificate_temp_path)}}" target="_blank"><img src="{{ asset('storage/certificates/' . $certificate->certificate_temp_path) }}" alt=""
                                class="img-fluid" style="height: 200px"></a>
                            @error('Certificate_Template')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Name Font</label>
                            <input type="file" Name="name_font" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text"
                                    class="form-control file-upload-info"
                                    disabled="" placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Choose</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div>
                            <p><span class="mandatory-symbol">Note:</span>In The Discription Use  '[HOLDER_NAME]','[HOLDER_PARENT]','[HOLDER_CLASS]','[HOLDER_SCHOLL]' For Custome Details</p>
                            </div>
                            <label for="exampleInputName1">Certificate Discription</label>
                            <textarea name="Certificate_Discription" class="form-control {{ $errors->has('Certificate_Discription') ? 'is-invalid' : '' }}" id="" rows="5">{{$certificate->certificate_discription ? $certificate->certificate_discription: ''}}</textarea>
                            @error('Certificate_Discription')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="exampleInputName1">Discription Text Color</label>
                            <div id="colorPicker" ></div>
                            <input type="hidden" id="colorInput" name="Discription_Color" value="{{$certificate->discription_color}}" class="form-control {{ $errors->has('Discription_Color') ? 'is-invalid' : '' }}">
                            @error('Discription_Color')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Discription Font</label>
                            <input type="file" Name="Discription_Font" id="font_file" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text"
                                    class="form-control file-upload-info"
                                    disabled="" placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Choose</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary col-4 mr-2">Submit</button>
                    </div>
                </form>
            </div>
        @endsection
        @section('scripts')
            <script>
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

                            // Main components
                            preview: true,
                            opacity: true,
                            hue: true,

                            // Input / output Options
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
                    $(document).on('click', '.file-upload-browse', function() {
                        $(this).closest('.form-group').find('.file-upload-default').click();
                    });

                    $(document).on('change', '.file-upload-default', function() {
                        var filename = $(this).val().split('\\').pop(); // Get the file name
                        $(this).closest('.form-group').find('.file-upload-info').val(
                            filename); // Set the file name as the input value
                    });
                });
                $(document).ready(function() {
                    $('#certificate_tamp').change(function() {
                        var file = $(this)[0].files[0];
                        if (file) {
                            // Check if the selected file type is JPEG
                            if (file.type === 'image/jpeg') {
                                // JPEG file selected, proceed with handling it
                                console.log('Selected file is a JPEG');
                            } else {
                                // Not a JPEG file, notify the user and clear the input
                                alert('Please select a JPEG file.');
                                $(this).val('');
                            }
                        }
                    });
                });
                $(document).ready(function() {
                    $('#font_file').change(function() {
                        var file = $(this)[0].files[0];
                        if (file) {
                            // Get the file name and extension
                            var fileName = file.name;
                            var fileExt = fileName.split('.').pop().toLowerCase();
                            // Check if the file extension is ttf
                            if (fileExt === 'ttf') {
                                // TTF file selected, proceed with handling it
                                console.log('Selected file is a TTF');
                            } else {
                                // Not a TTF file, notify the user and clear the input
                                alert('Please select a TTF file.');
                                $(this).val('');
                            }
                        }
                    });
                });
            </script>
        @endsection
