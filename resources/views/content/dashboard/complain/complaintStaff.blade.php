@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')

<style>
  .btn-info{
    width: fit-content;
    height: 30px;
  }
  .btn-danger{
    width: fit-content;
    height: 30px;
  }
  .btn-success{
    width: fit-content;
    height: 30px;
  }

</style>
<!-- Basic Bootstrap Table -->
<div class="card">
  <h4 class="card-header">Complain List of <span class="text-info">{{$staff->name}}</span><span class="float-end"><a href="{{ route('staff') }}" class="btn btn-success">Go Back</a></span></h4>
  @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Complain Code</th>
          <th>Client Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($data as $user)
        <tr>
          <td>{{ $user->complaint_id }}</td>

          <td>{{ $user->client_name }}</td>

          <td>
            @if($user->status == 1)
              <a class="btn btn-md btn-success changeState" href="javascript:void(0)" data-state="1" data-id="{{$user->id}}" >Active</a>
            @else
            <a class="btn btn-md btn-danger changeState" href="javascript:void(0)" data-state="0" data-id="{{$user->id}}">Inactive</a>
            @endif
              <a class="btn btn-md btn-info"  href="{{ route('complain-staff-view',$user->id) }}"> View</a>
              {{-- <a class="btn btn-danger deleteClient" data-id="{{$user->id}}" href="javascript:void(0)"><i class="bx bx-trash me-2"></i> Delete</a> --}}
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
  $(document).ready(function(){
      $(".changeState").click(function(){
        id = $(this).attr('data-id');
        state = $(this).attr('data-state');
        _token = $('input[name="_token"]').val();
        if (confirm("Do you want to change status !")) {
          $.ajax({
            type:'POST',
            url:"{{ route('staff-status') }}",
            data:{id:id, state:state,_token:_token},
            success:function(data){
                if($.isEmptyObject(data.error)){
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
            }
          });
        }
      });

      $(".deleteClient").click(function(){
        id = $(this).attr('data-id');
        _token = $('input[name="_token"]').val();
        if (confirm("Do you want to delete this item !")) {
          $.ajax({
            type:'POST',
            url:"{{ route('staff-delete') }}",
            data:{id:id,_token:_token},
            success:function(data){
                if($.isEmptyObject(data.error)){
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
            }
          });
        }
      });
  });
</script>
@endsection
