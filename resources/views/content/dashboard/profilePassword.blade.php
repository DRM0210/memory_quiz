@extends('layouts/contentNavbarLayout')

@section('title', 'Account settings - Account')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Change Password</h5>
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
      <!-- Account -->
      <form action="{{ route('password-update') }}" enctype="multipart/form-data" method="POST" >
        @csrf

      <hr class="my-0">
      <div class="card-body">

            <div class="mb-3 col-md-6">
              <label for="firstName" class="form-label">Old Password</label>
              <input class="form-control" type="password" id="old_password" name="old_password" value=""  />
              @if ($errors->has('old_password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('old_password') }}</strong>
                </span>
              @endif
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">New Password</label>
              <input class="form-control" type="password" id="new_password" name="new_password" value=""  />
              @if ($errors->has('new_password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('new_password') }}</strong>
                </span>
              @endif
            </div>

            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Confirm Password</label>
              <input class="form-control" type="password" id="confirm_password" name="confirm_password" value=""  />
              @if ($errors->has('confirm_password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('confirm_password') }}</strong>
                </span>
              @endif
            </div>

            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Change Password</button>
            </div>

      </div>
      <!-- /Account -->
    </div>

  </form>

  </div>
</div>
@endsection
