@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
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

        .btn-danger {
            width: fit-content;
            height: 20px;
            margin-top: -3px;
            padding: 10px;
        }

        .btn-warning {
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

        .choices__list--multiple .choices__item {
            display: inline-block;
            vertical-align: middle;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 500;
            margin-right: 3.75px;
            margin-bottom: 3.75px;
            background-color: #0063a6 !important;
            border: 1px solid #0063a6 !important;
            color: #fff;
            word-break: break-all;
            box-sizing: border-box
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
                                View <span class="float-end"><a href="{{ route('client-view', $client->id) }}"
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




                                <div class="col-6">
                                    <h5 class="my-3 text-white">Products Info</h5>

                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Product Name : &nbsp;</label>
                                            <span class="text-bold">{{ $machine->name }}</span>
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
                                                    {{ $machine->platform_max_capacity }} /
                                                    {{ $machine->platform_min_capacity }}
                                                    / {{ $machine->platform_least_count }}</span></span>
                                        </div>
                                        <div class="col-6"><label for="">Loadcell : &nbsp;</label><span
                                                class="text-bold">{{ $machine->loadcell_modal }} /
                                                {{ $machine->loadcell_type }} /
                                                {{ $machine->loadcell_capacity }} /
                                                {{ $machine->loadcell_serial_no }}</span>
                                        </div>
                                        <div class="col-6"><label for="">System : &nbsp;</label><span
                                                class="text-bold">{{ $machine->system_modal }} /
                                                {{ $machine->system_type }} /
                                                {{ $machine->system_cables }} / {{ $machine->system_least_count }}</span>
                                        </div>
                                        <div class="col-6"><label for="">JBt : &nbsp;</label><span
                                                class="text-bold">{{ $machine->jb_modal }} /
                                                {{ $machine->jb_ports }}</span>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">
                                    <h5 class="my-3 text-white">Job Info</h5>
                                    <div class="row">

                                        <div class="col-6">
                                            <label for="">Complaint No. : &nbsp;</label>
                                            <span class="text-bold">{{ $job->complaint_no }}</span>
                                        </div>

                                        <div class="col-6">
                                            <label for="">Complaint date : &nbsp;</label>
                                            <span class="text-bold">{{ $job->complaint_date }}</span>
                                        </div>

                                        <div class="col-6">
                                            <label for="">Description : &nbsp;</label>
                                            <span class="text-bold">{{ $job->call_description }}</span>
                                        </div>

                                        <div class="col-6">
                                            <label for="">Attachment : &nbsp;</label>
                                            <span class="text-bold"><a class="text-white"
                                                    href="{{ URL::to('/') }}/{{ $job->attachments }}" target="_blank">
                                                    View</a></span>
                                        </div>

                                    </div>


                                </div>


                            </div>

                        </div>


                    </div>

                    <div class="row">
                        <button id="addmore" data-bs-toggle="modal" data-bs-target="#exLargeModal"
                            class="btn btn-info mt-2 mb-2 add_input">Add Visit</button>
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <div id="messageTable"></div>
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Assign To</th>
                                    <th>Spare Required</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tabledata">
                                @php $i = 1; @endphp
                                @if (count($visit) > 0)
                                    @foreach ($visit as $item)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ \app\models\Staff::find($item->assign_member_id)->name }}</td>
                                            <td>{{ $item->spare == 1 ? 'Yes' : 'No' }}</td>
                                            <td>
                                                @switch($item->status)
                                                    @case(0)
                                                        <span class="btn btn-danger">Pending</span>
                                                    @break

                                                    @case(1)
                                                        <span class="btn btn-warning">Active</span>
                                                    @break

                                                    @default
                                                        <span class="btn btn-success">Complete</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a class="box-edit" href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#editVisit{{ $item->id }}">
                                                    <i class="bx bx-edit-alt"></i></a>
                                                <a class="box-delete" href="javascript:void(0)"
                                                    onclick="visitDelete({{ $item->id }})">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </td>
                                        </tr>




                                        @php $i++; @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record found</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>

    @if (count($visit) > 0)
        @foreach ($visit as $item)
            <div class="modal fade" id="editVisit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Edit Visit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('visit-update') }}" enctype="multipart/form-data" method="post"
                            class="visitEdit">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $job->id }}" />
                            <input type="hidden" name="visit_id" value="{{ $item->id }}" />

                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control"
                                            placeholder="Enter visit name" name="name" value="{{ $item->name }}">
                                    </div>
                                    <div class="col mb-0">
                                        <label for="assignMember" class="form-label">Assign Member</label>
                                        <select name="assign_member_id" id="assignMember" class="form-control">
                                            <option value="" selected disabled>Select Member</option>
                                            @foreach ($staff as $user)
                                                <option value="{{ $user->id }}"
                                                    @if ($user->id == $item->assign_member_id) selected @endif>{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $spareIds = is_string($item->spare_id) ? json_decode($item->spare_id, true) : [];
                                    $subtask = is_string($item->subtask) ? json_decode($item->subtask, true) : [];
                                @endphp

                                <div class="row g-2 mt-2">
                                    <div class="col mb-0">
                                        <label for="dobExLarge" class="form-label">Task</label>
                                        <select name="task_id[]" id="subtaskq{{ $item->id }}"
                                            class="form-control task-select2" multiple>
                                            @foreach ($task as $d)
                                                <option value="{{ $d->id }}"
                                                    data-description='{{ json_encode(json_decode($d->subtask)) }}'
                                                    @if (in_array($d->id, (array) $subtask)) selected @endif>
                                                    {{ $d->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Preview Box -->
                                <div class="row mt-2" id="taskPreviewContainerQ{{ $item->id }}"
                                    style="display: none;">
                                    <div class="col mt-2">
                                        <label>Selected Tasks</label>
                                        <div id="taskPreviewq{{ $item->id }}" class="border p-1 d-flex"></div>
                                    </div>
                                </div>

                                <!-- JavaScript -->
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        let taskSelect = document.getElementById('subtaskq{{ $item->id }}');
                                        let previewBox = document.getElementById('taskPreviewq{{ $item->id }}');
                                        let previewContainer = document.getElementById('taskPreviewContainerQ{{ $item->id }}');

                                        function updatePreview() {
                                            previewBox.innerHTML = '';

                                            let selectedOptions = taskSelect.selectedOptions;

                                            if (selectedOptions.length > 0) {
                                                let html = '';
                                                for (let option of selectedOptions) {
                                                    let name = option.text;
                                                    let descriptionJson = option.getAttribute('data-description');
                                                    let subtasks = [];

                                                    if (descriptionJson) {
                                                        try {
                                                            subtasks = JSON.parse(descriptionJson);
                                                        } catch (e) {
                                                            subtasks = [];
                                                        }
                                                    }

                                                    html +=
                                                        `<div class="me-5"><span class="mx-2"><strong>${name}</strong></span><ul class="no-list-style">`;
                                                    if (subtasks.length > 0) {
                                                        subtasks.forEach(subtask => {
                                                            html += `<li><strong>${subtask.name}:</strong> ${subtask.desc}</li>`;
                                                        });
                                                    } else {
                                                        html += `<li>No subtasks available</li>`;
                                                    }
                                                    html += `</ul></div>`;
                                                }
                                                previewBox.innerHTML = html;
                                                previewContainer.style.display = 'block';
                                            } else {
                                                previewContainer.style.display = 'none';
                                            }
                                        }

                                        taskSelect.addEventListener('change', updatePreview);

                                        // Trigger preview on page load for pre-selected options
                                        updatePreview();
                                    });
                                </script>


                                <div class="row g-2 mt-2">
                                    <div class="col mb-0">
                                        <label for="spare_edit" class="form-label">Spare parts required <span
                                                class="text-danger">*</span></label>
                                        <div>
                                            <input type="radio" id="spareYes" name="spare_edit" value="1"
                                                @if ($item->spare == 1) checked @endif>
                                            <label for="spareYes">&nbsp;Yes</label>&nbsp;&nbsp;
                                            <input type="radio" id="spareNo" name="spare_edit" value="0"
                                                @if ($item->spare == 0) checked @endif>
                                            <label for="spareNo">&nbsp;No</label>
                                        </div>
                                    </div>

                                    <div class="col mb-0 getSpare_edit @if ($item->spare == 0) hide @endif">
                                        <label for="spareParts" class="form-label">Spare Parts</label>
                                        <select name="spare_id[]" id="spareParts"
                                            class="form-control spare-parts-select2" multiple>
                                            @foreach ($sparepart as $user)
                                                <option value="{{ $user->id }}"
                                                    @if (in_array($user->id, (array) $spareIds)) selected @endif>{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-2 mt-2">
                                    <div class="col mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" class="form-control" name="description">{{ $item->description }}</textarea>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if ($item->status == 1) selected @endif>
                                                Active</option>
                                            <option value="0" @if ($item->status == 0) selected @endif>
                                                Pending</option>
                                            <option value="2" @if ($item->status == 2) selected @endif>
                                                Complete</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Add Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="visitAdd">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}" />
                    <div class="modal-body">

                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="nameExLarge" class="form-label">Name</label>
                                <input type="text" id="nameExLarge" class="form-control"
                                    placeholder="Enter visit name" name="name">
                            </div>
                            <div class="col mb-0">
                                <label for="dobExLarge" class="form-label">Assign Member</label>
                                <select name="assign_member_id" class="form-control">
                                    <option value="" selected disabled>Select Member</option>
                                    @foreach ($staff as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col mb-0">
                                <label for="dobExLarge" class="form-label">Task</label>
                                <select name="task_id[]" class="form-control task-select" id="taskSelect" multiple>
                                    @foreach ($task as $item)
                                        <option value="{{ $item->id }}"
                                            data-description='{{ json_encode(json_decode($item->subtask)) }}'>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Preview Box -->
                        <div class="row mt-2" id="taskPreviewContainer" style="display: none;">
                            <div class="col mt-2">
                                <label>Selected Tasks</label>
                                <div id="taskPreview" class="border p-1 d-flex"></div>
                            </div>
                        </div>

                        <!-- JavaScript -->
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                let taskSelect = document.getElementById('taskSelect');
                                let previewBox = document.getElementById('taskPreview');
                                let previewContainer = document.getElementById('taskPreviewContainer');

                                function updatePreview() {
                                    previewBox.innerHTML = '';

                                    let selectedOptions = taskSelect.selectedOptions;

                                    if (selectedOptions.length > 0) {
                                        let html = '';
                                        for (let option of selectedOptions) {
                                            let name = option.text;
                                            let descriptionJson = option.getAttribute('data-description');
                                            let subtasks = [];

                                            if (descriptionJson) {
                                                try {
                                                    subtasks = JSON.parse(descriptionJson);
                                                } catch (e) {
                                                    subtasks = [];
                                                }
                                            }

                                            html +=
                                                `<div class="me-5"><span class="mx-2"><strong>${name}</strong></span><ul class="no-list-style">`;
                                            if (subtasks.length > 0) {
                                                subtasks.forEach(subtask => {
                                                    html += `<li><strong>${subtask.name} : </strong> ${subtask.desc}</li>`;
                                                });
                                            } else {
                                                html += `<li>No subtasks available</li>`;
                                            }
                                            html += `</ul></div>`;
                                        }
                                        previewBox.innerHTML = html;
                                        previewContainer.style.display = 'block';
                                    } else {
                                        previewContainer.style.display = 'none';
                                    }
                                }

                                taskSelect.addEventListener('change', updatePreview);

                                // Trigger preview on page load for pre-selected options
                                updatePreview();
                            });
                        </script>


                        <div class="row g-2 mt-2">
                            <div class="col mb-0">
                                <label for="nameExLarge" class="form-label text-capitalize">Spare parts required
                                    &nbsp;<span class="text-danger">*</span></label><br>
                                <input type="radio" class="spareClass" name="spare" value="1"><span
                                    class="">&nbsp; Yes</span>&nbsp;&nbsp;
                                <input type="radio" class="spareClass" name="spare" value="0"><span
                                    class="">&nbsp; No</span>
                            </div>
                            <div class="col mb-0 hide" id="getSpare">
                                <label for="dobExLarge" class="form-label">Spare Parts</label>
                                <select name="spare_id[]" id="spareParts" class="form-control spare-parts-select"
                                    multiple>
                                    @foreach ($sparepart as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery and Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".spare-parts-select2");
            elements.forEach(element => {
                new Choices(element, {
                    removeItemButton: true,
                    placeholder: true,
                    // placeholderValue: 'Select spare parts'
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".spare-parts-select");
            elements.forEach(element => {
                new Choices(element, {
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: 'Select spare parts'
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".task-select2");
            elements.forEach(element => {
                new Choices(element, {
                    removeItemButton: true,
                    placeholder: true,
                    // placeholderValue: 'Select task'
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".task-select");
            elements.forEach(element => {
                new Choices(element, {
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: 'Select task'
                });
            });
        });

        $(document).ready(function() {
            $('input[name=spare]').on('change', function() {
                $("#getSpare").toggleClass('hide', $(this).val() != 1);
            });
            $('input[name=spare_edit]').on('change', function() {
                $(".getSpare_edit").toggleClass('hide', $(this).val() != 1);
            });
        });

        function visitDelete(vid) {
            if (confirm("Are you sure you want to delete this visit ?")) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('visit-delete') }}',
                    data: {
                        vid: vid,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        if (response.status) {
                            alert("Visit deleted successfully.");
                            location.reload();
                        } else {
                            alert("Failed to delete the visit. Please try again.");
                        }
                    },
                    error: function(xhr) {
                        alert("An error occurred. Please try again.");
                    }
                });
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            var validator = $("#visitAdd").validate({
                ignore: ":hidden",
                rules: {
                    name: {
                        required: true,
                    },
                    assign_member_id: {
                        required: true,
                    },
                    spare: {
                        required: true
                    },
                    description: {
                        required: false,
                    }
                },
                messages: {
                    name: {
                        required: "Name is required.",
                    },
                    assign_member_id: {
                        required: "Select member"
                    },
                    spare: {
                        required: "Spare is required."
                    },
                    description: {
                        required: "Enter description",
                    }
                },
                errorPlacement: function(error, element) {
                    error.css("color", "red").insertAfter(element);
                },
                success: function(label) {
                    label.remove();
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('visit-save') }}',
                        data: $(form).serialize(),
                        beforeSend: function() {},
                        success: function(response) {
                            $("#visitAdd").trigger('reset');
                            var temp_data = '';
                            var i = 1;
                            response.data.forEach(function(item) {
                                temp_data += '<tr>';
                                temp_data += '<td>' + i + '</td>';
                                temp_data += '<td>' + item.name + '</td>';
                                temp_data += '<td>' + item.assign_member_id +
                                    '</td>';
                                temp_data += '<td>' + (item.spare == 1 ? 'Yes' :
                                    'No') + '</td>';
                                temp_data += '<td>' + (item.status == 1 ? 'Active' :
                                        'Pending') +
                                    '</td>';
                                temp_data += `<td><a class="box-edit" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editVisit${item.id}">
                                      <i class="bx bx-edit-alt"></i></a><a class="box-delete" href="javascript:void(0)" onclick="visitDelete(${item.id})" >
                                                  <i class="bx bx-trash"></i>
                                                </a></td>`;
                                temp_data += '</tr>';
                                i++;
                            });
                            $("#tabledata").html(temp_data);
                            $("#exLargeModal").modal('hide');
                        },
                        error: function(xhr) {
                            alert("An error occurred. Please try again.");
                        }
                    });
                    return false;
                }
            });


            $("#visitAdd input, #visitAdd textarea").on("input", function() {
                $(this).next("label.error").remove();
            });

        });
    </script>

@endsection
