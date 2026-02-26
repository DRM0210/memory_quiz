@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')

    <style>
        .btn-info,
        .btn-success,
        .btn-warning,
        .btn-danger {
            width: fit-content;
            height: 30px;
        }

        .has-child-row {
            background: #eef5ff !important;
            font-weight: 600;
            border-left: 4px solid #0d6efd;
        }

        .has-child-row td:first-child a {
            color: #0d6efd !important;
        }

        .has-child-row:hover {
            background: #dcecff !important;
        }

        .secondTable {
            background: #f8f9fa;
            border-left: 3px solid #0d6efd;
        }

        .secondTable tr td {
            background: #ffffff;
            padding: 8px 12px;
            border-bottom: 1px solid #e3e3e3;
        }

        .secondTable tr td:first-child {
            font-weight: 600;
            color: #0d6efd;
        }

        .secondTable tr:hover td {
            background: #eef5ff;
        }

        .accordion-button {
            background: transparent !important;
            box-shadow: none !important;
            padding-left: 0;
        }
    </style>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h4 class="card-header">Client
            <span class="float-end">
                <a href="{{ route('client-bulk') }}" class="btn btn-success">Bulk Upload</a>
                <a href="{{ route('client-draft') }}" class="btn btn-warning">Drafts ({{ $draft }})</a>
                <a href="{{ route('client-create') }}" class="btn btn-info">Add</a>
            </span>
        </h4>
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



        <div class="table-responsive text-nowrap">
            <table class="table table-borderedless">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">

                    @foreach ($data as $user)
                        @php
                            $contact = json_decode($user->billing_address ?? '');
                            $address = json_decode($user->billing_address ?? '');
                            // dd($address);
                            $child = \App\Models\Client::where('parent_id', $user->id)->where('status', 1)->get();
                            $hasChild = count($child) > 0;
                        @endphp

                        <!-- PARENT ROW -->
                        <tr class="{{ $hasChild ? 'has-child-row' : '' }}">
                            <td>
                                <a href="javascript:void(0)" class="accordion-button collapsed fw-bold"
                                    data-bs-toggle="collapse" data-bs-target="#accordion{{ $user->id }}">
                                    {{ $user->name }}
                                </a>
                            </td>

                            <td style="font-size: 13px; line-height: 1.4; font-weight: normal;">
                                <div style="margin-bottom: 4px;">
                                    <i class='bx bx-user' style="margin-right:6px; font-size:16px;"></i>
                                    {{ $contact->contact_person ?? 'N/A' }}
                                </div>

                                <div style="margin-bottom: 4px;">
                                    <i class='bx bx-phone' style="margin-right:6px; font-size:16px;"></i>
                                    {{ $contact->phone ?? 'N/A' }}
                                </div>

                                <div>
                                    <i class='bx bx-envelope' style="margin-right:6px; font-size:16px;"></i>
                                    {{ $contact->email ?? 'N/A' }}
                                </div>
                            </td>

                          <td style="font-size: 13px; line-height: 1.4; font-weight: normal;">
                              <div style="margin-bottom: 4px;">
                                  <i class='bx bx-map' style="margin-right:6px; font-size:16px;"></i>
                                  {{ $contact->address1 ?? '' }}
                              </div>

                              @if(!empty($contact->address2))
                              <div style="margin-bottom: 4px;">
                                  <i class='bx bx-location-plus' style="margin-right:6px; font-size:16px;"></i>
                                  {{ $contact->address2 }}
                              </div>
                              @endif

                              <div>
                                  <i class='bx bx-current-location' style="margin-right:6px; font-size:16px;"></i>
                                  {{ $contact->state ?? '' }}, {{ $contact->city ?? '' }} - {{ $contact->pincode ?? '' }}
                              </div>
                          </td>


                            <td>
                                <a class="box-view" title="View" href="{{ route('client-view', $user->id) }}">
                                    <i class="bx bx-show"></i></a>
                                <a class="box-edit" title="Edit" href="{{ route('client-edit', $user->id) }}">
                                    <i class="bx bx-edit-alt"></i></a>
                                <a class="deleteClient box-delete" title="Delete" data-id="{{ $user->id }}"
                                    href="javascript:void(0)"><i class="bx bx-trash"></i></a>
                            </td>
                        </tr>

                        <!-- CHILD SECTION -->
                        @if ($hasChild)
                            <tr>
                                <td colspan="5" class="p-0">
                                    <div id="accordion{{ $user->id }}" class="accordion-collapse collapse">

                                        <div class="p-2 border rounded bg-light mt-2">

                                            <h6 class="fw-bold text-primary mb-2">Branch <a href="{{ route('client-child-create', $user->id) }}" class="btn btn-sm btn-primary" style="float: right;">
                                                <i class='bx bx-plus'></i> Add Branch
                                            </a></h6>

                                            <table class="table secondTable">
                                                <tbody>
                                                    @foreach ($child as $plant)
                                                        @php
                                                            $contactC = json_decode($plant->billing_address ?? '');
                                                            $addressC = json_decode($plant->billing_address ?? '');
                                                        @endphp

                                                        <tr>
                                                            <td>{{ $plant->name }}</td>

                                                            <td>
                                                                <div style="margin-bottom: 4px;">
                                                                    <i class='bx bx-user' style="margin-right:6px; font-size:16px;"></i>
                                                                    {{ $contactC->contact_person ?? 'N/A' }}
                                                                </div>

                                                                <div style="margin-bottom: 4px;">
                                                                    <i class='bx bx-phone' style="margin-right:6px; font-size:16px;"></i>
                                                                    {{ $contactC->phone ?? 'N/A' }}
                                                                </div>

                                                                <div>
                                                                    <i class='bx bx-envelope' style="margin-right:6px; font-size:16px;"></i>
                                                                    {{ $contactC->email ?? 'N/A' }}
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div style="margin-bottom: 4px;">
                                                                    <i class='bx bx-map' style="margin-right:6px; font-size:16px;"></i>
                                                                    {{ $addressC->address1 ?? '' }}
                                                                </div>

                                                                @if(!empty($addressC->address2))
                                                                <div style="margin-bottom: 4px;">
                                                                    <i class='bx bx-location-plus' style="margin-right:6px; font-size:16px;"></i>
                                                                    {{ $addressC->address2 }}
                                                                </div>
                                                                @endif

                                                                <div>
                                                                    <i class='bx bx-current-location' style="margin-right:6px; font-size:16px;"></i>
                                                                    {{ $addressC->state ?? '' }}, {{ $addressC->city ?? '' }} - {{ $addressC->pincode ?? '' }}
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <a class="box-view" title="View"
                                                                    href="{{ route('client-view', $plant->id) }}">
                                                                    <i class="bx bx-show"></i></a>

                                                                <a class="box-edit" title="Edit"
                                                                    href="{{ route('client-edit', $plant->id) }}">
                                                                    <i class="bx bx-edit-alt"></i></a>

                                                                <a class="deleteClient box-delete" title="Delete"
                                                                    data-id="{{ $plant->id }}"
                                                                    href="javascript:void(0)">
                                                                    <i class="bx bx-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    @csrf
                </tbody>
            </table>


        </div>




    </div>





    <!--/ Basic Bootstrap Table -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".changeState").click(function() {
                id = $(this).attr('data-id');
                state = $(this).attr('data-state');
                _token = $('input[name="_token"]').val();
                if (confirm("Do you want to change status !")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('client-status') }}",
                        data: {
                            id: id,
                            state: state,
                            _token: _token
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                location.reload();
                            } else {
                                printErrorMsg(data.error);
                            }
                        }
                    });
                }
            });

            $(".deleteClient").click(function() {
                id = $(this).attr('data-id');
                _token = $('input[name="_token"]').val();
                if (confirm("Do you want to delete this item !")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('client-delete') }}",
                        data: {
                            id: id,
                            _token: _token
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                location.reload();
                            } else {
                                printErrorMsg(data.error);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
