@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Job Type')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info,
        .btn-danger,
        .btn-success {
            width: fit-content;
            height: 30px;
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

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-lg-9 border p-2">
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">
                                Spare Part Edit
                                <span class="float-end"><a href="{{ route('job-type') }}"
                                        class="btn btn-md btn-success">Back</a></span>
                            </span>

                            <form action="{{ route('job-type-update', $data->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Name</span>
                                            </label>
                                            <input type="text" class="form-control mt-n3" name="name"
                                                value="{{ $data->name }}">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description" class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Description</span>
                                            </label>
                                            <textarea class="form-control mt-n3" name="description">{{ $data->description }}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
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
