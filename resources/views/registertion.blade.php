@extends('layouts.main')

@section('main-container')
    <br>
    <div class="row justify-content-center">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="text-align: center;">Create Your Account</h3><br>
                    <form action="{{ route('adduser') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputName1">Teacher Name<span
                                            class="mandatory-symbol">*</span></label>
                                    <input type="text" name="Teacher_Name"
                                        class="form-control{{ $errors->has('Teacher_Name') ? ' is-invalid' : '' }}"
                                        id="exampleInputName1" placeholder="Teacher Name" value="{{ old('Teacher_Name') }}">
                                    @error('Teacher_Name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Teacher Email<span
                                            class="mandatory-symbol">*</span></label>
                                    <input type="email" name="Teacher_Email"
                                        class="form-control{{ $errors->has('Teacher_Email') ? ' is-invalid' : '' }}"
                                        id="exampleInputEmail3" placeholder="Teacher Email"
                                        value="{{ old('Teacher_Email') }}">
                                    @error('Teacher_Email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputNumber1">Contact Number<span
                                            class="mandatory-symbol">*</span></label>
                                    <input type="number" name="Teacher_Number"
                                        class="form-control{{ $errors->has('Teacher_Number') ? ' is-invalid' : '' }}"
                                        id="exampleInputNumber1" placeholder="Contact Number"
                                        value="{{ old('Teacher_Number') }}">
                                    @error('Teacher_Number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password<span
                                            class="mandatory-symbol">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword1" placeholder="Your Password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm Password<span
                                            class="mandatory-symbol">*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword1" placeholder="Your Password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputSchool">School<span class="mandatory-symbol">*</span></label>
                                <select name="school" id="exampleInputSchool" class="form-control">
                                    <option value="">Select School</option>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error('school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-outline-success">Submit</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('teacher.login.page') }}">Already have an account? Login here</a>
                    </div>
                </div>
                <div class="row">
                  @foreach ($Bannerpojition as $position)
                      <div class="col-4 col-md-4"> <!-- Use col-12 for mobile and col-md-4 for larger screens -->
                          <img src="{{ asset($position->image) }}" class="d-block w-100" alt="{{ $position->name }}">
                      </div>
                  @endforeach
              </div>
            </div>
        </div>
    </div>
    <br>
@endsection
