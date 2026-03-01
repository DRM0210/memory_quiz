@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Welcome {{ auth()->user()->name }}! 🎉</h5>
            <p class="mb-4">Welcome to the Admin Dashboard!</p>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Available Quizzes</h5>
        <a href="{{ route('quiz-master.index') }}" class="btn btn-sm btn-primary">Manage Quizzes</a>
      </div>
      <div class="card-body">
        @if(isset($availableQuizzes) && $availableQuizzes->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                                                <th>Quiz</th>
                                                <th>Type</th>
                                                <th>Questions</th>
                                                <th>Memory / Quiz Time</th>
                                                <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($availableQuizzes as $quiz)
                <tr>
                                                <td>{{ $quiz->name }}</td>
                                                <td>{{ $quiz->quizType->name ?? '-' }}</td>
                                                <td>{{ $quiz->questions_count }}</td>
                                                <td>{{ $quiz->memory_time ?? 0 }}s / {{ $quiz->quiz_time }}s</td>
                                                <td>
                    <a href="{{ route('quiz-master.questions', $quiz->id) }}" class="btn btn-sm btn-outline-primary">View Questions</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted mb-0">No active quizzes yet. <a href="{{ route('quiz-master.index') }}">Create a quiz</a> to get started.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
