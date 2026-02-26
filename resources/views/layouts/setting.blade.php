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
            height: 30px;
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
                                Information</span>

                            <form action="{{ route('admin.setting.update') }}" enctype="multipart/form-data" method="post" class="row ">
                                @csrf
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Company
                                                Name</span></label>
                                        <input type="text" class="form-control mt-n3" name="company_name"
                                            value="{{ $company->name }}">
                                        @if ($errors->has('company_name'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('company_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    $arr11 = $company->address ? json_decode($company->address) : null;
                                @endphp
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span class="h6 small bg-white text-dark pt-1 pl-2 pr-2">Address</span></label>
                                        <textarea class="form-control mt-n3" name="company_address">{{ $arr11->address ?? '' }}</textarea>
                                        @if ($errors->has('company_address'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('company_address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span class="h6 small bg-white text-dark pt-1 pl-2 pr-2">Pincode</span></label>
                                        <input type="text" class="form-control mt-n3" id="pincode" name="pincode"
                                            value="{{ $arr11->pincode ?? '' }}">
                                        @if ($errors->has('pincode'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('pincode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Phone
                                                Number</span></label>
                                        <input type="text" class="form-control mt-n3" name="company_phone"
                                            value="{{ $company->phone }}">
                                        @if ($errors->has('company_phone'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('company_phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Company
                                                Email</span></label>
                                        <input type="text" class="form-control mt-n3" name="company_email"
                                            value="{{ $company->email }}">
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
                                            <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Company
                                                Website</span></label>
                                        <input type="text" class="form-control mt-n3" name="company_website"
                                            value="{{ $company->website }}">
                                        @if ($errors->has('website'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('website') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12">Company Logo</label>
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            @if ($company->logo != null)
                                                <img src="{{ URL::to('/') }}/{{ $company->logo }}" alt="user-avatar"
                                                    class="d-block rounded" height="100" width="100"
                                                    id="uploadedAvatar" />
                                            @else
                                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                                    class="d-block rounded" height="100" width="100"
                                                    id="uploadedAvatar" />
                                            @endif
                                            <div class="button-wrapper">
                                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">

                                                    <input type="file" id="upload12" name="logo"
                                                        class="account-file-input"
                                                        accept="image/png, image/jpeg" />
                                                </label>

                                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="col-sm-12">Company Icon</label>
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            @if ($company->icon != null)
                                                <img src="{{ URL::to('/') }}/{{ $company->icon }}" alt="user-avatar"
                                                    class="d-block rounded" height="100" width="100"
                                                    id="uploadedAvatar" />
                                            @else
                                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                                    class="d-block rounded" height="100" width="100"
                                                    id="uploadedAvatar" />
                                            @endif
                                            <div class="button-wrapper">
                                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">

                                                    <input type="file" id="upload32" name="icon"
                                                        class="account-file-input"
                                                        accept="image/png, image/jpeg" />
                                                </label>

                                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                            </div>
                                        </div>
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
