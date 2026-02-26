@extends('layouts/contentNavbarLayout')

@section('title', 'Quiz Type - Edit')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success { width: fit-content; height: 30px; }
        .col-sm-2 { width: 100%; text-align: left; margin: 5px 10px; }
        .h6 { padding: 0px 5px; }
        .current-img { max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 4px; }
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
                                Quiz Type - Edit
                                <span class="float-end">
                                    <a href="{{ route('quiz-type.index') }}" class="btn btn-md btn-success">Back</a>
                                </span>
                            </span>
                            <form action="{{ route('quiz-type.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Name <span class="text-danger">*</span></span>
                                            </label>
                                            <input type="text" class="form-control mt-n3" name="name" value="{{ old('name', $data->name) }}" required>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback d-block"><strong>{{ $errors->first('name') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Time Duration (minutes) <span class="text-danger">*</span></span>
                                            </label>
                                            <input type="number" class="form-control mt-n3" name="time_duration" value="{{ old('time_duration', $data->time_duration) }}" min="0" required>
                                            @if ($errors->has('time_duration'))
                                                <span class="invalid-feedback d-block"><strong>{{ $errors->first('time_duration') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">No. of Questions <span class="text-danger">*</span></span>
                                            </label>
                                            <input type="number" class="form-control mt-n3" name="no_of_questions" value="{{ old('no_of_questions', $data->no_of_questions ?? 0) }}" min="0" required>
                                            @if ($errors->has('no_of_questions'))
                                                <span class="invalid-feedback d-block"><strong>{{ $errors->first('no_of_questions') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Description</span>
                                            </label>
                                            <textarea class="form-control mt-n3" name="description" rows="3">{{ old('description', $data->description) }}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback d-block"><strong>{{ $errors->first('description') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-sm-2">
                                                <span class="h6 small bg-white text-dark pl-2 pr-2">Image</span>
                                            </label>
                                            @if($data->image)
                                                <div class="mb-2">
                                                    <img src="{{ asset($data->image) }}" alt="" class="current-img">
                                                    <span class="text-muted ms-2">Current image</span>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control mt-n3" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                            <small class="text-muted">Leave empty to keep current. JPG, PNG or GIF. Max 2MB.</small>
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback d-block"><strong>{{ $errors->first('image') }}</strong></span>
                                            @endif
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
