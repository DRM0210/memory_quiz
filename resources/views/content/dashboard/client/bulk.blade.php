@extends('layouts/contentNavbarLayout')

@section('title', 'Client Bulk Upload')

@section('content')
<style>
    .upload-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
    }

    .bg-heading {
        background: #696cff;
        font-weight: 600;
        font-size: 16px;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 20px;
        color: #fff;
    }

    .upload-btn {
        background: #696cff;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        transition: 0.3s;
    }

    .upload-btn:hover {
        background: #5a5dd8;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="upload-card">
            <div class="bg-heading">Client Bulk Upload</div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('client-bulk-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Upload CSV or Excel File</label>
                    <input type="file" name="file" id="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control" required>
                </div>

                <div class="mb-3">
                    <p class="text-muted">Accepted formats: <strong>.csv, .xlsx, .xls</strong></p>
                    <a href="{{ asset('assets/client_data.csv') }}" target="_blank" class="text-primary">Download Sample Format</a>
                </div>

                <button type="submit" class="upload-btn">Upload & Import</button>
            </form>
        </div>
    </div>
</div>
@endsection
