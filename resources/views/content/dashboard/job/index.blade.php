@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')

    <style>
        .btn-info,
        .btn-success,
        .btn-warning,
        .btn-danger {
            width: fit-content;
            height: 30px;
        }
        .secondTable {
            background: #e5e5e5;
        }

    </style>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h4 class="card-header">Job
            <span class="float-end">
              <a href="{{ route('client-view',$cid) }}" class="btn btn-info">Back</a>
              <a href="{{ route('job.create', ['mid' => $mid, 'cid' => $cid]) }}" class="btn btn-info">Add</a>
            </span>
        </h4>
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



        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Type</th>
                <th>Machine</th>
                <th>Status</th>
                <th>Visit</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($data as $job)
              @php

              @endphp
              <tr>
                <td>{{ $job->name }}</td>
                <td>{{ $job->machine_id }}</td>
                <td>
                  @if($job->status == 1)
                    <a class="btn btn-md btn-success changeState" href="javascript:void(0)" data-state="1" data-id="{{$job->id}}" >Active</a>
                  @else
                  <a class="btn btn-md btn-danger changeState" href="javascript:void(0)" data-state="0" data-id="{{$job->id}}">Inactive</a>
                  @endif
                </td>
                <td>0</td>
                <td>
                  <a class="btn btn-md btn-info"  href="{{ route('job-view',$job->id) }}"><i class="bx bx-eye-alt me-2"></i> View</a>
                    <a class="btn btn-md btn-info"  href="{{ route('client-group-edit',$job->id) }}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                    <a class="btn btn-md btn-danger deleteClient" data-id="{{$job->id}}" href="javascript:void(0)"><i class="bx bx-trash me-2"></i> Delete</a>
                </td>
              </tr>

              @endforeach
            @csrf
            </tbody>
          </table>
        </div>




    </div>





    <!--/ Basic Bootstrap Table -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".changeState").click(function() {
                id = $(this).attr('data-id');
                state = $(this).attr('data-state');
                _token = $('input[name="_token"]').val();
                if (confirm("Do you want to change status !")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('client-status') }}",
                        data: {
                            id: id,
                            state: state,
                            _token: _token
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                location.reload();
                            } else {
                                printErrorMsg(data.error);
                            }
                        }
                    });
                }
            });

            $(".deleteClient").click(function() {
                id = $(this).attr('data-id');
                _token = $('input[name="_token"]').val();
                if (confirm("Do you want to delete this item !")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('client-delete') }}",
                        data: {
                            id: id,
                            _token: _token
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                location.reload();
                            } else {
                                printErrorMsg(data.error);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
