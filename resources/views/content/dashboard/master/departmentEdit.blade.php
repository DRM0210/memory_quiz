@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <style>
        .btn-info {
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
    </style>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">

        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <h5 class="card-header">Department Edit<span class="float-end"><a
                            href="{{ route('department', Request()->id) }}" class="btn btn-success">Go Back</a></span></h5>
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
                    <form action="{{ route('department-update', ['id' => request()->id, 'id1' => $data['id']]) }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="name" class="form-control"
                                        id="basic-icon-default-fullname" value="{{ $data['name'] }}" aria-label="John Doe"
                                        aria-describedby="basic-icon-default-fullname2" />
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 d-none">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Plant</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <select name="plant_id" class="form-control">
                                        <option value="">Select Plant</option>
                                        @foreach ($plant as $data1)
                                            <option value="{{ $data1->id }}"
                                                @if ($data1->id == $data['plant_id']) selected @endif>{{ $data1->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('plant_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('plant_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Description </label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <textarea name="description" rows="4" class="col-md-12 form-control">{{ $data['description'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
