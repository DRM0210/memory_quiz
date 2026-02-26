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
                <a href="{{ route('client-view', $id) }}" class="btn btn-info">Back</a>
                <a href="{{ route('client.job.create', $id) }}" class="btn btn-info">Add</a>
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
                        <th>Caller Name</th>
                        <th>Caller Type
                        </th>
                        <th>Machine
                        </th>
                        <th>Visit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="deptMachineData">
                    @if (count($clientjobs) != 0)
                        @foreach ($clientjobs as $clientjob)
                            <tr>
                                <td><a class="text-info" title="View" data-bs-toggle="modal"
                                        data-bs-target="#basicModal{{ $clientjob->id }}"
                                        href="javascripti:void()">{{ $clientjob->caller_name }}</a>
                                </td>
                                <td>{{ $clientjob->caller_type }}
                                </td>
                                <td>{{ \App\Models\Machine::where('id', $clientjob->machine_id)->value('name') }}
                                </td>
                                <td>{{ $clientjob->visit }}
                                </td>

                                <td>
                                    <a class="box-view mx-1" title="View" data-bs-toggle="modal"
                                        data-bs-target="#basicModal{{ $clientjob->id }}" href="javascript:void(0)">
                                        <i class="bx bx-show" style="font-size: 20px;"></i>
                                    </a>


                                    <a class="box-edit" href="{{ route('client.job.edit', $clientjob->id) }}"><i
                                            class="bx bx-edit-alt"></i></a>
                                    <a class="deleteClientJob box-delete" data-id="{{ $clientjob->id }}"
                                        href="javascript:void(0)"><i class="bx bx-trash"></i></a>

                                </td>
                            </tr>
                            <script>
                                $(".deleteClientJob").click(function() {
                                    let id = $(this).attr('data-id');
                                    let _token = $('input[name="_token"]').val();

                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "Do you want to delete this item?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Yes, delete it!',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                type: 'POST',
                                                url: "{{ route('client.job.delete') }}",
                                                data: {
                                                    id: id,
                                                    _token: _token
                                                },
                                                success: function(data) {
                                                    if ($.isEmptyObject(data.error)) {
                                                        Swal.fire(
                                                            'Deleted!',
                                                            'Your item has been deleted.',
                                                            'success'
                                                        ).then(() => {
                                                            location.reload();
                                                        });
                                                    } else {
                                                        printErrorMsg(data.error);
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>

        </div>
        @endforeach
    @else
        <tr>
            <td>No
                Record
                Found
            </td>
        </tr>
        @endif
        </tbody>
        </table>
    </div>




    </div>
    
@endsection
