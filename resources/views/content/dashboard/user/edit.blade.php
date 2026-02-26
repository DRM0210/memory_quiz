@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info {
            width: fit-content;
            height: 30px;
        }

        .btn-danger {
            width: fit-content;
            height: 30px;
        }

        .btn-success {
            width: fit-content;
            height: 20px;
            margin-top: -3px;
            padding: 10px;
        }

        .col-sm-2 {
            width: 100%;
            text-align: left;
            margin: 5px 10px;
        }

        .h6 {
            padding: 0px 5px;
        }
    </style>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">

        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                {{-- <h5 class="card-header">Department Create<span class="float-end"><a href="" class="btn btn-success">Go
                            Back</a></span></h5> --}}
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">

                        <div class="col-lg-9 border p-2">
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">Company
                                Information <span class="float-end"><a href="{{ route('user') }}"
                                        class="btn btn-success">Back</a></span></span>

                            <form action="{{ route('user-update', $data[0]['id']) }}" method="post" class="row ">
                                @csrf



                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Name</span></label>
                                        <input type="text" class="form-control mt-n3" name="name"
                                            value="{{ $data[0]['name'] }}">
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
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Email</span></label>
                                        <input type="text" class="form-control mt-n3" name="email"
                                            value="{{ $data[0]['email'] }}">
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
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Phone</span></label>
                                        <input type="text" class="form-control mt-n3" name="phone"
                                            value="{{ $data[0]['phone'] }}">
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
                                            <span class="h6 small bg-white text-dark pt-1 pl-2 pr-2">Role</span></label>
                                        <select name="role" id="role" class="form-control mt-n3">
                                            @foreach ($role as $roles)
                                                <option value="{{ $roles['id'] }}"
                                                    @if ($data[0]['role_id'] == $roles['id']) selected @endif>{{ $roles->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('role') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-2">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="col-lg-3">

                            @include('layouts/sections/menu/verticalRightMenu')

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
