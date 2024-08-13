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
            <h3 class="card-title">Add School Banner's</h3>
            <form action="{{ route('storebanner') }}" id="addstudent" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Banner Name<span class="mandatory-symbol">*</span></label>
                        <input type="text" Name="name" class="form-control {{ $errors->has('Student_Name') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Student Name" value="{{ old('Student_Name') }}">
                        @error('Student_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Banner Description<span class="mandatory-symbol">*</span></label>
                        <textarea class="form-control" id="formValidationBio" name="description" placeholder="Plese Enter Description" rows="2"></textarea>
                        @error('Student_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Select Bannerpojition<span class="mandatory-symbol">*</span></label>
                        <select name="bannerpojition" id="cars" class="form-control">
                            <option value="volvo">Select Bannerpojition</option>
                            @foreach($Bannerpojition as $pojitions)
                            <option value="{{$pojitions->name}}">{{$pojitions->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label>Banner Photo</label>
                        <input type="file" Name="image" class="form-control">
                    </div>
                </div>
                <div class="documents">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
        @endsection