@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
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
                    @if(session('success'))
                        <div class="alert alert-success sessionMsg" id="statusAlert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                let alertBox = document.getElementById("statusAlert");
                                if (alertBox) {
                                    alertBox.style.transition = "opacity 0.5s ease-out";
                                    alertBox.style.opacity = "0";
                                    setTimeout(() => alertBox.remove(), 500);
                                }
                            }, 2000);
                        });
                    </script>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">

                        <div class="col-lg-9 border p-2">
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">Job Task
                                Edit <span class="float-end"><a href="{{ route('task') }}"
                                        class="btn btn-md btn-success">Back</a></span></span>

                            <form action="{{ route('task-update', $data['id']) }}" method="post">
                                @csrf

                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2">
                                                <span class="h6 small bg-white text-dark  pl-2 pr-2">Name <span class="text-danger">*</span>
                                                </span></label>
                                            <input type="text" class="form-control mt-n3" name="name"
                                                value="{{ $data->name }}">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12 addMoreBox mt-2">
                                  <h6 class="">Additional Items</h6>
                                  <div id="additional-items">
                                      @php
                                          $subtask = json_decode($data->subtask, true) ?? [];
                                      @endphp

                                      @foreach ($subtask as $item)
                                          <div class="row additional-item">
                                              <div class="col-md-5">
                                                  <div class="form-group">
                                                    <label for="input1" class="col-sm-2"><span class="h6 small bg-white text-dark pl-2 pr-2">Name</span></label>
                                                      <input class="form-control additional-name mt-n3" type="text" name="subtask_name[]"
                                                             value="{{ $item['name'] }}" >
                                                  </div>
                                              </div>
                                              <div class="col-md-5">
                                                  <div class="form-group">
                                                    <label for="input1" class="col-sm-2"><span class="h6 small bg-white text-dark pl-2 pr-2">Summary</span></label>
                                                      <input class="form-control additional-slug mt-n3" type="text" name="subtask_desc[]"
                                                             value="{{ $item['desc'] }}" readonly>
                                                  </div>
                                              </div>
                                              <div class="col-md-2 d-flex align-items-end">
                                                  <button type="button" class="box-delete removeBtn mb-2" onclick="removeRow(this)"><i class="bx bx-trash"></i></button>
                                              </div>
                                          </div>
                                      @endforeach
                                  </div>
                                  <button type="button" class="btn btn-primary mt-2" onclick="addRow()">Add More</button>
                              </div>


                              <script>
                                  function addRow() {
                                      let newRow = `
                                          <div class="row additional-item">
                                              <div class="col-md-5">
                                                  <div class="form-group">
                                                      <label for="input1" class="col-sm-2"><span class="h6 small bg-white text-dark pl-2 pr-2">Name</span></label>
                                                      <input class="form-control additional-name mt-n3" type="text" name="subtask_name[]"
                                                          onkeyup="generateSlug(this)">
                                                  </div>
                                              </div>
                                              <div class="col-md-5">
                                                  <div class="form-group">
                                                      <label for="input1" class="col-sm-2"><span class="h6 small bg-white text-dark pl-2 pr-2">Summary</span></label>
                                                      <input class="form-control additional-slug mt-n3" type="text" name="subtask_desc[]" >
                                                  </div>
                                              </div>
                                              <div class="col-md-2 d-flex align-items-end">
                                                  <button type="button" class="box-delete removeBtn mb-2" onclick="removeRow(this)"><i class="bx bx-trash"></i></button>
                                              </div>
                                          </div>
                                      `;
                                      document.getElementById('additional-items').insertAdjacentHTML('beforeend', newRow);
                                  }

                                  function removeRow(button) {
                                      button.closest('.additional-item').remove();
                                  }
                              </script>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="input1" class="col-sm-2">
                                            <span
                                                class="h6 small bg-white text-dark pl-2 pr-2">Description</span></label>
                                        <textarea class="form-control mt-n3" name="description">{{ $data->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row justify-content-end mt-2">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-md btn-primary">Save</button>
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
