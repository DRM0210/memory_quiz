@extends('layouts/contentNavbarLayout')

@section('title', 'Quiz Master')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success { width: fit-content; height: 20px; margin-top: -3px; padding: 10px; }
        .quiz-master-thumb { max-width: 60px; max-height: 50px; object-fit: cover; border-radius: 4px; }
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
                                Quiz Master
                                <span class="float-end"><a href="{{ route('quiz-master.create') }}" class="btn btn-info">Add Quiz</a></span>
                            </span>
                            <div class="table-responsive text-nowrap table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Memory Page</th>
                                            <th>Name</th>
                                            <th>Quiz Type</th>
                                            <th>Quiz Time (sec)</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($data as $item)
                                        <tr>
                                            <td>
                                                @if($item->memory_page_image)
                                                    <img src="{{ asset($item->memory_page_image) }}" alt="" class="quiz-master-thumb">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quizType->name ?? '-' }}</td>
                                            <td>{{ $item->quiz_time }}</td>
                                            <td>
                                                @if($item->status == 1)
                                                    <a class="btn btn-md btn-success changeState" href="javascript:void(0)" data-state="1" data-id="{{ $item->id }}">Active</a>
                                                @else
                                                    <a class="btn btn-md btn-danger changeState" href="javascript:void(0)" data-state="0" data-id="{{ $item->id }}">Inactive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-md btn-info" href="{{ route('quiz-master.questions', $item->id) }}"><i class="bx bx-list-check me-2"></i> Questions</a>
                                                <a class="btn btn-md btn-info" href="{{ route('quiz-master.edit', $item->id) }}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                                <a class="btn btn-md btn-danger deleteQuizMaster" data-id="{{ $item->id }}" href="javascript:void(0)"><i class="bx bx-trash me-2"></i> Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
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
                $.ajax({ type: 'POST', url: "{{ route('quiz-master.status') }}", data: { id: id, state: state, _token: _token }, success: function(){ location.reload(); } });
            }
        });
        $(".deleteQuizMaster").click(function(){
            var id = $(this).attr('data-id'); var _token = $('meta[name="csrf-token"]').attr('content');
            if (confirm("Delete this quiz and all its questions?")) {
                $.ajax({ type: 'POST', url: "{{ route('quiz-master.delete') }}", data: { id: id, _token: _token }, success: function(){ location.reload(); } });
            }
        });
    });
    </script>
@endsection
