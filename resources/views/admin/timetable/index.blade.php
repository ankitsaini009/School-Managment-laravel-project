@php
    $currentsession = currentsession();
@endphp
@extends('admin.layouts.main')
@section('main-container')
    <div class="row">
        @if(Session::has('error'))
    <div  id="error-message" class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-4 mb-2 mb-xl-0">
                    <h3 class="font-weight-bold">Controll The Time Table</h3>
                </div>
                <div class="col-12 col-xl-6 mb-2 mb-xl-0">
                    <div class="d-flex">
                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                            <button class="btn btn-sm btn-light bg-white" type="button">Current Session-{{ $currentsession }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2 mb-2 mb-xl-0">
                    <button id="addsubject" type="button" class="btn btn-info btn" data-toggle="modal"
                        data-target="#contact-modal">Add Period</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .table {
            font-size: 12px; /* Reduce font size */
        }
    
        .table th,
        .table td {
            padding: 4px; /* Reduce padding */
        }
    
        .table-bordered th,
        .table-bordered td {
            border: none; /* Remove borders */
        }
    
        .table-responsive {
            max-height: 800px; /* Set max height for responsiveness */
            overflow-y: auto;
        }
    
        .text-center {
            text-align: center;
        }
    </style>
    
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($periods as $period)
                        @php
                        $start_on = date('g:i A', strtotime($period->start_on));
                        $end_on = date('g:i A', strtotime($period->end_on));
                        @endphp
                        <th>
                            <div class="text-center">
                                <a href="javascript:void(0);"
                                    onclick="deleteitem('Are You Sure To Delete This Period ?',{{ $period->id }},'{{ route('delete.item') }}','period_delete')">
                                    <h4>{{ ucwords($period->name) }}</h4>
                                </a>
                                <p class="text-danger">{{ $start_on }} - {{ $end_on }}</p>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                    <tr>
                        <th>{{ $class->class_name }} - Class</th>
                        @foreach ($periods as $period)
                        <td class="text-center">
                            @if ($period->name == 'prayer' || $period->name == 'rest')
                            @else
                            @php
                            $period_teacher = getperiodteacher($class->id,$period->id);
                            @endphp 
                            {!!$period_teacher!!}
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div id="asign-modal" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Asign Teacher</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <a class="close" data-dismiss="modal">X</a>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('asign.teacher')}}" method="POST" class="forms-sample">
                        @csrf
                        <input type="hidden" name="class_id" id="class_id" value="">
                        <input type="hidden" name="period_id" id="period_id" value="">
                        <div class="card">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1">Select Teacher</label>
                                        <select class="js-example-basic-single w-100 select2-hidden-accessible" id="selectteacher"
                                            name="teacher">
                                            <option value="">Select Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="nameerror" class="text-danger"></div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1">Select Subjects</label>
                                        <select class="js-example-basic-single w-100 select2-hidden-accessible"
                                            id="selectsubjects" name="subjects">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <div id="contact-modal" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Subject</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <a class="close" data-dismiss="modal">X</a>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.period') }}" id="periodform" method="POST" class="forms-sample">
                        <div class="card">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1">Period Name</label>
                                        <input type="text" Name="period_name" class="form-control" id="periodname"
                                            placeholder="Name" value="">
                                        <div id="nameerror" class="text-danger"></div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1">Start On</label>
                                        <input type="time" Name="start_on" class="form-control" id="start_on"
                                            placeholder="Name" value="">
                                        <div id="durationerror" class="text-danger"></div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1">End On</label>
                                        <input type="time" Name="end_on" class="form-control" id="end_on"
                                            placeholder="Name" value="">
                                        <div id="durationerror" class="text-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="formsubmit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('change', '#selectteacher', function() {
            teacher_id = $(this).val();
            $.ajax({
                url: '{{ route('get.teacher.subject') }}',
                method: 'get',
                data: {
                    teacher_id: teacher_id,
                },
                success: function(data) {
                    $('#selectsubjects').empty();
                    $('#selectsubjects').append(data).select2();
                    $('#selectsubjects').trigger('change.select2');
                }

            });
        });
        $(document).ready(function() {
            if ($('.js-example-basic-single').length > 0) {
                $('.js-example-basic-single').select2();
            } else {
                console.error("Select element with class 'js-example-basic-single' not found.");
            }
        });


        $('.asign_teacher').on('click', function() {
            period_id = $(this).attr('periodid');
            class_id = $(this).attr('classid');
            $('#period_id').val(period_id);
            $('#class_id').val(class_id);
            $('#asign-modal').modal('show');
        });

        $(document).ready(function() {
            $('#formsubmit').click(function() {
                var periodname = $('#periodname').val();
                var start_on = $('#start_on').val();
                var end_on = $('#end_on').val();
                if (periodname.trim() === '') {
                    $('#nameerror').text('Please Enter Subject Name');
                    $('#periodname').css('border-color', 'red');
                    return;
                } else {
                    $('#nameerror').text('');
                    $('#subjectName').css('border-color', '');
                }
                if (start_on.trim() === '' || end_on.trim() === '') {
                    $('#durationerror').text('Please Enter Duration');
                    $('#start_on').css('border-color', 'red');
                    $('#end_on').css('border-color', 'red');
                    return;
                } else {
                    $('#durationerror').text('');
                    $('#start_on').css('border-color', '');
                    $('#end_on').css('border-color', '');
                }
                $('#periodform').submit();
            });
        });
    </script>
@endsection
