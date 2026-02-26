@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Client - Forms')

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

        select {
            font-size: 0.9375rem !important;
            height: 38px;
        }

        .bg-heading {
            background: #d9dee3;
            font-weight: 600;
            font-size: 16px;
        }

        .accordion-button {
            border-radius: unset !important;
        }

        .contactPerson {
            border-bottom: 1px dashed #0063a6;
            width: fit-content;
            color: #000;
            margin-bottom: 6px;
        }
    </style>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        {{-- <?php dd($client); ?> --}}
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Client</h4>
                </div>
                <div class="card-body pb-0">
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('client-update', $client->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client Code</span></label>
                                    <input type="text" class="form-control mt-n3" name="client_code"
                                        value="{{ $client->client_code ?? old('client_code') }}" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Name <span
                                                class="text-danger">*</span></span></label>
                                    <input type="text" class="form-control mt-n3" name="name"
                                        value="{{ $client->name ?? old('name') }}">
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
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client Type <span
                                                class="text-danger">*</span></span></label>
                                    <select type="text" name="client_type" class="form-select mt-n3">
                                        <option value="" disabled selected></option>
                                        @foreach ($client_type as $type)
                                            <option value="{{ $type->id }}"
                                                @if ($type->id == $client->client_type) selected @endif>{{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('client_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('client_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{-- <?php dd($client); ?> --}}

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client Category <span
                                                class="text-danger">*</span></span>
                                    </label>
                                    <select name="category_id" id="category_id" class="form-select mt-n3">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach ($category as $type)
                                            <option value="{{ $type->id }}"
                                                @if (isset($client->category_id) && $type->id == $client->category_id) selected @endif>{{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback d-block"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client Subcategory <span
                                                class="text-danger">*</span></span>
                                    </label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-select mt-n3">
                                        <option value="" selected disabled>Select Subcategory</option>
                                        @if (isset($client->subcategory_id) && $client->subcategory_id)
                                            <option value="{{ $client->subcategory_id }}" selected>
                                                {{ \App\Models\SubCategory::find($client->subcategory_id)->name ?? '' }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('subcategory_id')
                                        <span class="invalid-feedback d-block"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client
                                            Referrence <span class="text-danger">*</span></span></label>
                                    <input type="text" class="form-control mt-n3" name="client_reference"
                                        value="{{ $client->client_reference ?? old('client_reference') }}">
                                    @if ($errors->has('client_reference'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('client_reference') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>


                        <div class="row mb-3">

                            <div class="col-lg-12 ">
                                <p class="text-white mt-4 bg-info p-1">Billing Address <span class="text-danger">*</span>
                                </p>
                            </div>
                            @php
                                $arr12 = json_decode($client->billing_address) ?? '';
                                if ($arr12 != '') {
                                    $state12 = \App\Models\State::select('id')->where('name', $arr12->state)->first();
                                    $city12 = \App\Models\City::select('id')
                                        ->where('city_state', $arr12->state)
                                        ->where('city_name', $arr12->city)
                                        ->first();
                                    $cityclient = \App\Models\City::select('id', 'city_name')
                                        ->where('city_state', $arr12->state)
                                        ->get();
                                }
                            @endphp

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Country <span
                                                class="text-danger">*</span></span></label>
                                    <select name="b_country" id="b_country" class="form-select mt-n3">
                                        <option value="1" @if ($client->country == 1) selected @endif>India
                                        </option>
                                    </select>
                                    @if ($errors->has('b_country'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('b_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">State <span
                                                class="text-danger">*</span></span></label>
                                    <select name="b_state" id="b_state" class="form-select mt-n3">

                                        @foreach ($state as $st)
                                            <option value="{{ $st->id }}"
                                                @if ($arr12->state != '') @if ($st->id == $state12->id) selected @endif
                                                @endif >{{ $st->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('b_state'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('b_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">City <span
                                                class="text-danger">*</span></span></label>
                                    <select name="b_city" id="b_city" class="form-select mt-n3">
                                        @if ($arr12 != '')
                                            @foreach ($cityclient as $st)
                                                <option value="{{ $st->id }}"
                                                    @if ($arr12->city != '') @if ($st->id == $city12->id) selected @endif
                                                    @endif >
                                                    {{ $st->city_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('b_city'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('b_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Pincode <span
                                                class="text-danger">*</span></span></label>
                                    <input type="text" id="b_pincode" class="form-control mt-n3" name="b_pincode"
                                        value="{{ $arr12->pincode ?? '' }}">
                                    @if ($errors->has('b_pincode'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('b_pincode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Address
                                            1 <span class="text-danger">*</span></span></label>
                                    <textarea id="b_address1" class="form-control mt-n3" name="b_address1">{{ $arr12->address1 ?? '' }}</textarea>
                                    @if ($errors->has('b_address1'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('b_address1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Address
                                            2 <span class="text-danger">*</span></span></label>
                                    <textarea id="b_address2" class="form-control mt-n3" name="b_address2">{{ $arr12->address2 ?? '' }}</textarea>
                                    @if ($errors->has('b_address2 '))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('b_address2 ') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <p class="contactPerson">Contact Person <span class="text-danger">*</span></p>
                            </div>
                            @php
                                // dd($arr12->contacts);
                                $contact = $arr12->contacts;
                            @endphp
                            <div id="contactPersonWrapper">
                                @if (is_iterable($contact) && count($contact) > 0)
                                    @foreach ($contact as $pIndex => $p)
                                        <div class="row contact-person-row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Contact Person
                                                            Name <span class="text-danger">*</span></span></label>
                                                    <input type="text" class="form-control mt-n3"
                                                        name="contact_person[]" value="{{ $p->contact_person ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Email <span
                                                                class="text-danger">*</span></span></label>
                                                    <input type="text" class="form-control mt-n3" name="email[]"
                                                        value="{{ $p->email ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Phone <span
                                                                class="text-danger">*</span></span></label>
                                                    <input type="text" class="form-control mt-n3" name="phone[]"
                                                        value="{{ $p->phone ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Mobile <span
                                                                class="text-danger">*</span></span></label>
                                                    <input type="text" class="form-control mt-n3" name="mobile[]"
                                                        value="{{ $p->mobile ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Designation
                                                            <span class="text-danger">*</span></span></label>
                                                    <select class="form-select mt-n3" name="designation[]">
                                                        <option value="" disabled>Select</option>
                                                        @foreach ($designation as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if ($p->designation == $item->id) selected @endif>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Department <span
                                                                class="text-danger">*</span></span></label>
                                                    <select class="form-select mt-n3" name="department[]">
                                                        <option value="" disabled>Select</option>
                                                        <option value="1"
                                                            @if (($p->department ?? '') == 1) selected @endif>Sales
                                                        </option>
                                                        <option value="2"
                                                            @if (($p->department ?? '') == 2) selected @endif>Maintenance
                                                        </option>
                                                        <option value="3"
                                                            @if (($p->department ?? '') == 3) selected @endif>Field &
                                                            Recovery</option>
                                                        <option value="4"
                                                            @if (($p->department ?? '') == 4) selected @endif>Service
                                                            Maintenance</option>
                                                        <option value="5"
                                                            @if (($p->department ?? '') == 5) selected @endif>Call Support
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-1 d-flex align-items-end mb-3">
                                                <button type="button" class="btn btn-danger remove-contact-person"
                                                    style="display:{{ $pIndex > 0 ? 'inline-block' : 'none' }};">
                                                    <i class="bx bx-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row contact-person-row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2"><span
                                                        class="h6 small bg-white text-muted pl-2 pr-2">Contact Person Name
                                                        <span class="text-danger">*</span></span></label>
                                                <input type="text" class="form-control mt-n3" name="contact_person[]"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2"><span
                                                        class="h6 small bg-white text-muted pl-2 pr-2">Email <span
                                                            class="text-danger">*</span></span></label>
                                                <input type="text" class="form-control mt-n3" name="email[]"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2"><span
                                                        class="h6 small bg-white text-muted pl-2 pr-2">Phone <span
                                                            class="text-danger">*</span></span></label>
                                                <input type="text" class="form-control mt-n3" name="phone[]"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2"><span
                                                        class="h6 small bg-white text-muted pl-2 pr-2">Mobile <span
                                                            class="text-danger">*</span></span></label>
                                                <input type="text" class="form-control mt-n3" name="mobile[]"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2"><span
                                                        class="h6 small bg-white text-muted pl-2 pr-2">Designation <span
                                                            class="text-danger">*</span></span></label>
                                                <select class="form-select mt-n3" name="designation[]">
                                                    <option value="" disabled selected>Select Designation</option>
                                                    @foreach ($designation as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2"><span
                                                        class="h6 small bg-white text-muted pl-2 pr-2">Department <span
                                                            class="text-danger">*</span></span></label>
                                                <select class="form-select mt-n3" name="department[]">
                                                    <option value="" disabled selected>Select Department</option>
                                                    <option value="1">Sales</option>
                                                    <option value="2">Maintenance</option>
                                                    <option value="3">Field & Recovery</option>
                                                    <option value="4">Service Maintenance</option>
                                                    <option value="5">Call Support</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 d-flex align-items-end mb-3">
                                            <button type="button" class="btn btn-danger remove-contact-person"
                                                style="display:none;">
                                                <i class="bx bx-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-12">
                                <button type="button" id="addContactPerson" class="btn btn-sm btn-success mt-2">
                                    <i class="bx bx-plus"></i> Add More
                                </button>
                            </div>

                            @php
                                $arr15 = json_decode($client->service_address ?? '{}');
                                $arr11 = json_decode($client->billing_address ?? '{}');

                                $jsonState = isset($arr15->state) ? trim(strtolower($arr15->state)) : null;
                                $jsonCity = isset($arr15->city) ? trim(strtolower($arr15->city)) : null;

                                $state12 = $jsonState
                                    ? \App\Models\State::where('name', '=', $jsonState)->first()
                                    : null;

                                $city12 = $jsonCity
                                    ? \App\Models\City::where('city_name', '=', $jsonCity)->first()
                                    : null;
                            // dd($client->billing_address.'</br>'.$client->service_address);
                            @endphp

                            <div class="col-lg-12 d-flex justify-between text-white mt-4 bg-info p-1 mb-2">
                                <span>Shipping Address <span class="text-danger">*</span></span>
                                <span>
                                    <input type="checkbox" name="makesame" id="makesame" value="1"
                                        @if ($client->service_address == $client->billing_address) checked @endif>
                                    <label for="makesame" class="h6 small bg-white text-muted mb-0">Same as Billing
                                        Address</label>
                                </span>
                            </div>

                            <div class="row @if ($client->service_address == $client->billing_address) hide @endif" id="shippingSame">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span class="h6 small bg-white text-muted pl-2 pr-2">Country
                                                *</span></label>
                                        <select name="s_country" id="s_country" class="form-select mt-n3">
                                            <option value="1" selected>India</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span class="h6 small bg-white text-muted pl-2 pr-2">State *</span></label>
                                        <select name="s_state" id="s_state" class="form-select mt-n3">
                                            @foreach ($state as $st)
                                                <option value="{{ $st->id }}"
                                                    @if (isset($state12->id) && $state12->id == $st->id) selected @endif>
                                                    {{ $st->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span class="h6 small bg-white text-muted pl-2 pr-2">City *</span></label>
                                        <select name="s_city" id="s_city" class="form-select mt-n3">
                                            @foreach ($city as $ct)
                                                <option value="{{ $ct->id }}"
                                                    @if (isset($city12->id) && $city12->id == $ct->id) selected @endif>
                                                    {{ $ct->city_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span class="h6 small bg-white text-muted pl-2 pr-2">Pincode
                                                *</span></label>
                                        <input type="text" name="s_pincode" class="form-control mt-n3"
                                            value="{{ $arr15->pincode ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span class="h6 small bg-white text-muted pl-2 pr-2">Address 1
                                                *</span></label>
                                        <textarea name="s_address1" class="form-control mt-n3">{{ $arr15->address1 ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span class="h6 small bg-white text-muted pl-2 pr-2">Address 2
                                                *</span></label>
                                        <textarea name="s_address2" class="form-control mt-n3">{{ $arr15->address2 ?? '' }}</textarea>
                                    </div>
                                </div>



                                <div class="col-lg-12">
                                    <p class="contactPerson">Contact Person <span class="text-danger">*</span></p>
                                </div>
                                @php
                                    // dd($arr15->contacts);
                                    $contactS = $arr15->contacts;
                                @endphp
                                <div id="shippingContactPersonWrapper">
                                    @if (is_iterable($contactS) && count($contactS) > 0)
                                    @foreach ($contactS as $pIndex => $p)
                                            {{-- @php $srv = json_decode($p->service_address); @endphp --}}
                                            <div class="row contact-person-row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-2"><span
                                                                class="h6 small bg-white text-muted pl-2 pr-2">Contact
                                                                Person</span></label>
                                                        <input type="text" class="form-control mt-n3"
                                                            name="s_contact_person[]"
                                                            value="{{ $p->contact_person ?? ($arr11->contact_person ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-2"><span
                                                                class="h6 small bg-white text-muted pl-2 pr-2">Email</span></label>
                                                        <input type="text" class="form-control mt-n3" name="s_email[]"
                                                            value="{{ $p->email ?? ($arr11->email ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-2"><span
                                                                class="h6 small bg-white text-muted pl-2 pr-2">Phone</span></label>
                                                        <input type="text" class="form-control mt-n3" name="s_phone[]"
                                                            value="{{ $p->phone ?? ($arr11->phone ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-2"><span
                                                                class="h6 small bg-white text-muted pl-2 pr-2">Mobile</span></label>
                                                        <input type="text" class="form-control mt-n3"
                                                            name="s_mobile[]"
                                                            value="{{ $p->mobile ?? ($arr11->mobile ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-2"><span
                                                                class="h6 small bg-white text-muted pl-2 pr-2">Designation</span></label>
                                                        <select class="form-select mt-n3" name="s_designation[]">
                                                            <option value="" disabled>Select</option>
                                                            @foreach ($designation as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @if (optional($p)->designation == $item->id) selected @endif>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-2"><span
                                                                class="h6 small bg-white text-muted pl-2 pr-2">Department</span></label>
                                                        <select name="s_department[]" class="form-select mt-n3">
                                                            <option value="" disabled>Select</option>
                                                            <option value="1"
                                                                @if (optional($p)->department == 1) selected @endif>Sales
                                                            </option>
                                                            <option value="2"
                                                                @if (optional($p)->department == 2) selected @endif>
                                                                Maintenance</option>
                                                            <option value="3"
                                                                @if (optional($p)->department == 3) selected @endif>Field &
                                                                Recovery</option>
                                                            <option value="4"
                                                                @if (optional($p)->department == 4) selected @endif>Service
                                                                Maintenance</option>
                                                            <option value="5"
                                                                @if (optional($p)->department == 5) selected @endif>Call
                                                                Support</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-1 d-flex align-items-end mb-3">
                                                    <button type="button" class="btn btn-danger remove-contact-person"
                                                        style="display:{{ $pIndex > 0 ? 'inline-block' : 'none' }};">
                                                        <i class="bx bx-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif(isset($arr15) && $arr15 != '')
                                        <div class="row contact-person-row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Contact
                                                            Person</span></label>
                                                    <input type="text" class="form-control mt-n3"
                                                        name="s_contact_person[]"
                                                        value="{{ $arr15->contact_person ?? old('contact_person') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Email</span></label>
                                                    <input type="text" class="form-control mt-n3" name="s_email[]"
                                                        value="{{ $arr15->email ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Phone</span></label>
                                                    <input type="text" class="form-control mt-n3" name="s_phone[]"
                                                        value="{{ $arr15->phone ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Mobile</span></label>
                                                    <input type="text" class="form-control mt-n3" name="s_mobile[]"
                                                        value="{{ $arr15->mobile ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Designation</span></label>
                                                    <select class="form-select mt-n3" name="s_designation[]">
                                                        <option value="" disabled selected></option>
                                                        @foreach ($designation as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Department</span></label>
                                                    <select name="s_department[]" class="form-select mt-n3">
                                                        <option value="" disabled selected></option>
                                                        <option value="1">Sales</option>
                                                        <option value="2">Maintenance</option>
                                                        <option value="3">Field & Recovery</option>
                                                        <option value="4">Service Maintenance</option>
                                                        <option value="5">Call Support</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1 d-flex align-items-end mb-3">
                                                <button type="button" class="btn btn-danger remove-contact-person"
                                                    style="display:none;">
                                                    <i class="bx bx-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row contact-person-row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Contact
                                                            Person</span></label>
                                                    <input type="text" class="form-control mt-n3"
                                                        name="s_contact_person[]" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Email</span></label>
                                                    <input type="text" class="form-control mt-n3" name="s_email[]"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Phone</span></label>
                                                    <input type="text" class="form-control mt-n3" name="s_phone[]"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Mobile</span></label>
                                                    <input type="text" class="form-control mt-n3" name="s_mobile[]"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Designation</span></label>
                                                    <select class="form-select mt-n3" name="s_designation[]">
                                                        <option value="" disabled selected></option>
                                                        @foreach ($designation as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2"><span
                                                            class="h6 small bg-white text-muted pl-2 pr-2">Department</span></label>
                                                    <select name="s_department[]" class="form-select mt-n3">
                                                        <option value="" disabled selected></option>
                                                        <option value="1">Sales</option>
                                                        <option value="2">Maintenance</option>
                                                        <option value="3">Field & Recovery</option>
                                                        <option value="4">Service Maintenance</option>
                                                        <option value="5">Call Support</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1 d-flex align-items-end mb-3">
                                                <button type="button" class="btn btn-danger remove-contact-person"
                                                    style="display:none;">
                                                    <i class="bx bx-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-12">
                                    <button type="button" id="addShippingContactPerson"
                                        class="btn btn-sm btn-success mt-2">
                                        <i class="bx bx-plus"></i> Add More
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div id="contact_persons" class="col-md-12 row">
                            @foreach ($clientAddress as $key => $location)
                                @php
                                    $locationAddress = json_decode($location->address);
                                    $locationState = \App\Models\State::where('name', $locationAddress->state)->first();
                                    $locationCity = \App\Models\City::where(
                                        'city_name',
                                        $locationAddress->city,
                                    )->first();
                                @endphp
                                <div class="col-md-12 row">

                                    <div class="mb-3 @if ($key == 0) d-none @endif"><i
                                            onclick="deleteDiv2(this)" data-id="{{ $location->id }}"
                                            data-cid="{{ $location->client_id }}"
                                            style="float: right;margin-right: 10px; background: red; padding: 7px; color: white; border-radius: 6px;width: 29px; height: 29px; cursor: pointer;"
                                            class="bx bx-trash" aria-hidden="true"></i></div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-muted pl-2 pr-2">Address
                                                    Title</span></label>
                                            <input type="text" class="form-control mt-n3" id="address_title"
                                                name="address_title[]" required value="{{ $location->name }}">
                                            @error('address_title')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-muted pl-2 pr-2">Address
                                                    1</span></label>
                                            <textarea class="form-control mt-n3" id="address1" name="address1[]" required>{{ $locationAddress->address1 }}</textarea>
                                            @if ($errors->has('address1 '))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('address1 ') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-muted pl-2 pr-2">Address
                                                    2</span></label>
                                            <textarea class="form-control mt-n3" id="address2" name="address2[]" required>{{ $locationAddress->address2 }}</textarea>
                                            @if ($errors->has('address2 '))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('address2 ') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-muted pl-2 pr-2">State</span></label>
                                            <select name="state[]" id="state" class="form-select mt-n3" required>
                                                <option value="" disabled selected></option>
                                                @foreach ($state as $st)
                                                    <option value="{{ $st->id }}"
                                                        @if ($st->id == $locationState->id) selected @endif>
                                                        {{ $st->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-muted pl-2 pr-2">City</span></label>
                                            <select name="city[]" id="city" class="form-select mt-n3" required>
                                                <option value="" disabled selected></option>
                                                <option value="{{ $locationCity->id }}" selected>
                                                    {{ $locationCity->city_name }}</option>
                                            </select>
                                            @error('city')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-muted pl-2 pr-2">Pincode
                                                </span></label>
                                            <input type="text" class="form-control mt-n3" id="pincode"
                                                name="pincode[]" value="{{ $locationAddress->pincode }}" required>
                                            @error('pincode')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                            @endforeach

                        </div>



                </div>

                <div class="row card-body pt-0">

                    <div class="col-lg-12 ">
                        <p class="text-white mt-4 bg-info p-1">Document <span class="text-danger">*</span>
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">IEC</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" name="iec_no" class="form-control col-sm-8"
                                    value="{{ $client->iec_no }}" placeholder="" />
                                <input type="file" name="client_iec" class="form-control" value=""
                                    placeholder="Enter Sector" />
                                @if (!empty($client->client_iec))
                                    <img src="{{ URL::to('/') }}/{{ $client->client_iec }}"
                                        style="width:100%;height:150px;" class="mt-2">
                                @endif
                                @if ($errors->has('client_iec'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('client_iec') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">CIN</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" name="cin_no" class="form-control col-sm-8"
                                    value="{{ $client->cin_no }}" placeholder="" />
                                <input type="file" name="client_cin" class="form-control" value=""
                                    placeholder="Enter Sector" />
                                @if (!empty($client->client_cin))
                                    <img src="{{ URL::to('/') }}/{{ $client->client_cin }}"
                                        style="width:100%;height:150px;" class="mt-2">
                                @endif
                                @if ($errors->has('client_cin'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('client_cin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">MSME</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" name="msme_no" class="form-control col-sm-8"
                                    value="{{ $client->msme_no }}" placeholder="" />
                                <input type="file" name="msme" class="form-control" value=""
                                    placeholder="Enter Sector" />
                                @if (!empty($client->msme))
                                    <img src="{{ URL::to('/') }}/{{ $client->msme }}" style="width:100%;height:150px;"
                                        class="mt-2">
                                @endif
                                @if ($errors->has('msme'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('msme') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Pancard</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" name="pancard_no" class="form-control col-sm-8"
                                    value="{{ $client->pancard_no }}" placeholder="" />
                                <input type="file" name="pancard" class="form-control" value=""
                                    placeholder="Enter Size" />
                                @if (!empty($client->pancard))
                                    <img src="{{ URL::to('/') }}/{{ $client->pancard }}"
                                        style="width:100%;height:150px;" class="mt-2">
                                @endif
                                @if ($errors->has('pancard'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('pancard') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">GST</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" name="gst_no" class="form-control col-sm-8"
                                    value="{{ $client->gst_no }}" placeholder="" />
                                <input type="file" name="gst" class="form-control" value=""
                                    placeholder="Enter Referrence" />
                                @if (!empty($client->gst))
                                    <img src="{{ URL::to('/') }}/{{ $client->gst }}" style="width:100%;height:150px;"
                                        class="mt-2">
                                @endif
                                @if ($errors->has('gst'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('gst') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label" for="basic-icon-default-fullname">Certification</label>
                        <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                                <input type="file" name="certification" class="form-control" value=""
                                    placeholder="Enter certification" />
                                @if (!empty($client->certification))
                                    <img src="{{ URL::to('/') }}/{{ $client->certification }}"
                                        style="width:100%;height:150px;" class="mt-2">
                                @endif
                                @if ($errors->has('certification'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('certification') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>



                </div>


                <div class="row justify-content-end mx-2 mb-2">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-info" name="draft" value="Save" style="height: 37px;">
                        <button type="submit" class="btn btn-primary">Save & Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        function handleAddRemove(wrapperSelector, addBtnSelector) {
            const wrapper = $(wrapperSelector);

            // If wrapper doesn't exist on this page (edit uses singular contact fields), skip binding
            if (!wrapper.length) return;

            const addBtn = $(addBtnSelector);
            if (!addBtn.length) return;

            addBtn.on('click', function() {
                const row = wrapper.find('.contact-person-row:first').clone();
                row.find('input, select').val('');
                row.find('.remove-contact-person').show();
                wrapper.append(row);
            });

            wrapper.on('click', '.remove-contact-person', function() {
                if (wrapper.find('.contact-person-row').length > 1) {
                    $(this).closest('.contact-person-row').remove();
                }
            });
        }

        // Billing Contact Persons
        handleAddRemove('#contactPersonWrapper', '#addContactPerson');

        // Shipping Contact Persons
        handleAddRemove('#shippingContactPersonWrapper', '#addShippingContactPerson');

        // Copy Billing Address → Shipping Address
        $('#makesame').on('change', function() {
            if (this.checked) {
                $('input[name="makesame"]').val(1);
                $('#s_address1').val($('#b_address1').val());
                $('#s_address2').val($('#b_address2').val());
                $('#s_country').val($('#b_country').val());
                $('#s_state').val($('#b_state').val());
                $('#s_city').val($('#b_city').val());
                $('#s_pincode').val($('#b_pincode').val());
            } else {
                $('input[name="makesame"]').val(0);
                $('#s_address1, #s_address2, #s_pincode').val('');
                $('#s_country, #s_state, #s_city').val('');
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#category_id').on('change', function() {
            var categoryId = $(this).val();
            $('#subcategory_id').html('<option value="">Loading...</option>');

            if (categoryId) {
                $.ajax({
                    url: "{{ route('get-subcategories') }}", // route defined in web.php
                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('#subcategory_id').empty().append(
                            '<option value="" disabled selected>Select Subcategory</option>'
                        );
                        if (response.subcategories && response.subcategories.length > 0) {
                            $.each(response.subcategories, function(key, subcat) {
                                $('#subcategory_id').append('<option value="' +
                                    subcat.id + '">' + subcat.name + '</option>'
                                );
                            });
                        } else {
                            $('#subcategory_id').append(
                                '<option value="">No subcategories found</option>');
                        }
                    }
                });
            } else {
                $('#subcategory_id').html('<option value="">Select Category First</option>');
            }
        });
    });
</script>
