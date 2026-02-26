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
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">Role
                                Information <span class="float-end"><a href="{{ route('role-create') }}"
                                        class="btn btn-info">Add</a></span></span>

                            <div class="">
                                <div class="table-responsive text-nowrap table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        @if ($user->id == 1)
                                                            <a class="btn btn-info" href="javascript:void(0);">Non
                                                                Editable</a>
                                                        @else
                                                            <a class="box-edit"
                                                                href="{{ route('role-edit', $user->id) }}"><i
                                                                    class="bx bx-edit-alt"></i></a>
                                                            <a class="box-delete"
                                                                href="{{ route('role-delete', $user->id) }}"><i
                                                                    class="bx bx-trash"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

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
@endsection
