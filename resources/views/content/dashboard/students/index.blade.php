@extends('layouts/contentNavbarLayout')

@section('title', 'Students')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success { width: fit-content; height: 20px; margin-top: -3px; padding: 10px; }
    </style>

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
                                Students
                            </span>
                            <div class="table-responsive text-nowrap table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @forelse($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ \Str::limit($item->address, 30) ?: '-' }}</td>
                                            <td>
                                                @if($item->status == 1)
                                                    <a class="btn btn-md btn-success changeState" href="javascript:void(0)" data-state="1" data-id="{{ $item->id }}">Active</a>
                                                @else
                                                    <a class="btn btn-md btn-danger changeState" href="javascript:void(0)" data-state="0" data-id="{{ $item->id }}">Inactive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">—</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">No students yet.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-3">@include('layouts/sections/menu/verticalRightMenu')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $(".changeState").click(function(){
            var id = $(this).attr('data-id'); var state = $(this).attr('data-state'); var _token = $('meta[name="csrf-token"]').attr('content');
            if (confirm("Change status?")) {
                $.ajax({ type: 'POST', url: "{{ route('students.status') }}", data: { id: id, state: state, _token: _token }, success: function(){ location.reload(); } });
            }
        });
    });
    </script>
@endsection
