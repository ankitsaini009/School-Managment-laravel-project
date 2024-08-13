@extends('front.layouts.main')
@section('main-container')
<div class="card">
    @if(Session::has('error'))
    <div id="error-message" class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <p class="card-title">Classe's List</p>
            <p class="card-title"><button id="addclass" type="button" class="btn btn-info btn" data-toggle="modal" data-target="#contact-modal">Add Class</button></p>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="display expandable-table data-table no-footer" style="width: 100%;" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th class="select-checkbox sorting_disabled" style="width: 40px !important;">Sr.No.</th>
                                            <th class="sorting_asc text-center" style="width: 51px;">Class Name</th>
                                            <th class="sorting_asc text-center" style="width: 51px;">Teacher Name</th>
                                            <th class="sorting text-center" style="width: 58px;">Status</th>
                                            <th class="details-control sorting_disabled text-center" style="width: 0px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5"></div>
                            <div class="col-sm-12 col-md-7"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('classindex')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'class_name',
                    name: 'class_name'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                    "width": "5%",
                    "targets": 0
                }, // First column width set to 20%
                {
                    "width": "15%",
                    "targets": -1
                }, // First column width set to 20%
                {
                    "className": "dt-center",
                    "targets": "_all"
                }
            ]
        });
    });
</script>
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
                            @csrf
                            <div class="row">
                                <input type="hidden" name="class_id" value="" id="editclass_id">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="exampleInputName1">Class Name</label>
                                    <input type="text" Name="class_name" class="form-control" id="className" placeholder="Name" value="">
                                    <div id="nameerror" class="text-danger"></div>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="exampleInputName1">Status</label>
                                    <select name="status" class="form-control" id="class_status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submitBtn" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#submitBtn').click(function() {
                    var className = $('#className').val();
                    // Simple validation example (you can add more complex validation as needed)
                    if (className.trim() === '') {
                        $('#nameerror').text('Please Enter Class Name');
                        $('#className').css('border-color', 'red');
                        return;
                    } else {
                        $('#nameerror').text('');
                        $('#className').css('border-color', '');
                    }
                    $('#classForm').submit();
                });
            });
        </script>
        <script>
            $(document).on('click', '#addclass', function() {
                $('#className').val('');
                $('#class_status').val(1);
                $('.modal-title').text('Add Class');
                $('#classForm').attr('action', '{{ route("classadd") }}');
            });

            $(document).on('click', '.editclass', function() {
                classid = $(this).attr('classid');
                $.ajax({
                    url: '{{ route("class.data") }}',
                    method: 'get',
                    DataType: 'JSON',
                    data: {
                        id: classid
                    },
                    success: function(data) {
                        var data = $.parseJSON(data);
                        $('#className').val(data.class_name);
                        $('#class_status').val(data.status);
                        $('#editclass_id').val(data.id);

                    }

                }).then(function() {
                    $('.modal-title').text('Edit Class');
                    $('#classForm').attr('action', '{{ route("classedit") }}');
                    $('#contact-modal').modal('show');
                })
            });
            $(document).ready(function() {
                if ($('.js-example-basic-multiple').length > 0) {
                    $('.js-example-basic-multiple').select2();
                } else {
                    console.error("Select element with class 'js-example-basic-multiple' not found.");
                }
            });
        </script>
        @endsection