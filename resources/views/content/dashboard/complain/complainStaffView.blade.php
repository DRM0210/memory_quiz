@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<style>
  .hide{
    display: none;
  }
  .col-sm-2 {
    width: 100%;
    text-align: left;
    margin: 5px 10px;
  }
  .h6 {
    padding: 0px 5px;
  }
.card-special{
  padding: 5px;
background: #0063a6;
}
.btn-outline-info{
  background: #0063a6;
  color:#fff;
  border-color: #0063a6;
}
.btn-outline-info:hover
{
  color: #fff !important;
  background-color: #0063a6 !important;
  border-color: #0063a6 !important;
}

.col-lg-4 {
width: 32.333%;
}
.btn-outline-info{
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
  .btn-info{
    width: fit-content;
    height: 30px;
  }
</style>
<!-- Basic Layout & Basic with Icons -->
<div class="row">

  <!-- Basic with Icons -->
  <div class="col-xxl">
    <div class="card mb-4">
      <h4 class="card-header">Complain Code - {{$data->complaint_id}}<span class="float-end"><a href="{{ route('complain-staff',$data->assigned_to) }}" class="btn btn-success">Go Back</a></span></h4>

      <div class="card-body">
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

        <div class="col-lg-12">
          {{-- client details --}}
          <div class="col-lg-12">
            <div class="client-details row">

              <div class="col-lg-4 card p-0 mx-1">
                <div class="card-header card-special text-center text-white">Basic</div>
                <div class="card-body mt-2">
                  <p class="col-lg-12 m-0">Assigned To:  <span class="float-end">{{$data->assigned_to}}</span></p>
                  <p class="col-lg-12 m-0">Problem : <span class="float-end">{{$data->problem}}</span></p>
                  <p class="col-lg-12 m-0">Problem File : <span class="float-end"><a class="btn btn-md btn-info" href="{{ URL::to('/') }}/{{$data->problem_file}}" target="_blank">View</a></span></p>
                </div>
              </div>

              <div class="col-lg-4 card p-0 mx-1">
                <div class="card-header card-special text-center text-white">Client / Product</div>
                <div class="card-body mt-2">
                  <p class="col-lg-12 m-0">Name / Code:  <span class="float-end">{{$data->client_id}}</span></p>
                  <p class="col-lg-12 m-0">Group : <span class="float-end">{{$group->name}}</span></p>
                  <p class="col-lg-12 m-0">Plant : <span class="float-end">{{$plant->name}}</span></p>
                  <p class="col-lg-12 m-0">Department : <span class="float-end">{{$department->name}}</span></p><br>

                  <p class="col-lg-12 m-0">Type : <span class="float-end">{{$type->name}}</span></p>
                  <p class="col-lg-12 m-0">Product : <span class="float-end">{{$machine->name}}</span></p>
                  <p class="col-lg-12 m-0">Model : <span class="float-end">{{$data->product_model}}</span></p>
                  <p class="col-lg-12 m-0">Make Date : <span class="float-end">{{$data->product_make}}</span></p>
                  <p class="col-lg-12 m-0">Purchase Date : <span class="float-end">{{$data->product_purchase_date}}</span></p>
                  <p class="col-lg-12 m-0">Warrenty : <span class="float-end">{{$data->warrenty}}</span></p>
                </div>
              </div>

              <div class="col-lg-4 card p-0 mx-1">
                <div class="card-header card-special text-center text-white">Contact</div>
                <div class="card-body mt-2">
                  <p class="col-lg-12 m-0">Name: <span class="float-end">{{$data->contact_person}}</span></p>
                  <p class="col-lg-12 m-0">Email : <span class="float-end">{{$data->email}}</span></p>
                  <p class="col-lg-12 m-0">Phone : <span class="float-end">{{$data->phone}}</span></p>
                  <p class="col-lg-12 m-0">Mobile : <span class="float-end">{{$data->mobile}}</span></p>
                  <p class="col-lg-12 m-0">Department : <span class="float-end">{{$data->department}}</span></p>
                  <p class="col-lg-12 m-0">Designation : <span class="float-end">{{$designation->name}}</span></p>
                  <p class="col-lg-12 m-0">Address : <span class="float-end">{{$data->address1}}</span></p>
                </div>
              </div>


            </div>
          </div>

        </div>



      </div>
    </div>
  </div>
</div>
@endsection
