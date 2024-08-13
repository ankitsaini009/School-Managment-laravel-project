@php
$currentsession = currentsession();
;@endphp
@extends('admin.layouts.main')
@section('main-container')
<div class="card">
  <div class="card-body">
    <h3 class="card-title">Weekly Attendances Report</h3><br>
    <form action="{{route('attendances.report')}}" method="get" class="forms-sample">
      <div class="row">
        <div class="col-md-4 col-sm-12">
          <label>Select School<span class="mandatory-symbol">*</span></label>
          <div>
            <select name="school" id="school" class="form-control" require>
              <option value="">Select School</option>
              @foreach ($schools as $allschoolSchool)
              <option value="{{$allschoolSchool->id}}" {{(isset($_GET['school']) && $_GET['school']==$allschoolSchool->id)?'selected':''}}>{{$allschoolSchool->name}}</option>
              @endforeach
            </select>
          </div>
          @error('school')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group col-md-4 col-sm-12">
          <label>Select Class<span class="mandatory-symbol">*</span></label>
          <div>
            <select name="class" id="class" class="form-control">
              <option value="">Select Class</option>
              @foreach ($SchoolClass as $allschoolClass)
              <option value="{{ $allschoolClass->id }}" {{(isset($_GET['class']) && $_GET['class']==$allschoolClass->id)?'selected':''}}>{{ $allschoolClass->class_name}}
              </option>
              @endforeach
            </select>
          </div>
          @error('class')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- <div class="form-group col-md-2 col-sm-12">
          <label>Select Student<span class="mandatory-symbol">*</span></label>
          <div>
            <select name="student" id="student" class="form-control">
              <option value="">Select Student</option>
              @foreach ($Student as $Students)
              <option value="{{ $Students->id}}">{{ $Students->name}}
              </option>
              @endforeach
            </select>
          </div>
          @error('student')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div> -->
        <div class="col-md-2 col-sm-12">
          <button type="submit" style="margin-top: 24px;" class="btn btn-primary mr-2">Search</button>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 mt-12 mt-md-0 col-md-12 col-lg-12 text-center">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>School Name</th>
                <th>Total Student</th>
                <th>Attendance</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($schoolData))
              @foreach($schoolData as $data)
              <tr>
                <td>{{$data['school_name']}}</td>
                <td>{{$data['students']}}</td>
                <td>{{$data['avg_attendance']}} %</td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="3">
                  <h3>No Record Found</h3>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
  @endsection