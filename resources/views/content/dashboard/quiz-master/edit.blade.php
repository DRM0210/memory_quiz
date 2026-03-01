@extends('layouts/contentNavbarLayout')

@section('title', 'Quiz Master - Edit')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success { width: fit-content; height: 30px; }
        .col-sm-2 { width: 100%; text-align: left; margin: 5px 10px; }
        .h6 { padding: 0px 5px; }
        .current-img { max-width: 120px; max-height: 80px; object-fit: cover; border-radius: 4px; }
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
                                Quiz Master - Edit
                                <span class="float-end">
                                    <a href="{{ route('quiz-master.questions', $data->id) }}" class="btn btn-md btn-info me-1">Manage Questions</a>
                                    <a href="{{ route('quiz-master.index') }}" class="btn btn-md btn-success">Back</a>
                                </span>
                            </span>
                            <form action="{{ route('quiz-master.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Quiz Type <span class="text-danger">*</span></span>
                                            </label>
                                            <select class="form-control mt-n3" name="quiz_type_id" required>
                                                @foreach($quizTypes as $qt)
                                                    <option value="{{ $qt->id }}" {{ old('quiz_type_id', $data->quiz_type_id) == $qt->id ? 'selected' : '' }}>{{ $qt->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Name <span class="text-danger">*</span></span>
                                            </label>
                                            <input type="text" class="form-control mt-n3" name="name" value="{{ old('name', $data->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Memory Time (seconds) <span class="text-danger">*</span></span>
                                            </label>
                                            <input type="number" class="form-control mt-n3" name="memory_time" value="{{ old('memory_time', $data->memory_time ?? 60) }}" min="0" required>
                                            <small class="text-muted">Time to view memory page image.</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Quiz Time (seconds) <span class="text-danger">*</span></span>
                                            </label>
                                            <input type="number" class="form-control mt-n3" name="quiz_time" value="{{ old('quiz_time', $data->quiz_time) }}" min="0" required>
                                            <small class="text-muted">Overall time limit for entire quiz (memory + questions).</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Status</span>
                                            </label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', $data->status) ? 'checked' : '' }}>
                                                <label class="form-check-label">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Memory Page Image</span>
                                            </label>
                                            @if($data->memory_page_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset($data->memory_page_image) }}" alt="" class="current-img">
                                                    <span class="text-muted ms-2">Current memory page</span>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control mt-n3" name="memory_page_image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                            <small class="text-muted">Leave empty to keep current. Max 5MB.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-2">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-md btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
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
