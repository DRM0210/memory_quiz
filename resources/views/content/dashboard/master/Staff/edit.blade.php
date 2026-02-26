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
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">Staff
                                Edit <span class="float-end"><a href="{{ route('staff') }}"
                                        class="btn btn-md btn-success">Back</a></span></span>

                            <form action="{{ route('staff-update', $data->id) }}" method="post">
                                @csrf


                                <div class="row">



                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Name <span class="text-danger">*</span>
                                                </span></label>
                                            <input type="text" class="form-control mt-n3" name="name"
                                                value="{{ $data->name }}">
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
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Email <span class="text-danger">*</span>
                                                </span></label>
                                            <input type="text" class="form-control mt-n3" name="email"
                                                value="{{ $data->email }}">
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
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Phone <span class="text-danger">*</span>
                                                </span></label>
                                            <input type="text" class="form-control mt-n3" name="phone"
                                                value="{{ $data->phone }}">
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
                                                <span
                                                    class="h6 small bg-white text-dark pl-2 pr-2">Position</span></label>
                                            <select class="form-control mt-n3" name="position">
                                                <option value="">Select Position</option>
                                                @foreach ($designation as $d)
                                                    <option value="{{ $d->id }}"
                                                        @if ($d->id == $data->position) selected @endif>
                                                        {{ $d->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('state'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-end mt-2">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-md btn-primary">Save</button>
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
