@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info {
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

        .btn-secondary {
            width: fit-content;
            height: 20px;
            margin-top: -3px;
            padding: 10px;
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
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">Staff
                                Information <span class="float-end"><a href="{{ route('staff-create') }}"
                                        class="btn btn-md btn-info">Add</a></span></span>

                            <div class="">
                                <div class="table-responsive text-nowrap table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th class="text-center">Assigned Complain</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->position }}</td>
                                                    <td class="text-center">
                                                        @if ($user->complaint_count > 0)
                                                            <a class="btn btn-md btn-info" title="View"
                                                                href="{{ route('complain-staff', $user->id) }}">{{ $user->complaint_count }}</a>
                                                        @else
                                                            <span
                                                                class="btn btn-md btn-secondary">{{ $user->complaint_count }}</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($user->status == 1)
                                                            <a class="btn btn-md btn-success changeState" href="javascript:void(0)"
                                                                data-state="1" data-id="{{ $user->id }}">Active</a>
                                                        @else
                                                            <a class="btn btn-md btn-danger changeState" href="javascript:void(0)"
                                                                data-state="0" data-id="{{ $user->id }}">Inactive</a>
                                                        @endif
                                                        <a class="btn btn-md btn-info"
                                                            href="{{ route('staff-edit', $user->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i> Edit</a>
                                                        <a class="btn btn-md btn-danger deleteClient"
                                                            data-id="{{ $user->id }}" href="javascript:void(0)"><i
                                                                class="bx bx-trash me-2"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @csrf
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-3">

                            @include('layouts/sections/menu/verticalRightMenu')

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
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
                        url: "{{ route('staff-status') }}",
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
                        url: "{{ route('staff-delete') }}",
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
