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

        .machineInfo div ul {
            list-style: none;
            float: left;
            width: 50%;
        }

        .machineInfo div h5 {
            border-bottom: 1px solid #fff;
            width: fit-content;
        }

        .text-bold {
            font-weight: bolder;
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

                        <div class="col-lg-12 border p-3">
                            <span class="w-100 d-block p-2 fw-bold text-dark" style="background: #e5e5e5;">Job
                                Create <span class="float-end"><a href="{{ route('client-view', $client->id) }}"
                                        class="btn btn-success">Back</a></span></span>

                            <div class="col-sm-12 bg-info row m-0 py-3 text-white machineInfo">


                                <h5 class="mt-2 text-white">Company Info</h5>
                                @php
                                    $billing_address =
                                        json_decode(
                                            \App\Models\ClientContact::where('client_id', $client->id)->value(
                                                'billing_address',
                                            ),
                                            true,
                                        ) ?? [];

                                @endphp
                                <div class="col-12"><label for="">Name : &nbsp;</label><span
                                        class="text-bold">{{ $client->name }}</span></div>
                                <div class="col-12"><label for="">Address : &nbsp;</label><span
                                        class="text-bold">{{ $billing_address['address1'] ?? '' }},
                                        {{ $billing_address['address2'] ?? '' }}, {{ $billing_address['city'] ?? '' }},
                                        {{ $billing_address['state'] ?? '' }},
                                        {{ $billing_address['pincode'] ?? '' }}</span></div>
                                <div class="col-12"><label for="">Department : &nbsp;</label><span
                                        class="text-bold">{{ \App\Models\PlantDepartment::where('client_id', $client->id)->value('name') }}</span>
                                </div>



                                <h5 class="my-3 text-white">Products Info</h5>

                                <div class="col-6"><label for="">Product Name : &nbsp;</label><span
                                        class="text-bold">{{ $machine->name }}</span>
                                </div>
                                <div class="col-6"><label for="">Make/ Model : &nbsp;</label><span
                                        class="text-bold">{{ $machine->make_model }}</span>
                                </div>
                                <div class="col-6"><label for="">Product Type : &nbsp;</label><span
                                        class="text-bold">{{ $machine->type }}</span>
                                </div>
                                <div class="col-6"><label for="">Serial No. : &nbsp;</label><span
                                        class="text-bold">{{ $machine->serial }}</span>
                                </div>

                                <div class="col-6"><label for="">Platform : &nbsp;</label><span><span
                                            class="text-bold">{{ $machine->platform_size }} /
                                            {{ $machine->platform_max_capacity }} / {{ $machine->platform_min_capacity }}
                                            / {{ $machine->platform_least_count }}</span></span>
                                </div>
                                <div class="col-6"><label for="">Loadcell : &nbsp;</label><span
                                        class="text-bold">{{ $machine->loadcell_modal }} / {{ $machine->loadcell_type }} /
                                        {{ $machine->loadcell_capacity }} / {{ $machine->loadcell_serial_no }}</span>
                                </div>
                                <div class="col-6"><label for="">System : &nbsp;</label><span
                                        class="text-bold">{{ $machine->system_modal }} / {{ $machine->system_type }} /
                                        {{ $machine->system_cables }} / {{ $machine->system_least_count }}</span>
                                </div>
                                <div class="col-6"><label for="">JBt : &nbsp;</label><span
                                        class="text-bold">{{ $machine->jb_modal }} / {{ $machine->jb_ports }}</span>
                                </div>
                            </div>

                        </div>

                        <form action="{{ route('role-save') }}" method="post" class="row mt-3 border-1">
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Job
                                            Type</span></label>
                                    <select class="form-select mt-n3" name="job_type" value="{{ old('job_type') }}">
                                        <option value="" selected disabled>Select type</option>
                                        @foreach ($machinetype as $type)
                                            <option value="{{ $type->id }}"
                                                @if ($machine->machine_type == $type->id) selected @endif>{{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('job_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('job_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Name
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="name"
                                        value="{{ old('name') }}">
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
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Laad Cell Make
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="loadcell_make"
                                        value="{{ old('loadcell_make') }}">
                                    @if ($errors->has('loadcell_make'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('loadcell_make') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Load Cell Model
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="loadcell_model"
                                        value="{{ old('loadcell_model') }}">
                                    @if ($errors->has('loadcell_model'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('loadcell_model') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Electronic
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="electronic"
                                        value="{{ old('electronic') }}">
                                    @if ($errors->has('electronic'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('electronic') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Electronic Model
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="electronic_model"
                                        value="{{ old('electronic_model') }}">
                                    @if ($errors->has('electronic_model'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('electronic_model') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Type
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="type"
                                        value="{{ old('type') }}">
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Product Link
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="product_link"
                                        value="{{ old('product_link') }}">
                                    @if ($errors->has('product_link'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('product_link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Other Inclusion
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="other_inclusion"
                                        value="{{ old('other_inclusion') }}">
                                    @if ($errors->has('other_inclusion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('other_inclusion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Exclusion
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="exclusion"
                                        value="{{ old('exclusion') }}">
                                    @if ($errors->has('exclusion'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('exclusion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Specification
                                        </span></label>
                                    <textarea class="form-control mt-n3" name="specification">{{ old('specification') }}</textarea>
                                    @if ($errors->has('specification'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('specification') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Description
                                        </span></label>
                                    <textarea class="form-control mt-n3" name="description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Specification
                                        </span></label>
                                    <textarea class="form-control mt-n3" name="specification">{{ old('specification') }}</textarea>
                                    @if ($errors->has('specification'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('specification') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Specification
                                        </span></label>
                                    <textarea class="form-control mt-n3" name="specification">{{ old('specification') }}</textarea>
                                    @if ($errors->has('specification'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('specification') }}</strong>
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

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
