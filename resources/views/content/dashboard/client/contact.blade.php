@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<style>
  .btn-success{
    width: fit-content;
    height: 30px;
  }
</style>
<!-- Basic Layout & Basic with Icons -->
<div class="row">

  <!-- Basic with Icons -->
  <div class="col-xxl">
    <div class="card mb-4">
      <h4 class="card-header">Contact Details<span class="float-end"><a href="{{ route('client-view',Request()->id) }}" class="btn btn-success">Go Back</a></span></h4>
      <div class="card-body">
      @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('client-contact-update',$data[0]['id']) }}" method="post" >
          @csrf
          <div class="row mb-3">

            <div class="col-sm-6">
              <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Contact Person</label>
              <div class="col-sm-12">
                <div class="input-group input-group-merge">
                  <input type="text" name="contact_person" class="form-control" value="{{$data[0]['contact_person']}}" placeholder="Enter Name" />
                  @if ($errors->has('contact_person'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('contact_person') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Phone Number</label>
              <div class="col-sm-12">
                <div class="input-group input-group-merge">
                  <input type="text" name="phone" class="form-control" value="{{$data[0]['phone']}}" placeholder="Enter phone number" />
                  @if ($errors->has('phone'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('phone') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Mobile Number</label>
              <div class="col-sm-12">
                <div class="input-group input-group-merge">
                  <input type="text" name="mobile" class="form-control" value="{{$data[0]['mobile']}}" placeholder="Enter mobile number" />
                  @if ($errors->has('mobile'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('mobile') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Email</label>
              <div class="col-sm-12">
                <div class="input-group input-group-merge">
                  <input type="text" name="email" class="form-control" value="{{$data[0]['email']}}" placeholder="Enter email address" />
                  @if ($errors->has('email'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Designation</label>
              <div class="col-sm-12">
                <div class="input-group input-group-merge">
                  <select name="designation" class="form-control">
                    <option value="">Select Designation</option>
                    @foreach ($designation as $data1)
                    <option value="{{$data1->id}}" @if($data1->id == $data[0]['designation']) selected @endif >{{$data1->name}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('designation'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('designation') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Department</label>
              <div class="col-sm-12">
                <div class="input-group input-group-merge">
                  <select name="department" class="form-control">
                    <option value="">Select Department</option>
                    @foreach ($department as $data1)
                    <option value="{{$data1->id}}" @if($data1->id == $data[0]['department']) selected @endif >{{$data1->name}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('department'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('department') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

          </div>

          <div class="row justify-content-end">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary btn-md">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
