@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <style>

        .form-group {
            float: left;
        }

        .form-group label {
            width: 20%;
            float: left;
            font-weight: bold;
        }

        .form-group input {
            width: 80%;
            /* border: none; */
            border-bottom: 1px solid #e7e7e7;
            border-radius: unset;
            height: 30px;
        }

        .form-group select {
            width: 80%;
            /* border: none; */
            border-bottom: 1px solid #e7e7e7;
            border-radius: unset;
            height: 30px;
            padding: 0 8px;
        }

        .megaField label {
            width: 10%;
        }

        .megaField input {
            width: 20%;
            border: 1px solid #e6e6e6;
            padding: 0px 1%;
            height: 30px;
        }

        .megaField {
            float: left;
            display: flex;
            justify-content: flex-start;
        }

        . label {
            width: 10%;
        }

        .megaField0 label {
            width: 10%;
        }

        .megaField0 input {
            width: 100%;
            border: 1px solid #e6e6e6;
            padding: 0px 1%;
            height: 30px;
        }

        .megaField0 {
            float: left;
            display: flex;
            justify-content: flex-start;
        }

        . label {
            width: 10%;
        }

        .megaField1 input {
            width: 100%;
            border: 1px solid #e6e6e6;
            padding: 0px 1%;
            height: 30px;
        }

        .megaField1 {
            float: left;
            display: flex;
            justify-content: flex-start;
        }

        #addMore0,
        #addMore1 {
            width: fit-content;
            margin: -14px 14px;
        }

        .date-input-container {
            position: relative;
            display: inline-block;
        }

        .date-input-container input {
            width: 100%;
        }

        .date-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            color: #999;
            pointer-events: none;
            transition: 0.2s;
            padding: 0 8px;
        }

        .date-input:not(:placeholder-shown)+.date-placeholder,
        .date-input:focus+.date-placeholder {
            top: 4px;
            width: 70%;
            left: 2px;
            font-size: 14px;
            color: #728294;
            background: white;
        }

        .file-input-container {
            position: relative;
            display: inline-block;
        }

        .file-input-container input {
            width: 100%;
        }

        .file-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            color: #999;
            pointer-events: none;
            transition: 0.2s;
            padding: 0 8px;
        }

        .file-input:not(:placeholder-shown)+.file-placeholder,
        .file-input:focus+.file-placeholder {
            top: 3px;
            width: 98%;
            left: 5px;
            font-size: 14px;
            color: #728294;
            background: white;
            overflow: hidden;
            height: 25px;
        }

        .deleteBtn {
            height: 30px;
        }
    </style>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">

        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <h4 class="card-header">Machine Create<span class="float-end"><a href="{{ route('client-view', $client->id) }}"
                            class="btn btn-md btn-success">Go Back</a></span></h4>
                <div class="card-header pt-0 row">
                    <div class="col-lg-6">
                        <p class="p-2 bg-info text-white text-bold"><b>Client :</b><span class="ms-2">
                                {{ $client->name }}</span></p>
                    </div>
                    <div class="col-lg-6">
                        <p class="p-2 bg-info text-white text-bold"><b>Department :</b><span class="ms-2">
                                {{ $department->name }}</span></p>
                    </div>
                </div>
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
                    <form action="{{ route('machine-save', $id) }}" enctype="multipart/form-data" method="post">
                        @csrf

                        <input type="hidden" name="client_id" value="{{ $id }}">

                        <input type="hidden" name="machine_type" value="{{ $mtid }}">
                        <input type="hidden" name="department_id" value="{{ $did }}">

                        <div class="row">

                            <div class="col-sm-6 form-group mb-5">
                                <label for="name">Product Category <span class="text-danger">*</span></label>

                                <select name="add_type" id="add_type" class="form-select">
                                    <option value="" disabled selected>Select</option>
                                    <option value="EWB" {{ old('add_type') == 'EWB' ? 'selected' : '' }}>EWB</option>
                                    <option value="Platform Scale"
                                        {{ old('add_type') == 'Platform Scale' ? 'selected' : '' }}>Platform Scale</option>
                                    <option value="Precision Scale"
                                        {{ old('add_type') == 'Precision Scale' ? 'selected' : '' }}>Precision Scale
                                    </option>
                                    <option value="Crane Scale" {{ old('add_type') == 'Crane Scale' ? 'selected' : '' }}>
                                        Crane Scale</option>
                                </select>
                                @if ($errors->has('add_type'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('add_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">

                            </div>

                            <div class="col-sm-6 form-group mb-4">
                                <label for="name">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">
                                <label for="name">Offer Details</label>
                                <div class="d-flex">
                                    <input type="text" name="offer_details[]" class="form-control"
                                        value="{{ old('offer_details.0') }}" placeholder="Offer Number" />
                                    <input type="date" name="offer_details[]" class="form-control ms-1"
                                        value="{{ old('offer_details.1') }}" />
                                    <div class="file-input-container">
                                        <input type="file" multiple name="offer_details_file[]"
                                            class="form-control ms-1 file-input" id="fileInputPDF1" />
                                        <span class="file-placeholder" id="filePlaceholderPDF1">PDF</span>
                                    </div>
                                </div>
                                @if ($errors->has('offer_details'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('offer_details') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">
                                <label for="name">Make/ Model</label>
                                <input type="text" name="make_model" class="form-control"
                                    value="{{ old('make_model') }}" />
                                @if ($errors->has('make_model'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('make_model') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">
                                <label for="name">PO Details</label>
                                <div class="d-flex">
                                    <input type="text" name="po_details[]" class="form-control"
                                        value="{{ old('po_details.0') }}" placeholder="PO Number" />
                                    <input type="date" name="po_details[]" class="form-control ms-1"
                                        value="{{ old('po_details.1') }}" />
                                    <div class="file-input-container">
                                        <input type="file" multiple name="po_details_file[]"
                                            class="form-control ms-1 file-input" id="fileInputPDF2" />
                                        <span class="file-placeholder" id="filePlaceholderPDF2">PDF</span>
                                    </div>
                                </div>
                                @if ($errors->has('po_details'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('po_details') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">
                                <label for="name">Product Type</label>
                                <input type="text" name="type" class="form-control"
                                    value="{{ old('type') }}" />
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">
                                <label for="name">Invoice</label>
                                <div class="d-flex">
                                    <input type="text" name="invoice[]" class="form-control"
                                        value="{{ old('invoice.0') }}" placeholder="Invoice Number" />
                                    <input type="date" name="invoice[]" class="form-control ms-1"
                                        value="{{ old('invoice.1') }}" />
                                    <div class="file-input-container">
                                        <input type="file" multiple name="invoice_file[]"
                                            class="form-control ms-1 file-input" id="fileInputPDF3" />
                                        <span class="file-placeholder" id="filePlaceholderPDF3">PDF</span>
                                    </div>
                                </div>
                                @if ($errors->has('invoice'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('invoice') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group mb-3">
                                <label for="name">Serial</label>
                                <input type="text" name="serial" class="form-control"
                                    value="{{ old('serial') }}" />
                                @if ($errors->has('serial'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('serial') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="row mt-4">

                            <div class="col-sm-12 form-group mb-3 megaField">
                                <label for="name" id="platform">Platform</label>
                                <input type="text" name="platform_size" class="form-control"
                                    value="{{ old('platform_size') }}" placeholder="Size" />
                                <input type="text" name="platform_max_capacity" class="form-control ms-1"
                                    value="{{ old('platform_max_capacity') }}" placeholder="Max Capacity" />
                                <input type="text" name="platform_min_capacity" class="form-control ms-1"
                                    value="{{ old('platform_min_capacity') }}" placeholder="Min Capacity" />
                                <input type="text" name="platform_least_count" class="form-control ms-1"
                                    value="{{ old('platform_least_count') }}" placeholder="Least Count" />
                                @if ($errors->has('platform_size'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('platform_size') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-12 form-group mb-3 megaField">
                                <label for="name">Loadcell</label>
                                <input type="text" name="loadcell_modal" class="form-control"
                                    value="{{ old('loadcell_modal') }}" placeholder="Make/ Model" />
                                <input type="text" name="loadcell_type" class="form-control ms-1"
                                    value="{{ old('loadcell_type') }}" placeholder="Type" />
                                <input type="text" name="loadcell_capacity" class="form-control ms-1"
                                    value="{{ old('loadcell_capacity') }}" placeholder="Capacity" />
                                <input type="text" name="loadcell_serial_no" class="form-control ms-1"
                                    value="{{ old('loadcell_serial_no') }}" placeholder="Serial Numbers" />
                                @if ($errors->has('loadcell_modal'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('loadcell_modal') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-12 form-group mb-3 megaField">
                                <label for="name">System</label>
                                <input type="text" name="system_modal" class="form-control"
                                    value="{{ old('system_modal') }}" placeholder="Make/ Model" />
                                <input type="text" name="system_type" class="form-control ms-1"
                                    value="{{ old('system_type') }}" placeholder="Type" />
                                <input type="text" name="system_cables" class="form-control ms-1"
                                    value="{{ old('system_cables') }}" placeholder="Cables" />
                                <input type="text" name="system_least_count" class="form-control ms-1"
                                    value="{{ old('system_least_count') }}" placeholder="" />
                                @if ($errors->has('system_modal'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('system_modal') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-12 form-group mb-3 megaField">
                                <label for="name">JB</label>
                                <input type="text" name="jb_modal" class="form-control"
                                    value="{{ old('jb_modal') }}" placeholder="Make / Model" />
                                <input type="text" name="jb_ports" class="form-control ms-1"
                                    value="{{ old('jb_ports') }}" placeholder="Ports" />
                                @if ($errors->has('jb_modal'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('jb_modal') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="col-sm-12 form-group megaField pt-4">
                            <label class="text-block">Include</label>
                            <div class="form-group mb-3 mt-2 d-flex">
                                <input type="text" name="inclusion[label]" class="form-control mb-2"
                                    placeholder="Label" value="{{ old('inclusion[label][0]', 'Stamping') }}" />
                                <div class="date-input-container ms-1">
                                    <input type="date" name="inclusion[start_date]" class="form-control date-input"
                                        placeholder="start date" value="{{ old('inclusion[start_date][0]') }}" />
                                    <span class="date-placeholder">Start Date</span>
                                </div>
                                <div class="date-input-container ms-1">
                                    <input type="date" name="inclusion[end_date]" class="form-control date-input"
                                        placeholder="end date" value="{{ old('inclusion[end_date][0]') }}" />
                                    <span class="date-placeholder">End Date</span>
                                </div>
                                <div class="file-input-container ms-1">
                                    <input type="file" multiple name="inclusion[pdf][]"
                                        class="form-control file-input" id="fileInputR1" placeholder="PDF" />
                                    <span class="file-placeholder" id="filePlaceholderR1">PDF</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div id="inclusionWrapper">
                                <div class="d-none inclusionTemplate">
                                    {{-- <div class="col-sm-12 form-group mb-3 mt-2 d-flex">
                                        <input type="text" name="inclusionAdditional[label][]"
                                            class="form-control mb-2" placeholder="Label" />
                                        <input type="text" name="inclusionAdditional[value][]" class="form-control"
                                            placeholder="Value" />
                                        <button type="button" class="btn btn-danger btn-sm deleteBtn"><i
                                                class="bx bx-trash"></i></button>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3" style="margin: inherit;">
                                <button type="button" id="addMore1" class="btn btn-primary btn-sm">Add More</button>
                            </div>
                        </div>

                        <div class="col-sm-12 form-group mt-2 megaField">
                            <label class="text-block">Exclude</label>
                            <div class="form-group mb-3 mt-2 d-flex">
                                <input type="text" name="exclusion[label]" class="form-control mb-2"
                                    placeholder="Label" value="{{ old('exclusion[label][0]', 'Stamping') }}" />
                                <div class="date-input-container ms-1">
                                    <input type="date" name="exclusion[start_date]" class="form-control date-input"
                                        placeholder="start date" value="{{ old('exclusion[start_date][0]') }}" />
                                    <span class="date-placeholder">Start Date</span>
                                </div>
                                <div class="date-input-container ms-1">
                                    <input type="date" name="exclusion[end_date]" class="form-control date-input"
                                        placeholder="end date" value="{{ old('exclusion[end_date][0]') }}" />
                                    <span class="date-placeholder">End Date</span>
                                </div>
                                <div class="file-input-container ms-1">
                                    <input type="file" multiple name="exclusion[pdf][]"
                                        class="form-control file-input" id="fileInputR11" placeholder="PDF" />
                                    <span class="file-placeholder" id="filePlaceholderR11">PDF</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div id="exclusionWrapper">
                                <div class="d-none exclusionTemplate">
                                    {{-- <div class="col-sm-12 form-group mb-3 mt-2 d-flex">
                                        <input type="text" name="exclusionAdditional[label][]" class="form-control"
                                            placeholder="Label" />
                                        <input type="text" name="exclusionAdditional[value][]" class="form-control"
                                            placeholder="Value" />
                                        <button type="button" class="btn btn-danger btn-sm deleteBtn"><i
                                                class="bx bx-trash"></i></button>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-12 mb-5">
                                <button type="button" id="addMore2" class="btn btn-primary btn-sm">Add More</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group mb-3 megaField">
                                <label for="name">Specifications</label>
                                <textarea name="specification" class="form-control">{{ old('specification') }}</textarea>
                                @if ($errors->has('specification'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('specification') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group mb-5 megaField">
                                <label for="name">Description</label>
                                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 megaField">
                                <label for="stamping_vc">Manual</label>
                                <input type="file" multiple name="stamping_vc[]" id="stamping_vc"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 megaField">
                                <label for="brochure">Brochure</label>
                                <input type="file" multiple name="brochure[]" id="brochure" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-5 megaField">
                                <label for="datasheet">Datasheet</label>
                                <input type="file" multiple name="datasheet[]" id="datasheet" class="form-control" />
                            </div>

                            <div class="row">
                                <div class="col-sm-12 form-group mb-3 megaField">
                                    <label for="name">Product Link</label>
                                    <input type="text" name="product_link" class="form-control w-50"
                                        value="{{ old('product_link') }}" />
                                    @if ($errors->has('product_link'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('product_link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div id="fieldWrapper">
                                <div class="d-none fieldTemplate">
                                    {{-- <div class="col-sm-12 form-group mb-3 mt-2 d-flex megaField">
                                        <label for="name">Additional</label>
                                        <input type="text" name="additional[label][]" class="form-control"
                                            placeholder="Label" />
                                        <select name="additional[type][]" id="type" class="form-control">
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="Burn Defect"
                                                {{ old('type') == 'Burn Defect' ? 'selected' : '' }}>Burn Defect</option>
                                            <option value="Mfg Defect"
                                                {{ old('type') == 'Mfg Defect' ? 'selected' : '' }}>Mfg Defect</option>

                                        </select>
                                        <input type="text" name="additional[field][]" class="form-control"
                                            placeholder="Field" />
                                        <button type="button" class="btn btn-danger btn-sm deleteBtn"><i
                                                class="bx bx-trash"></i></button>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-12 my-2">
                                <button type="button" id="addMore3" class="btn btn-primary btn-sm">Add More</button>
                            </div>
                        </div>
                        <div class="row justify-content-end mt-2">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-md btn-info">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $("#add_type").on('change', function() {
            var addval = $(this).val();
            if (addval == 'Crane Scale') {
                $("#platform").html('Hook Size');
            } else {
                $("#platform").html('Platform');
            }
        });

        $(document).ready(function() {
            // Function to add more inclusions
            $('#addMore1').click(function() {
                let templateHtml = `
            <div class="col-sm-12 form-group mb-3 mt-2 d-flex">
                <input type="text" name="inclusionAdditional[label][]" class="form-control mb-2" placeholder="Label" />
                <input type="text" name="inclusionAdditional[value][]" class="form-control ms-1" placeholder="Value" />
                <button type="button" class="btn btn-danger btn-sm deleteBtn py-0 ms-1"><i class="bx bx-trash"></i></button>
            </div>`;
                $('#inclusionWrapper').append(templateHtml);
            });

            // Function to add more exclusions
            $('#addMore2').click(function() {
                let templateHtml = `
            <div class="col-sm-12 form-group mb-3 mt-2 d-flex">
                <input type="text" name="exclusionAdditional[label][]" class="form-control" placeholder="Label" />
                <input type="text" name="exclusionAdditional[value][]" class="form-control ms-1" placeholder="Value" />
                <button type="button" class="btn btn-danger btn-sm deleteBtn py-0 ms-1"><i class="bx bx-trash"></i></button>
            </div>`;
                $('#exclusionWrapper').append(templateHtml);
            });

            // Function to add more fields
            $('#addMore3').click(function() {
                let templateHtml = `
            <div class="col-sm-12 form-group mb-3 mt-2 d-flex megaField">
                <label for="name">Additional</label>
                <input type="text" name="additional[label][]" class="form-control" placeholder="Label" />
                <select name="additional[type][]" class="form-control ms-1">
                    <option value="" disabled>Select Type</option>
                    <option value="Burn Defect">Burn Defect</option>
                    <option value="Mfg Defect">Mfg Defect</option>
                </select>
                <input type="text" name="additional[field][]" class="form-control ms-1" placeholder="Field" />
                <button type="button" class="btn btn-danger btn-sm deleteBtn py-0 ms-1"><i class="bx bx-trash"></i></button>
            </div>`;
                $('#fieldWrapper').append(templateHtml);
            });

            // Function to delete a field
            $(document).on('click', '.deleteBtn', function() {
                $(this).closest('.form-group').remove();
            });
        });

        document.querySelectorAll('.date-input').forEach(function(input) {
            input.addEventListener('change', function() {
                this.nextElementSibling.style.display = this.value ? 'none' : 'inline';
            });
        });

        function setupFileInput(inputId, placeholderId) {
            const fileInput = document.getElementById(inputId);
            const filePlaceholder = document.getElementById(placeholderId);

            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileName = this.files[0].name;
                    filePlaceholder.textContent = fileName;
                } else {
                    filePlaceholder.textContent = filePlaceholder.getAttribute('data-placeholder');
                }
            });

            filePlaceholder.setAttribute('data-placeholder', filePlaceholder.textContent);
        }

        // Setup each file input and its placeholder
        setupFileInput('fileInputPDF1', 'filePlaceholderPDF1');
        setupFileInput('fileInputPDF2', 'filePlaceholderPDF2');
        setupFileInput('fileInputPDF3', 'filePlaceholderPDF3');
        setupFileInput('fileInputR1', 'filePlaceholderR1');
        setupFileInput('fileInputR11', 'filePlaceholderR11');
    </script>
@endsection
