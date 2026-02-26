@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<style>
  .col-sm-2 {
    width: 100%;
    text-align: left;
    margin: 5px 10px;
  }
  .h6 {
    padding: 0px 5px;
  }
  .file{
  margin: 0px 85px;
}
  .btn-info{
    width: fit-content;
    height: 30px;
  }
  .btn-danger{
    width: fit-content;
    height: 30px;
  }
  .btn-success{
    width: fit-content;
    height: 30px;
  }
  select{
    font-size: 12px !important;
  height: 38px;
  }
</style>
<!-- Basic Layout & Basic with Icons -->
<div class="row">

  <!-- Basic with Icons -->
  <div class="col-xxl">
    <div class="card mb-4">
      <h4 class="card-header">Plant Create<span class="float-end"><a href="{{ route('plant',Request()->id) }}" class="btn btn-md btn-success">Go Back</a></span></h4>
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
        <form action="{{ route('plant-save', request()->id) }}" method="post" >
          @csrf
          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Name</span></label>
                <input type="text" class="form-control mt-n3" name="name" value="">
                @if ($errors->has('name'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Contact Person Name</span></label>
                <input type="text" class="form-control mt-n3" name="contact_person" value="">
                @if ($errors->has('contact_person'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('contact_person') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Email</span></label>
                <input type="text" class="form-control mt-n3" name="email" value="">
                @if ($errors->has('email'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Phone</span></label>
                <input type="text" class="form-control mt-n3" name="phone" value="">
                @if ($errors->has('phone'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('phone') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Mobile</span></label>
                <input type="text" class="form-control mt-n3" name="mobile" value="">
                @if ($errors->has('mobile'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('mobile') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Designation</span></label>
                <select class="form-control mt-n3" name="designation">
                  <option value="" disabled selected >Select Designation</option>
                  @foreach ($data as $d)
                  <option value="{{$d->id}}">{{$d->name}}</option>
                  @endforeach
                </select>
                @if ($errors->has('designation'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('designation') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Department</span></label>
                <input type="text" class="form-control mt-n3" name="department" value="">
                @if ($errors->has('department'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('department') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Address</span></label>
                <textarea class="form-control mt-n3" name="address"></textarea>
                @if ($errors->has('address'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('address') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Decription</span></label>
                <textarea class="form-control mt-n3" name="description"></textarea>
                @if ($errors->has('description'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('description') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

          </div>

          <div class="row justify-content-end">
            <div class="col-sm-12 mt-2">
              <button type="submit" class="btn btn-md btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
