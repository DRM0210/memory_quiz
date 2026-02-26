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
  <h4 class="card-header">Client Draft<span class="float-end"><a href="{{ route('client') }}"
    class="btn btn-success">Go Back</a></span></h4>
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
          <th>Name</th>
          <th>Client Code</th>
          <th>Parent</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($data as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td> {{ $user->client_code }}</td>
          <td>
            @php
                $paretn = \App\Models\Client::where('id', $user->parent_id)->first();
            @endphp

            @if($paretn)
                {{ $paretn->name }}
            @endif
        </td>

          <td>

              <a class="btn btn-info"  href="{{ route('client-edit', $user->id) }}"> Edit</a>
              <a class="btn btn-danger deleteClient" data-id="{{$user->id}}" href="javascript:void(0)"><i class="bx bx-trash me-2"></i> Delete</a>
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
            url:"{{ route('complain.status') }}",
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
            url:"{{ route('client-delete') }}",
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
