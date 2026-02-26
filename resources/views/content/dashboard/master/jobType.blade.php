@extends('layouts/contentNavbarLayout')

@section('title', 'Job Type')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success {
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

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-lg-9 border p-2">
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">
                              Job Type Information
                                <span class="float-end"><a href="{{ route('job-type-create') }}" class="btn btn-md btn-info">Add</a></span>
                            </span>

                            <div class="table-responsive text-nowrap table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $part)
                                            <tr>
                                                <td>{{ $part->name }}</td>
                                                <td>{{ $part->description }}</td>
                                                <td>
                                                    @if ($part->status == 1)
                                                        <a class="btn btn-md btn-success changeState" href="javascript:void(0)"
                                                           data-state="1" data-id="{{ $part->id }}">Active</a>
                                                    @else
                                                        <a class="btn btn-md btn-danger changeState" href="javascript:void(0)"
                                                           data-state="0" data-id="{{ $part->id }}">Inactive</a>
                                                    @endif
                                                    <a class="box-edit" href="{{ route('job-type-edit', $part->id) }}">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                    <a class="box-delete deletePart" data-id="{{ $part->id }}" href="javascript:void(0)">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @csrf
                                    </tbody>
                                </table>
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
                        url: "{{ route('job-type-status') }}",
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

            $(".deletePart").click(function() {
                id = $(this).attr('data-id');
                _token = $('input[name="_token"]').val();
                if (confirm("Do you want to delete this item !")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('job-type-delete') }}",
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
