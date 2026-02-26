@extends('layouts/contentNavbarLayout')

@section('title', ' Client Job Edit')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const machineSelect = document.querySelector('select[name="machine_id"]');
            const machineInfoContainer = document.querySelector('.clientMachineInfo');

            const machineId = machineSelect.value || "{{ old('machine_id') }}";

            if (machineId) {
                fetch(`/client-machine-info/${machineId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            machineInfoContainer.innerHTML =
                                `<div class="text-danger">Machine details not found!</div>`;
                        } else {
                            machineInfoContainer.innerHTML = `
                    <h5 class="my-3 text-white">Product Info</h5>
                    <div class="row">
                        <div class="col-6"><label>Product Name:</label> <span class="text-bold">${data.name}</span></div>
                        <div class="col-6"><label>Make/Model:</label> <span class="text-bold">${data.make_model}</span></div>
                        <div class="col-6"><label>Type:</label> <span class="text-bold">${data.type}</span></div>
                        <div class="col-6"><label>Serial No.:</label> <span class="text-bold">${data.serial}</span></div>
                        <div class="col-6"><label>Platform:</label> <span class="text-bold">${data.platform_size} / ${data.platform_max_capacity} / ${data.platform_min_capacity} / ${data.platform_least_count}</span></div>
                        <div class="col-6"><label>Loadcell:</label> <span class="text-bold">${data.loadcell_modal} / ${data.loadcell_type} / ${data.loadcell_capacity} / ${data.loadcell_serial_no}</span></div>
                        <div class="col-6"><label>System:</label> <span class="text-bold">${data.system_modal} / ${data.system_type} / ${data.system_cables} / ${data.system_least_count}</span></div>
                        <div class="col-6"><label>JB:</label> <span class="text-bold">${data.jb_modal} / ${data.jb_ports}</span></div>
                    </div>
                `;
                        }
                    })
                    .catch(error => {
                        machineInfoContainer.innerHTML =
                            `<div class="text-danger">Error fetching machine info.</div>`;
                        console.error('Error fetching machine info:', error);
                    });
            } else {
                machineInfoContainer.innerHTML = '';
            }

            machineSelect.addEventListener('change', function() {
                const selectedMachineId = machineSelect.value;

                if (selectedMachineId) {
                    fetch(`/client-machine-info/${selectedMachineId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                machineInfoContainer.innerHTML =
                                    `<div class="text-danger">Machine details not found!</div>`;
                            } else {
                                machineInfoContainer.innerHTML = `
                        <h5 class="my-3 text-white">Product Info</h5>
                        <div class="row">
                            <div class="col-6"><label>Product Name:</label> <span class="text-bold">${data.name}</span></div>
                            <div class="col-6"><label>Make/Model:</label> <span class="text-bold">${data.make_model}</span></div>
                            <div class="col-6"><label>Type:</label> <span class="text-bold">${data.type}</span></div>
                            <div class="col-6"><label>Serial No.:</label> <span class="text-bold">${data.serial}</span></div>
                            <div class="col-6"><label>Platform:</label> <span class="text-bold">${data.platform_size} / ${data.platform_max_capacity} / ${data.platform_min_capacity} / ${data.platform_least_count}</span></div>
                            <div class="col-6"><label>Loadcell:</label> <span class="text-bold">${data.loadcell_modal} / ${data.loadcell_type} / ${data.loadcell_capacity} / ${data.loadcell_serial_no}</span></div>
                            <div class="col-6"><label>System:</label> <span class="text-bold">${data.system_modal} / ${data.system_type} / ${data.system_cables} / ${data.system_least_count}</span></div>
                            <div class="col-6"><label>JB:</label> <span class="text-bold">${data.jb_modal} / ${data.jb_ports}</span></div>
                        </div>
                    `;
                            }
                        })
                        .catch(error => {
                            machineInfoContainer.innerHTML =
                                `<div class="text-danger">Error fetching machine info.</div>`;
                            console.error('Error fetching machine info:', error);
                        });
                } else {
                    machineInfoContainer.innerHTML = '';
                }
            });
        });
    </script>


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

                                <div class="clientMachineInfo"></div>

                            </div>

                        </div>

                        <form action="{{ route('client.job.update', $job->id) }}" method="post" class="row mt-3 border-1"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark  pt-1 pl-2 pr-2">Machine</span></label>
                                    <select class="form-select mt-n3" name="machine_id" value="{{ old('machine_id') }}">
                                        <option value="" selected disabled>Select Machine</option>
                                        @foreach ($machines as $machine)
                                            <option value="{{ $machine->id }}"
                                                {{ $job->machine_id == $machine->id ? 'selected' : '' }}>
                                                {{ $machine->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('machine_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('machine_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Complaint No.
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="complaint_no"
                                        value="{{ $job->complaint_no }}" readonly>
                                    @if ($errors->has('complaint_no'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('complaint_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Complaint Date
                                        </span></label>
                                    <input type="date" class="form-control mt-n3" name="complaint_date"
                                        value="{{ $job->complaint_date }}" readonly>
                                    @if ($errors->has('complaint_date'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('complaint_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Caller Name
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="caller_name"
                                        value="{{ $job->caller_name }}">
                                    @if ($errors->has('caller_name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('caller_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Caller Contact
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="caller_contact"
                                        value="{{ $job->caller_contact }}">
                                    @if ($errors->has('caller_contact'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('caller_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Caller Type
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="caller_type"
                                        value="{{ $job->caller_type }}">
                                    @if ($errors->has('caller_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('caller_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Call For
                                        </span></label>
                                    <input type="text" class="form-control mt-n3" name="call_for"
                                        value="{{ $job->call_for }}">
                                    @if ($errors->has('call_for'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('call_for') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Attachments
                                        </span></label>
                                    <input type="file" class="form-control mt-n3" name="attachments"
                                        value="{{ old('attachments') }}">
                                    @if ($job->attachments)
                                        <a href="{{ asset($job->attachments) }}" target="_blank">View Current
                                            Attachment</a>
                                    @endif
                                    @if ($errors->has('attachments'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('attachments') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Call Description
                                        </span></label>
                                    <textarea class="form-control mt-n3" name="call_description">{{ $job->call_description }}</textarea>
                                    @if ($errors->has('call_description'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('call_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-2">
                                        <span class="h6 small bg-white text-dark pl-2 pr-2">Call Tasks List
                                        </span></label>
                                    <textarea class="form-control mt-n3" name="call_tasks_list">{{ $job->call_tasks_list }}</textarea>
                                    @if ($errors->has('call_tasks_list'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('call_tasks_list') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row justify-content-end mt-2">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Update Job</button>
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
