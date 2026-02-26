@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <style>
        .hide {
            display: none;
        }

        .col-sm-2 {
            width: 100%;
            text-align: left;
            margin: 5px 10px;
        }

        .h6 {
            padding: 0px 5px;
        }

        .card-special {
            padding: 5px;
            background: #0063a6;
        }

        .btn-outline-info {
            background: #0063a6;
            color: #fff;
            border-color: #0063a6;
        }

        .btn-outline-info:hover {
            color: #fff !important;
            background-color: #0063a6 !important;
            border-color: #0063a6 !important;
        }

        .col-lg-4 {
            width: 32.333%;
        }

        .btn-outline-info {
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

        .btn-info {
            width: fit-content;
            height: 24px;
            margin: 0px 5px;
        }

        select {
            font-size: 12px !important;
            height: 38px;
        }

        .img_link:hover {
            color: #787bff;
            color: #fff;
            background: #0063a6;
            padding: 5px;
            border-radius: 5px;
        }

        .img_link {
            color: #697a8d;
            padding: 5px;
            border-radius: 5px;
        }

        table {
            width: 99% !important;
        }

        .label1 {
            background: #0063a6;
            padding: 5px;
            color: #fff;
        }

        .client-contact {
            margin-top: -20px;
            margin-left: 40px;
        }

        .client-contact span {
            line-height: 25px;
        }

        .client-service p {
            margin-left: 32px;
        }

        .client-service {
            margin-top: -15px;
        }

        .client-table {
            margin-top: -50px;
        }

        .list-right {
            float: right;
        }

        .tabs-data {
            border-top: 2px solid #e5e5e5;
            margin-top: 10px;
            padding-top: 20px;
        }

        .tab-content {
            background: #f7f7f7 !important;
            box-shadow: unset !important;
        }

        .add_plant {
            display: inline-block;
            float: right;
        }

        .plantAdd {
            border: 1px solid #e5e5e5;
            padding: 10px;
        }

        .plantAdd h5 {
            background: #007bff;
            padding: 10px;
            color: #fff;
        }

        #exampleModalLabel4 {
            background: #e5e5e5;
            padding: 5px;
        }

        #navs-justified-profile>div:nth-child(2)>div:nth-child(1)>div:nth-child(2) {
            padding: 0;
        }

        .textRight {
            text-align: right;
        }

        .textLeft {
            text-align: left;
        }
    </style>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">

        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <h4 class="card-header"><i class="menu-icon tf-icons bx bx-user-circle" style="font-size: 1.95rem"></i>
                    {{ $client->name }} ({{ $client->client_code }})</h4>


                <div class="container-fluid row mb-2">

                    <div class="col-lg-3">
                        <div class="client-contact">
                            @if ($client->parent_id)
                                @php
                                    $client1 = \App\Models\Client::select('id', 'name')
                                        ->where('id', $client->parent_id)
                                        ->first();
                                @endphp
                                <span>Service Location of <a
                                        href="{{ route('client-view', $client1->id) }}">{{ $client1->name }}</a> </span><br>
                            @endif
                            <span><i class="bx bx-envelope"></i> &nbsp;&nbsp;&nbsp;
                                <a href="mailto::{{ $contact->email ?? '' }}">{{ $contact->email ?? '' }}</a></span><br>
                            <span><i class="bx bx-phone"></i> &nbsp;&nbsp;&nbsp;
                                <a href="tel::{{ $contact->phone ?? '' }}">{{ $contact->phone ?? '' }}</a>
                            </span>
                        </div>
                    </div>
                    @php
                        $arr10 = json_decode($client->service_address);
                        $arr11 = json_decode($client->billing_address);
                    @endphp
                    <div class="col-lg-3">
                        <div class="client-service">
                            <span><i class="bx bxs-truck"></i> &nbsp;&nbsp;&nbsp;Service Address</span><br>
                            <p class="">{{ $arr10->address1 }}, {{ $arr10->address2 }} <br> {{ $arr10->state }},
                                {{ $arr10->city }} <br> {{ $arr10->pincode }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="client-service">
                            <span><i class="bx bxs-truck"></i> &nbsp;&nbsp;&nbsp;Billing Address</span><br>
                            <p class="">{{ $arr11->address1 }}, {{ $arr11->address2 }} <br>
                                {{ $arr11->state }},
                                {{ $arr11->city }} <br> {{ $arr11->pincode }}</p>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="client-table">
                            <div class="well well-xs customer-snapshot">
                                <div class="list-group">

                                    @php
                                        $clientCnt = \App\Models\Client::select('id', 'name')
                                            ->where('parent_id', $client->id)
                                            ->count();
                                        $DepartmentCnt = \App\Models\PlantDepartment::where(
                                            'client_id',
                                            $client->id,
                                        )->count();
                                        $MachineCnt = \App\Models\Machine::where('client_id', $client->id)->count();
                                    @endphp
                                    @if ($client->parent_id == null)
                                        <div class="list-group-item"><span
                                                class="snapshot-value">Branches</span><span class="list-right">
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#exLargeModal">
                                                    <i class="bx bx-show text-success"></i>
                                                </a>
                                                ({{ $clientCnt }}) </span>
                                        </div>
                                    @endif


                                    <div class="list-group-item"><span class="snapshot-value">Department</span><span
                                            class="list-right">{{ $DepartmentCnt }}</span></div>
                                    <div class="list-group-item"><span class="snapshot-value">Machine</span><span
                                            class="list-right">{{ $MachineCnt }}</span>
                                    </div>
                                    <div class="list-group-item"><span class="snapshot-value">Jobs</span><span
                                            class="list-right">1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="container-fluid tabs-data">

                    <div class="row">
                        <div class="col-xl-12">
                            {{-- <h6 class="text-muted">Filled Tabs</h6> --}}
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    {{-- @if ($client->parent_id == null)
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-justified-home"
                                                aria-controls="navs-justified-home" aria-selected="true"><i
                                                    class="tf-icons bx bxs-factory me-1"></i><span
                                                    class="d-none d-sm-block"> Plants/Locations</span></button>
                                        </li>
                                    @endif --}}
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                            aria-selected="false"><i class="tf-icons bx bxs-business me-1"></i><span
                                                class="d-none d-sm-block">
                                                Department</span></button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-messages"
                                            aria-controls="navs-justified-messages" aria-selected="false"><i
                                                class="tf-icons bx bxs-cog me-1"></i><span class="d-none d-sm-block">
                                                Machines</span></button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-jobs" aria-controls="navs-justified-jobs"
                                            aria-selected="false"><i class="tf-icons bx bx-job-square me-1"></i><span
                                                class="d-none d-sm-block"> Jobs</span></button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-others" aria-controls="navs-justified-others"
                                            aria-selected="false"><i class="tf-icons bx bxs-grid me-1"></i><span
                                                class="d-none d-sm-block"> Others</span></button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-address" aria-controls="navs-justified-address"
                                            aria-selected="false"><i class="tf-icons bx bxs-location-plus me-1"></i><span
                                                class="d-none d-sm-block">
                                                Address</span></button>
                                    </li>
                                </ul>
                                <div class="tab-content">

                                    <div class="tab-pane fade  show active" id="navs-justified-profile" role="tabpanel">
                                        <h5 class="textRight">
                                            <span class="w-100"><a href="{{ route('department-create', $client->id) }}"
                                                    class="btn btn-info">Add Department</a></span>
                                        </h5>
                                        <div class="col-xl-12">
                                            <div class="nav-align-top mb-4">
                                                <ul class="nav nav-pills mb-3 hide" role="tablist">
                                                    {{-- <li class="nav-item li-link">
                                                      <button type="button" class="nav-link active" role="tab"
                                                          data-bs-toggle="tab" data-bs-target="#navs-pills-top-all"
                                                          aria-controls="navs-pills-top-all" aria-selected="true">All
                                                      </button>
                                                  </li>
                                                  @foreach ($type as $t)
                                                      <li class="nav-item li-link">
                                                          <button type="button" class="nav-link" role="tab"
                                                              data-bs-toggle="tab"
                                                              data-bs-target="#navs-pills-top-{{ $t->id }}"
                                                              aria-controls="navs-pills-top-{{ $t->id }}"
                                                              aria-selected="false">{{ $t->name }}</button>
                                                      </li>
                                                  @endforeach --}}

                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="navs-pills-top-all"
                                                        role="tabpanel">

                                                        <div class="col-md mb-4 mb-md-2">
                                                            <div class="accordion" id="accordionExample">
                                                                @foreach ($department as $item)
                                                                    <div class="card accordion-item">
                                                                        <h2 class="accordion-header d-flex"
                                                                            id="heading{{ $item->id }}">
                                                                            <button type="button"
                                                                                class="accordion-button collapsed"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#accordion{{ $item->id }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="accordion{{ $item->id }}">
                                                                                {{ $item->name }}

                                                                            </button>

                                                                        </h2>

                                                                        <div id="accordion{{ $item->id }}"
                                                                            class="accordion-collapse collapse"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body textRight">
                                                                                <span class="w-100"><a
                                                                                        href="{{ route('machine-create', ['id' => $client->id, 'did' => $item->id]) }}"
                                                                                        class="btn btn-info">Add
                                                                                        Machine</a></span>
                                                                                @php
                                                                                    $deptData = \App\Models\Machine::where(
                                                                                        'client_id',
                                                                                        $client->id,
                                                                                    )
                                                                                        ->where('plant_id', $item->id)
                                                                                        ->get();
                                                                                    //print_r($deptData);
                                                                                @endphp
                                                                                @if (count($deptData) != 0)
                                                                                    <div
                                                                                        class="table-responsive text-nowrap">
                                                                                        <table class="table">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Name</th>
                                                                                                    <th>Machine Code</th>
                                                                                                    <th>Department</th>
                                                                                                    <th>Machine Type</th>
                                                                                                    <th>Machine Model</th>
                                                                                                    <th>Action</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody
                                                                                                class="table-border-bottom-0"
                                                                                                id="deptMachineData">
                                                                                                @if (count($deptData) != 0)
                                                                                                    @foreach ($deptData as $d)
                                                                                                        <tr>
                                                                                                            <td>{{ $d->name }}
                                                                                                            </td>
                                                                                                            <td>{{ $d->machine_code }}
                                                                                                            </td>
                                                                                                            <td>{{ $d->department_name }}
                                                                                                            </td>
                                                                                                            <td>{{ \App\Models\MachineType::find($d->machine_type)->name }}
                                                                                                            </td>
                                                                                                            <td>{{ $d->machine_model }}
                                                                                                            </td>
                                                                                                            <td><a class=""
                                                                                                                    title="View"
                                                                                                                    data-bs-toggle="modal"
                                                                                                                    data-bs-target="#basicModal{{ $d->id }}"
                                                                                                                    href="javascripti:void()">
                                                                                                                    <i class="bx bx-show me-2 text-success"
                                                                                                                        style="font-size: 20px;"></i>
                                                                                                                </a>

                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <style>
                                                                                                            .machine-img img {
                                                                                                                height: 140px;
                                                                                                                width: 100%;
                                                                                                                border: 1px solid #e5e5e5;
                                                                                                                border-radius: 12px;
                                                                                                            }

                                                                                                            .modal-header {
                                                                                                                border-bottom: 2px solid #e5e5e5;
                                                                                                            }

                                                                                                            .pText {
                                                                                                                margin-bottom: 1px;
                                                                                                                border: 1px solid #e5e5e5;
                                                                                                                ;
                                                                                                                padding: 5px;
                                                                                                            }

                                                                                                            .pText label {
                                                                                                                width: 30%;
                                                                                                                border-right: 1px solid #e5e5e5;
                                                                                                            }

                                                                                                            .pText span {
                                                                                                                width: 70%;
                                                                                                                display: inline-block;
                                                                                                                text-align: center;
                                                                                                            }
                                                                                                        </style>
                                                                                                        <!-- Modal -->
                                                                                                        <div class="modal fade"
                                                                                                            id="basicModal{{ $d->id }}"
                                                                                                            tabindex="-1"
                                                                                                            aria-hidden="true">
                                                                                                            <div class="modal-dialog"
                                                                                                                role="document">
                                                                                                                <div
                                                                                                                    class="modal-content">
                                                                                                                    <div
                                                                                                                        class="modal-header">
                                                                                                                        <h5 class="modal-title"
                                                                                                                            id="exampleModalLabel1">

                                                                                                                            {{ $d->name }}
                                                                                                                        </h5>
                                                                                                                        <button
                                                                                                                            type="button"
                                                                                                                            class="btn-close"
                                                                                                                            data-bs-dismiss="modal"
                                                                                                                            aria-label="Close"></button>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="modal-body">
                                                                                                                        <div
                                                                                                                            class="row">
                                                                                                                            <div
                                                                                                                                class="col-lg-7">
                                                                                                                                <div
                                                                                                                                    class="machine-table">
                                                                                                                                    <div
                                                                                                                                        class="well well-xs customer-snapshot">
                                                                                                                                        <div
                                                                                                                                            class="list-group">

                                                                                                                                            <div
                                                                                                                                                class="list-group-item">
                                                                                                                                                <span
                                                                                                                                                    class="snapshot-value">Code</span><span
                                                                                                                                                    class="list-right">{{ $d->machine_code }}</span>
                                                                                                                                            </div>

                                                                                                                                            <div
                                                                                                                                                class="list-group-item">
                                                                                                                                                <span
                                                                                                                                                    class="snapshot-value">Type</span><span
                                                                                                                                                    class="list-right">{{ $d->machine_type }}</span>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="list-group-item">
                                                                                                                                                <span
                                                                                                                                                    class="snapshot-value">Make</span><span
                                                                                                                                                    class="list-right">{{ $d->machine_make }}</span>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="list-group-item">
                                                                                                                                                <span
                                                                                                                                                    class="snapshot-value">Model</span><span
                                                                                                                                                    class="list-right">{{ $d->machine_model }}</span>
                                                                                                                                            </div>

                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div
                                                                                                                                class="col-lg-5 mb-3">
                                                                                                                                <div
                                                                                                                                    class="machine-img">
                                                                                                                                    @if ($d->image)
                                                                                                                                        <img src="{{ URL::to('/') }}/{{ $d->image }}"
                                                                                                                                            alt="">
                                                                                                                                    @else
                                                                                                                                        <img
                                                                                                                                            src="{{ asset('assets/no-img.jpg') }}">
                                                                                                                                    @endif
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="row">
                                                                                                                            <div
                                                                                                                                class="col-lg-12 mb-0">
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Department</label>
                                                                                                                                    <span>{{ $d->department_name }}</span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Buffer
                                                                                                                                        Qty</label>
                                                                                                                                    <span>{{ $d->buffer_qty }}</span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Capacity</label>
                                                                                                                                    <span>{{ $d->capacity }}</span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">PF
                                                                                                                                        Size</label>
                                                                                                                                    <span>{{ $d->pf_size }}</span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Brochure</label>
                                                                                                                                    <span><a href="{{ URL::to('/') }}/{{ $d->brochure }}"
                                                                                                                                            target="_blank">
                                                                                                                                            View</a></span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Datasheet</label>
                                                                                                                                    <span><a href="{{ URL::to('/') }}/{{ $d->datasheet }}"
                                                                                                                                            target="_blank">
                                                                                                                                            View</a></span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Specification</label>
                                                                                                                                    <span>{{ $d->specification }}</span>
                                                                                                                                </p>
                                                                                                                                <p
                                                                                                                                    class="pText">
                                                                                                                                    <label
                                                                                                                                        for="">Description</label>
                                                                                                                                    <span>{{ $d->description }}</span>
                                                                                                                                </p>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="modal-footer">
                                                                                                                        <button
                                                                                                                            type="button"
                                                                                                                            class="btn btn-outline-secondary"
                                                                                                                            data-bs-dismiss="modal">Close</button>
                                                                                                                        {{-- <button type="button"
                                                                                                      class="btn btn-primary">Save
                                                                                                      changes</button> --}}
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                @else
                                                                                                    <tr>
                                                                                                        <td>No Record Found
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                @else
                                                                                    <p class="textLeft">No Record Found</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>
                                                    @foreach ($type as $t1)
                                                        <div class="tab-pane fade"
                                                            id="navs-pills-top-{{ $t1->id }}" role="tabpanel">

                                                            <div class="table-responsive text-nowrap">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Machine Code</th>
                                                                            <th>Department</th>
                                                                            <th>Machine Model</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-border-bottom-0">
                                                                        @if ($data->where('machine_type', $t1->id)->count() > 0)
                                                                            @foreach ($data as $d)
                                                                                @if ($d->machine_type == $t1->id)
                                                                                    <tr>
                                                                                        <td>{{ $d->name }}</td>
                                                                                        <td>{{ $d->machine_code }}</td>
                                                                                        <td>{{ $d->department_name }}</td>
                                                                                        <td>{{ $d->machine_model }}</td>
                                                                                        <td><a class=""
                                                                                                title="View"
                                                                                                href="javascripti:void()">
                                                                                                <i class="bx bx-show me-2 text-success"
                                                                                                    style="font-size: 20px;"></i>
                                                                                            </a>

                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td>No Record Found</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endforeach



                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                                        <h5> <span class="add_plant"><a
                                                    href="{{ route('machine-create', ['id' => $client->id, 'did' => 0]) }}"
                                                    class="btn btn-info">Add</a></span></h5>
                                        <div class="col-xl-12">
                                            <div class="nav-align-top mb-4 p-3">
                                                <ul class="nav nav-pills mb-3" role="tablist">
                                                    <li class="nav-item li-link">
                                                        <button type="button" class="nav-link active" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-all"
                                                            aria-controls="navs-pills-top-all" aria-selected="true">All
                                                        </button>
                                                    </li>
                                                    @foreach ($type as $t)
                                                        <li class="nav-item li-link">
                                                            <button type="button" class="nav-link" role="tab"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#navs-pills-top-{{ $t->id }}"
                                                                aria-controls="navs-pills-top-{{ $t->id }}"
                                                                aria-selected="false">{{ $t->name }}</button>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="navs-pills-top-all"
                                                        role="tabpanel">

                                                        <div class="table-responsive text-nowrap">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Machine Code</th>
                                                                        <th>Department</th>
                                                                        <th>Machine Model</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-border-bottom-0">
                                                                    @if (!@empty($data))
                                                                        @foreach ($data as $d)
                                                                            <tr>
                                                                                <td>{{ $d->name }}</td>
                                                                                <td>{{ $d->machine_code }}</td>
                                                                                <td>{{ $d->department_name }}</td>
                                                                                <td>{{ $d->machine_model }}</td>
                                                                                <td><a class="" title="View"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#basicModal{{ $d->id }}"
                                                                                        href="javascripti:void()">
                                                                                        <i class="bx bx-show me-2 text-success"
                                                                                            style="font-size: 20px;"></i>
                                                                                    </a>

                                                                                </td>
                                                                            </tr>
                                                                            <style>
                                                                                .machine-img img {
                                                                                    height: 140px;
                                                                                    width: 100%;
                                                                                    border: 1px solid #e5e5e5;
                                                                                    border-radius: 12px;
                                                                                }

                                                                                .modal-header {
                                                                                    border-bottom: 2px solid #e5e5e5;
                                                                                }

                                                                                .pText {
                                                                                    margin-bottom: 1px;
                                                                                    border: 1px solid #e5e5e5;
                                                                                    ;
                                                                                    padding: 5px;
                                                                                }

                                                                                .pText label {
                                                                                    width: 30%;
                                                                                    border-right: 1px solid #e5e5e5;
                                                                                }

                                                                                .pText span {
                                                                                    width: 70%;
                                                                                    display: inline-block;
                                                                                    text-align: center;
                                                                                }
                                                                            </style>
                                                                            <!-- Modal -->
                                                                            <div class="modal fade"
                                                                                id="basicModal{{ $d->id }}"
                                                                                tabindex="-1" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="exampleModalLabel1">

                                                                                                {{ $d->name }}
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-7">
                                                                                                    <div
                                                                                                        class="machine-table">
                                                                                                        <div
                                                                                                            class="well well-xs customer-snapshot">
                                                                                                            <div
                                                                                                                class="list-group">

                                                                                                                <div
                                                                                                                    class="list-group-item">
                                                                                                                    <span
                                                                                                                        class="snapshot-value">Code</span><span
                                                                                                                        class="list-right">{{ $d->machine_code }}</span>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="list-group-item">
                                                                                                                    <span
                                                                                                                        class="snapshot-value">Type</span><span
                                                                                                                        class="list-right">{{ $d->machine_type }}</span>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="list-group-item">
                                                                                                                    <span
                                                                                                                        class="snapshot-value">Make</span><span
                                                                                                                        class="list-right">{{ $d->machine_make }}</span>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="list-group-item">
                                                                                                                    <span
                                                                                                                        class="snapshot-value">Model</span><span
                                                                                                                        class="list-right">{{ $d->machine_model }}</span>
                                                                                                                </div>

                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-5 mb-3">
                                                                                                    <div
                                                                                                        class="machine-img">
                                                                                                        @if ($d->image)
                                                                                                            <img src="{{ URL::to('/') }}/{{ $d->image }}"
                                                                                                                alt="">
                                                                                                        @else
                                                                                                            <img
                                                                                                                src="{{ asset('assets/no-img.jpg') }}">
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="col-lg-12 mb-0">
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Department</label>
                                                                                                        <span>{{ $d->department_name }}</span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Buffer
                                                                                                            Qty</label>
                                                                                                        <span>{{ $d->buffer_qty }}</span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Capacity</label>
                                                                                                        <span>{{ $d->capacity }}</span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">PF
                                                                                                            Size</label>
                                                                                                        <span>{{ $d->pf_size }}</span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Brochure</label>
                                                                                                        <span><a href="{{ URL::to('/') }}/{{ $d->brochure }}"
                                                                                                                target="_blank">
                                                                                                                View</a></span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Datasheet</label>
                                                                                                        <span><a href="{{ URL::to('/') }}/{{ $d->datasheet }}"
                                                                                                                target="_blank">
                                                                                                                View</a></span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Specification</label>
                                                                                                        <span>{{ $d->specification }}</span>
                                                                                                    </p>
                                                                                                    <p class="pText">
                                                                                                        <label
                                                                                                            for="">Description</label>
                                                                                                        <span>{{ $d->description }}</span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-outline-secondary"
                                                                                                data-bs-dismiss="modal">Close</button>
                                                                                            {{-- <button type="button"
                                                                                                class="btn btn-primary">Save
                                                                                                changes</button> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td>No Record Found</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @foreach ($type as $t1)
                                                        <div class="tab-pane fade"
                                                            id="navs-pills-top-{{ $t1->id }}" role="tabpanel">

                                                            <div class="table-responsive text-nowrap">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Machine Code</th>
                                                                            <th>Department</th>
                                                                            <th>Machine Model</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-border-bottom-0">
                                                                        @if ($data->where('machine_type', $t1->id)->count() > 0)
                                                                            @foreach ($data as $d)
                                                                                @if ($d->machine_type == $t1->id)
                                                                                    <tr>
                                                                                        <td>{{ $d->name }}</td>
                                                                                        <td>{{ $d->machine_code }}</td>
                                                                                        <td>{{ $d->department_name }}</td>
                                                                                        <td>{{ $d->machine_model }}</td>
                                                                                        <td><a class=""
                                                                                                title="View"
                                                                                                href="javascripti:void()">
                                                                                                <i class="bx bx-show me-2 text-success"
                                                                                                    style="font-size: 20px;"></i>
                                                                                            </a>

                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td>No Record Found</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endforeach



                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="navs-justified-jobs" role="tabpanel">

                                        <p>No record found..!</p>
                                    </div>

                                    <div class="tab-pane fade" id="navs-justified-others" role="tabpanel">
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <div class="client-data-table">
                                                    <div class="well well-xs customer-snapshot">
                                                        <div class="list-group">
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Client
                                                                    Group</span><span
                                                                    class="list-right">{{ $client->client_group }}</span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Referrence</span><span
                                                                    class="list-right">{{ $client->client_reference }}</span>
                                                            </div>
                                                            {{-- <div class="list-group-item"><span
                                                                    class="snapshot-value">CIN</span><span
                                                                    class="list-right">{{ $client->client_cin }}</span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">IEC</span><span
                                                                    class="list-right">{{ $client->client_iec }}</span>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="client-data-table">
                                                    <div class="well well-xs customer-snapshot">
                                                        <div class="list-group">
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Type</span><span
                                                                    class="list-right">{{ $client->client_type }}</span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Size</span><span
                                                                    class="list-right">{{ $client->client_size }}</span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Type</span><span
                                                                    class="list-right">{{ $client->client_type }}</span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Size</span><span
                                                                    class="list-right">{{ $client->client_size }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="client-data-table">
                                                    <div class="well well-xs customer-snapshot">
                                                        <div class="list-group">
                                                            <div class="list-group-item"><span class="snapshot-value">MSME
                                                                    No.</span><span
                                                                    class="list-right">{{ $client->msme_no }}
                                                                </span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Pancard No.</span><span
                                                                    class="list-right">{{ $client->pancard_no }}
                                                                </span>
                                                            </div>
                                                            <div class="list-group-item"><span class="snapshot-value">GST
                                                                    No.</span><span
                                                                    class="list-right">{{ $client->gst_no }}
                                                                </span>
                                                            </div>
                                                            <div class="list-group-item"><span class="snapshot-value">IEC
                                                                    No.</span><span
                                                                    class="list-right">{{ $client->iec_no }}
                                                                </span>
                                                            </div>
                                                            <div class="list-group-item"><span class="snapshot-value">CIN
                                                                    No.</span><span
                                                                    class="list-right">{{ $client->cin_no }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="client-data-table">
                                                    <div class="well well-xs customer-snapshot">
                                                        <div class="list-group">
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">MSME</span><span
                                                                    class="list-right"><a
                                                                        href="{{ URL::to('/') }}/{{ $client->msme }}"
                                                                        target="_blank"> View</a></span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Pancard</span><span
                                                                    class="list-right"><a
                                                                        href="{{ URL::to('/') }}/{{ $client->pancard }}"
                                                                        target="_blank"> View</a></span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">GST</span><span
                                                                    class="list-right"><a
                                                                        href="{{ URL::to('/') }}/{{ $client->gst }}"
                                                                        target="_blank"> View</a></span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">IEC</span><span
                                                                    class="list-right"><a
                                                                        href="{{ URL::to('/') }}/{{ $client->client_iec }}"
                                                                        target="_blank"> View</a></span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">CIN</span><span
                                                                    class="list-right"><a
                                                                        href="{{ URL::to('/') }}/{{ $client->client_cin }}"
                                                                        target="_blank"> View</a></span>
                                                            </div>
                                                            <div class="list-group-item"><span
                                                                    class="snapshot-value">Certification</span><span
                                                                    class="list-right"><a
                                                                        href="{{ URL::to('/') }}/{{ $client->certification }}"
                                                                        target="_blank"> View</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    </div>

                                    <div class="tab-pane fade " id="navs-justified-address" role="tabpanel">
                                        <h5> <span class="add_plant"><a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#modalToggle" class="btn btn-info">Add</a></span></h5>
                                        <table class="table table-bordered">
                                            <div id="messageTable"></div>
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata">
                                                @if (count($clientAddress) > 0)
                                                    @foreach ($clientAddress as $item)
                                                        @php
                                                            $var = json_decode($item->address);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $var->address1 }},{{ $var->address2 }},{{ $var->city }},{{ $var->state }},{{ $var->pincode }}
                                                            </td>
                                                            <td>
                                                                <a class="" href="javascript:void(0)"
                                                                    onclick="deleteAddress({{ $item->id }},{{ $item->client_id }})">
                                                                    <i class="bx bx-trash me-2 text-danger"
                                                                        style="font-size: 20px;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3">No record found</td>
                                                    </tr>
                                                @endif


                                            </tbody>
                                        </table>


                                        <div class="col-lg-4 col-md-6">

                                            <!-- Modal 1-->
                                            <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel"
                                                tabindex="-1" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalToggleLabel">Add Locations
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="messageModal"></div>
                                                            <form id="locationAddForm" method="post"
                                                                enctype="multipart/form-data">
                                                                <div class="row">
                                                                    @csrf
                                                                    <input type="hidden" name="client_id"
                                                                        value="{{ $client->id }}">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="input1" class="col-sm-2">
                                                                                <span
                                                                                    class="h6 small bg-white text-muted pt-1 pl-2 pr-2">Name</span></label>
                                                                            <input type="text"
                                                                                class="form-control mt-n3" name="a_name"
                                                                                value="{{ old('address_name') }}">

                                                                        </div>
                                                                    </div>


                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="input1" class="col-sm-2">
                                                                                <span
                                                                                    class="h6 small bg-white text-muted pt-1 pl-2 pr-2">State</span></label>
                                                                            <select name="a_state" id="a_state"
                                                                                class="form-control mt-n3">
                                                                                <option value="" disabled selected>
                                                                                    Select
                                                                                    State</option>
                                                                                @foreach ($stateModal as $st1)
                                                                                    <option value="{{ $st1->id }}"
                                                                                        @if ($st1->id == old('a_state')) @selected(true) @endif>
                                                                                        {{ $st1->name }}</option>
                                                                                @endforeach
                                                                            </select>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="input1" class="col-sm-2">
                                                                                <span
                                                                                    class="h6 small bg-white text-muted pt-1 pl-2 pr-2">City</span></label>
                                                                            <select name="a_city" id="a_city"
                                                                                class="form-control mt-n3">
                                                                                <option value="" disabled selected>
                                                                                    Select
                                                                                    City</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="input1" class="col-sm-2">
                                                                                <span
                                                                                    class="h6 small bg-white text-muted pt-1 pl-2 pr-2">Pincode</span></label>
                                                                            <input type="text"
                                                                                class="form-control mt-n3"
                                                                                name="a_pincode"
                                                                                value="{{ old('a_pincode') }}">

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="input1" class="col-sm-2">
                                                                                <span
                                                                                    class="h6 small bg-white text-muted pt-1 pl-2 pr-2">Address
                                                                                    1</span></label>
                                                                            <textarea class="form-control mt-n3" name="a_address1">{{ old('a_address1') }}</textarea>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="input1" class="col-sm-2">
                                                                                <span
                                                                                    class="h6 small bg-white text-muted pt-1 pl-2 pr-2">Address
                                                                                    2</span></label>
                                                                            <textarea class="form-control mt-n3" name="a_address2">{{ old('a_address2') }}</textarea>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-12 mt-2">
                                                                    <a href="javascript:void(0)" class="btn btn-primary"
                                                                        id="submitAddress">Save</a>
                                                                </div>

                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>




                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-4 col-md-6">

                <!-- Extra Large Modal -->
                <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title w-100" id="exampleModalLabel4"><i
                                        class="tf-icons bx bxs-factory me-1"></i>Branches</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="col-xl-12 mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Branch List</h6>
                                        <a href="{{ route('client-child-create', $client->id) }}" class="btn btn-sm btn-info">
                                            <i class="bx bx-plus"></i> Add Branch
                                        </a>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($plant) > 0)
                                                @foreach ($plant as $item)
                                                    @php//dd($item);
                                                        $contact1 = \App\Models\ClientContact::where(
                                                            'client_id',
                                                            $item->id,
                                                        )->first();
                                                        $clientAddress1 = \App\Models\ClientAddress::where(
                                                            'client_id',
                                                            $item->id,
                                                        )->first();
                                                        $arr13 = json_decode($item->service_address ?? '');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>
                                                            @if ($arr13 != '')
                                                                {{ $arr13->address1 . ', ' . $arr13->address2 . ', ' . $arr13->state . ', ' . $arr13->city, ', ' . $arr13->pincode }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm branch-status-toggle {{ $item->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                                data-id="{{ $item->id }}" data-state="{{ $item->status }}">
                                                                {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <a class=""
                                                                href="{{ route('client-view', $item->id) }}">
                                                                <i class="bx bx-show me-2 text-success"
                                                                    style="font-size: 20px;"></i>
                                                            </a>
                                                            <a class=""
                                                                href="{{ route('client-edit', $item->id) }}">
                                                                <i class="bx bx-edit-alt me-2 text-info"
                                                                    style="font-size: 20px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No record found</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>



                                </div>

                            </div>
                            {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $("#childShow").on('click', function() {
            $('#exLargeModal').modal('show');
        });
        $(document).ready(function() {
            $(document).on('click', '.branch-status-toggle', function() {
                const button = $(this);
                const id = button.data('id');
                const currentState = button.data('state');
                const token = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

                if (!token) {
                    console.error('CSRF token not found.');
                    return;
                }

                const confirmMessage = currentState == 1
                    ? 'Do you want to deactivate this branch?'
                    : 'Do you want to activate this branch?';

                if (!confirm(confirmMessage)) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('client-status') }}",
                    data: {
                        id: id,
                        state: currentState,
                        _token: token
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Status update failed.', xhr.responseText);
                        alert('Unable to update status at the moment.');
                    }
                });
            });
        });
    </script>
