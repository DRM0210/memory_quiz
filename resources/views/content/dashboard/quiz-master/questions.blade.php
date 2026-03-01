@extends('layouts/contentNavbarLayout')

@section('title', 'Quiz Questions')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success { width: fit-content; height: 20px; margin-top: -3px; padding: 10px; }
        .q-thumb { max-width: 50px; max-height: 50px; object-fit: cover; border-radius: 4px; }
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
                                Questions — {{ $quizMaster->name }}
                                <span class="float-end">
                                    <a href="{{ route('quiz-master.question.create', $quizMaster->id) }}" class="btn btn-info me-1">Add Question</a>
                                    <a href="{{ route('quiz-master.edit', $quizMaster->id) }}" class="btn btn-md btn-success">Back to Quiz</a>
                                </span>
                            </span>
                            <p class="text-muted small mb-2">Quiz Type: {{ $quizMaster->quizType->name ?? '-' }} | Quiz Time: {{ $quizMaster->quiz_time }} sec | Status: {{ $quizMaster->status ? 'Active' : 'Inactive' }}</p>
                            @if($quizMaster->memory_page_image)
                                <p class="small"><strong>Memory page:</strong> <img src="{{ asset($quizMaster->memory_page_image) }}" alt="" class="q-thumb ms-1"></p>
                            @endif
                            <div class="table-responsive text-nowrap table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question Image</th>
                                            <th>Answer Image</th>
                                            <th>Options</th>
                                            <th>Correct</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @forelse($quizMaster->questions as $q)
                                        <tr>
                                            <td>{{ $q->sort_order }}</td>
                                            <td>
                                                @if($q->question_image)
                                                    <img src="{{ asset($q->question_image) }}" alt="" class="q-thumb">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($q->answer_image)
                                                    <img src="{{ asset($q->answer_image) }}" alt="" class="q-thumb">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $q->options->count() }} ({{ $q->options->pluck('label')->join(', ') }})</td>
                                            <td>{{ $q->correctOption->label ?? '-' }}</td>
                                            <td>
                                                <a class="btn btn-md btn-info" href="{{ route('quiz-master.question.edit', [$quizMaster->id, $q->id]) }}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                                <a class="btn btn-md btn-danger deleteQuestion" data-id="{{ $q->id }}" href="javascript:void(0)"><i class="bx bx-trash me-2"></i> Delete</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No questions yet. Add a question to show the question image and answer options (like प्रश्न पृष्ठ).</td>
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
        $(".deleteQuestion").click(function(){
            var id = $(this).attr('data-id'); var _token = $('meta[name="csrf-token"]').attr('content');
            if (confirm("Delete this question?")) {
                $.ajax({ type: 'POST', url: "{{ route('quiz-master.question.delete') }}", data: { id: id, _token: _token }, success: function(res){ if (res.redirect) window.location.href = res.redirect; else location.reload(); } });
            }
        });
    });
    </script>
@endsection
