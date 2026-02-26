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

        select {
            font-size: 1.2rem !important;
            height: 38px;
        }

        .bg-heading {
            background: #d9dee3;
            font-weight: 600;
            font-size: 16px;
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

        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Branch Add</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @php
                        //dd(session()->all());
                    @endphp
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
                    <form action="{{ route('client-child-save', request()->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Name <span
                                                class="text-danger">*</span></span></label>
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
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client Type <span
                                                class="text-danger">*</span></span></label>
                                    <select type="text" name="client_type" class="form-select mt-n3">
                                        <option value="" disabled selected></option>
                                        @foreach ($client_type as $type)
                                            <option value="{{ $type->id }}"
                                                @if ($type->id == old('client_type')) @selected(true) @endif>
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('client_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('client_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-2">
                                        <span class="h6 small bg-white text-muted pl-2 pr-2">Client Category <span
                                                class="text-danger">*</span></span>
                                    </label>
                                    <select name="category_id" id="category_id" class="form-select mt-n3">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach ($category as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                                        value="{{ old('client_reference') }}">
                                    @if ($errors->has('client_reference'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('client_reference') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-12 ">
                                <p class="text-white mt-4 bg-info p-1">Billing Address <span class="text-danger">*</span>
                                </p>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Address
                                        1 <span class="text-danger">*</span></span></label>
                                <textarea class="form-control" id="b_address1" rows="1" name="b_address1">{{ old('b_address1') }}</textarea>
                                @error('b_address1')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Address
                                        2<span class="text-danger">*</span></span></label>
                                <textarea class="form-control" id="b_address2" rows="1" name="b_address2">{{ old('b_address2') }}</textarea>
                                @error('b_address2')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Country
                                        <span class="text-danger">*</span></span></label>
                                <select name="b_country" id="b_country" class="form-select">
                                    <option value="" disabled selected>Select Country
                                    </option>
                                    <option value="1" @selected(old('b_country') == '1')>
                                        India</option>
                                </select>
                                @error('b_country')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">State
                                        <span class="text-danger">*</span></span></label>
                                <select name="b_state" id="b_state" class="form-select">
                                    <option value="" disabled selected>Select State
                                    </option>
                                    @foreach ($state as $st)
                                        <option value="{{ $st->id }}" @selected(old('b_state') == $st->id)>
                                            {{ $st->name }}</option>
                                    @endforeach
                                </select>
                                @error('b_state')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">City
                                        <span class="text-danger">*</span></span></label>
                                <select name="b_city" id="b_city" class="form-select">
                                    <option value="" disabled selected>Select City
                                    </option>
                                </select>
                                @error('b_city')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Pincode
                                        <span class="text-danger">*</span></span></label>
                                <input type="text" class="form-control" id="b_pincode" name="b_pincode"
                                    value="{{ old('b_pincode') }}">
                                @error('b_pincode')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <p class="contactPerson">
                                    Contact Person <span class="text-danger">*</span>
                                </p>
                            </div>

                            <div id="contactPersonWrapper">
                                <div class="row contact-person-row">
                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Contact
                                                Person Name <span class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="contact_person[]"
                                            value="{{ old('contact_person.0') }}">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Email
                                                <span class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="email[]"
                                            value="{{ old('email.0') }}">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Phone
                                                <span class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="phone[]"
                                            value="{{ old('phone.0') }}">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Mobile
                                                <span class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="mobile[]"
                                            value="{{ old('mobile.0') }}">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Designation
                                                <span class="text-danger">*</span></span></label>
                                        <select class="form-select" name="designation[]">
                                            <option value="" disabled selected>Select Designation</option>
                                            @foreach ($designation as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-5 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Department
                                                <span class="text-danger">*</span></span></label>
                                        <select name="department[]" class="form-select">
                                            <option value="" disabled selected>Select Department</option>
                                            <option value="1">Sales</option>
                                            <option value="2">Maintenance</option>
                                            <option value="3">Field & Recovery</option>
                                            <option value="4">Service Maintenance</option>
                                            <option value="5">Call Support</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-1 d-flex align-items-end mb-3">
                                        <button type="button" class="btn btn-danger remove-contact-person"
                                            style="display:none;">
                                            <i class="bx bx-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="button" id="addContactPerson" class="btn btn-sm btn-success mt-2">
                                    <i class="bx bx-plus"></i> Add More
                                </button>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-12 d-flex justify-between text-white mt-4 bg-info p-1 mb-2">
                                <span class="">Shipping Address <span class="text-danger">*</span></span>
                                <span class="">
                                    <input type="checkbox" id="sameAsBilling" name="makesame" value="" class="me-2">
                                    <label for="sameAsBilling" class="h6 small bg-white text-muted mb-0">
                                        Same as Billing Address
                                    </label>
                                </span>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Address 1 <span
                                            class="text-danger">*</span></span></label>
                                <textarea class="form-control" id="s_address1" rows="1" name="s_address1">{{ old('s_address1') }}</textarea>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Address 2<span
                                            class="text-danger">*</span></span></label>
                                <textarea class="form-control" id="s_address2" rows="1" name="s_address2">{{ old('s_address2') }}</textarea>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Country <span
                                            class="text-danger">*</span></span></label>
                                <select name="s_country" id="s_country" class="form-select">
                                    <option value="" disabled selected>Select Country</option>
                                    <option value="1" @selected(old('s_country') == '1')>India</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">State <span
                                            class="text-danger">*</span></span></label>
                                <select name="s_state" id="s_state" class="form-select">
                                    <option value="" disabled selected>Select State</option>
                                    @foreach ($state as $st)
                                        <option value="{{ $st->id }}" @selected(old('s_state') == $st->id)>
                                            {{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">City <span
                                            class="text-danger">*</span></span></label>
                                <select name="s_city" id="s_city" class="form-select">
                                    <option value="" disabled selected>Select City</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label><span class="h6 small bg-white text-muted">Pincode <span
                                            class="text-danger">*</span></span></label>
                                <input type="text" class="form-control" id="s_pincode" name="s_pincode"
                                    value="{{ old('s_pincode') }}">
                            </div>

                            <div class="col-lg-12">
                                <p class="contactPerson">Contact Person <span class="text-danger">*</span></p>
                            </div>

                            <div id="shippingContactPersonWrapper">
                                <div class="row contact-person-row">
                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Contact Person Name <span
                                                    class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="s_contact_person[]">
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Email <span
                                                    class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="s_email[]">
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Phone <span
                                                    class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="s_phone[]">
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Mobile <span
                                                    class="text-danger">*</span></span></label>
                                        <input type="text" class="form-control" name="s_mobile[]">
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Designation <span
                                                    class="text-danger">*</span></span></label>
                                        <select class="form-select" name="s_designation[]">
                                            <option value="" disabled selected>Select Designation</option>
                                            @foreach ($designation as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5 mb-3">
                                        <label><span class="h6 small bg-white text-muted">Department <span
                                                    class="text-danger">*</span></span></label>
                                        <select name="s_department[]" class="form-select">
                                            <option value="" disabled selected>Select Department</option>
                                            <option value="1">Sales</option>
                                            <option value="2">Maintenance</option>
                                            <option value="3">Field & Recovery</option>
                                            <option value="4">Service Maintenance</option>
                                            <option value="5">Call Support</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 d-flex align-items-end mb-3">
                                        <button type="button" class="btn btn-danger remove-contact-person"
                                            style="display:none;">
                                            <i class="bx bx-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="button" id="addShippingContactPerson" class="btn btn-sm btn-success mt-2">
                                    <i class="bx bx-plus"></i> Add More
                                </button>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-12 ">
                                <p class="text-white mt-4 bg-info p-1">Document <span class="text-danger">*</span>
                                </p>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">IEC</label>
                                <div class="input-group">
                                    <input type="text" name="iec_no" class="form-control col-sm-8"
                                        value="{{ old('iec_no') }}" />
                                    <input type="file" name="client_iec" class="form-control col-sm-3" />
                                    @if ($errors->has('msme'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('msme') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">CIN</label>
                                <div class="input-group">
                                    <input type="text" name="cin_no" class="form-control col-sm-8"
                                        value="{{ old('cin_no') }}" />
                                    <input type="file" name="client_cin" class="form-control col-sm-3" />
                                    @if ($errors->has('msme'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('msme') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">MSME</label>
                                <div class="input-group">
                                    <input type="text" name="msme_no" class="form-control col-sm-8"
                                        value="{{ old('msme_no') }}" />
                                    <input type="file" name="msme" class="form-control col-sm-3" />
                                    @if ($errors->has('msme'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('msme') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">Pancard</label>
                                <div class="input-group">
                                    <input type="text" name="pancard_no" class="form-control col-sm-8"
                                        value="{{ old('pancard_no') }}" />
                                    <input type="file" name="pancard" class="form-control" />
                                    @if ($errors->has('pancard'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('pancard') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">GST</label>
                                <div class="input-group">
                                    <input type="text" name="gst_no" class="form-control col-sm-8"
                                        value="{{ old('gst_no') }}" />
                                    <input type="file" name="gst" class="form-control" />
                                    @if ($errors->has('gst'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('gst') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="col-form-label">Certification</label>
                                <div class="input-group">
                                    <input type="file" name="certification" class="form-control" />
                                    @if ($errors->has('certification'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('certification') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>



                        </div>


                        <div class="row justify-content-end">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-info btn-md" name="draft" value="Save">
                                <button type="submit" class="btn btn-primary btn-md">Save & Submit</button>
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

            $(addBtnSelector).on('click', function() {
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
        $('#sameAsBilling').on('change', function() {
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
