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
            <h3 class="card-title">Edit School Student</h3>
            <form action="{{ route('banners.update', $getbanner->id) }}" id="editstudent" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Banner Name<span class="mandatory-symbol">*</span></label>
                        <input type="text" name="name" class="form-control {{ $errors->has('Student_Name') ? 'is-invalid' : '' }}" id="exampleInputName1" placeholder="Student Name" value="{{$getbanner->name}}">
                        @error('Student_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Banner Description<span class="mandatory-symbol">*</span></label>
                        <textarea class="form-control" id="formValidationBio" name="description" placeholder="Please Enter Description" rows="2">{{$getbanner->description}}</textarea>
                        @error('Student_Name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Select Banner Position<span class="mandatory-symbol">*</span></label>
                        <select name="bannerpojition" id="bannerposition" class="form-control">
                            <option value="">Select Banner Position</option>
                            @foreach($Bannerposition as $position)
                            <option value="{{$position->name}}" {{ $position->name == $getbanner->bannerpojition ? 'selected' : '' }}>{{$position->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label>Banner Photo</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <img src="{{asset($getbanner->image)}}" alt="" width="20%">
                </div>
                <div class="documents"></div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection