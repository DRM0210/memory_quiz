@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<style>
  .col-sm-2 {
    width: 100%;
    text-align: left;
    margin: 5px 10px;
  }
  .h6 {
    padding: 0px 5px;
  }
  .file{
  margin: 0px 85px;
}
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
  select{
    font-size: 12px !important;
  height: 38px;
  }
</style>
<!-- Basic Layout & Basic with Icons -->
<div class="row">

  <!-- Basic with Icons -->
  <div class="col-xxl">
    <div class="card mb-4">
    <h4 class="card-header">Complain Edit<span class="float-end"><a href="{{ route('complaint') }}" class="btn btn-md btn-success">Go Back</a></span></h4>
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
        <form action="{{ route('complain.update',$data->id) }}" method="post" enctype="multipart/form-data" >
          @csrf
          <div class="row mb-3">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Assign To</span></label>
                <select name="assigned_to" class="form-control mt-n3">
                  <option value="" disabled selected >Select Person</option>
                  <option value=""  >Not Assigned</option>
                  @foreach ($staff as $s)
                  <option value="{{$s->id}}" @if($s->id == $data->assigned_to) selected @endif >{{ $s->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('assigned_to'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('assigned_to') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Client Name</span></label>
                <select name="client_id" id="client_id" class="form-control mt-n3">
                  <option value="" disabled selected >Select Client</option>
                  @foreach ($client as $c)
                  <option value="{{$c->id}}" @if($c->id == $data->client_id) selected @endif >{{ $c->name }}/{{ $c->client_code }}</option>
                  @endforeach
                </select>
                @if ($errors->has('client_id'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('client_id') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Client Group</span></label>
                <select name="client_group" id="client_group" class="form-control mt-n3">
                  <option value="" disabled selected >Select Client Group</option>
                  @foreach ($group as $g)
                  <option value="{{$g->id}}" @if($g->id == $data->client_group) selected @endif >{{ $g->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('client_group'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('client_group') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Plant</span></label>
                <select name="plant_id" id="plant_id1" class="form-control mt-n3">
                  <option value="" disabled selected >Select Plant</option>
                  @foreach ($plant as $p)
                  <option value="{{$p->id}}" @if($p->id == $data->plant_id) selected @endif >{{ $p->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('plant_id'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('plant_id') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Department</span></label>
                <select name="department_id" id="dept" class="form-control mt-n3">
                  <option value="" disabled selected >Select Department</option>
                  @foreach ($plantdepartment as $pd)
                  <option value="{{$pd->id}}" @if($pd->id == $data->department_id) selected @endif >{{ $pd->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('department_id'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('department_id') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Product Type</span></label>
                <select name="product_type" id="product_type" data-id="{{$data->client_id}}" plant-id="{{$data->plant_id}}" class="form-control mt-n3">
                  <option value="" disabled selected >Select Type</option>
                  @foreach ($machine_type as $mt)
                  <option value="{{$mt->id}}" @if($mt->id == $data->product_type) selected @endif >{{$mt->name}}</option>
                  @endforeach
                </select>
                @if ($errors->has('product_type'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('product_type') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Product</span></label>
                <select name="product_code" id="product_code" class="form-control mt-n3">
                  <option value="" disabled selected >Select Product</option>
                  @foreach ($machine as $m)
                  <option value="{{$m->id}}" @if($m->id == $data->product_code) selected @endif >{{$m->name}}</option>
                  @endforeach
                </select>
                @if ($errors->has('product_code'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('product_code') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Product Model</span></label>
                <input type="text" class="form-control mt-n3" id="product_model" name="product_model" value="{{$machinedata->machine_model}}">
                @if ($errors->has('product_model'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('product_model') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Product Make</span></label>
                <input type="text" class="form-control mt-n3" id="product_make" name="product_make" value="{{$machinedata->machine_make}}">
                @if ($errors->has('product_make'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('product_make') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Product Puchase Date</span></label>
                <input type="date" class="form-control mt-n3" name="product_purchase_date" value="{{$data->product_purchase_date}}">
                @if ($errors->has('product_purchase_date'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('product_purchase_date') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Product Warrenty</span></label>
                <select name="warrenty" class="form-control mt-n3">
                  <option value="" disabled selected >Select Warrenty</option>
                  <option value="Yes" @if($data->warrenty == 'Yes') selected @endif >Yes</option>
                  <option value="No" @if($data->warrenty == 'No') selected @endif >No</option>
                </select>
                @if ($errors->has('warrenty'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('warrenty') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Contact Person</span></label>
                  <input type="text" class="form-control mt-n3" id="contact_person" name="contact_person" value="{{$data->contact_person}}">
                  @if ($errors->has('phone'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Email</span></label>
                  <input type="text" class="form-control mt-n3" id="email" name="email" value="{{$data->email}}">
                  @if ($errors->has('email'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Phone Number</span></label>
                  <input type="text" class="form-control mt-n3" id="phone" name="phone" value="{{$data->phone}}">
                  @if ($errors->has('phone'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Mobile Number</span></label>
                  <input type="text" class="form-control mt-n3" id="mobile" name="mobile" value="{{$data->mobile}}">
                  @if ($errors->has('mobile'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Department</span></label>
                  <input type="text" class="form-control mt-n3" id="department" name="department" value="{{$data->department}}">
                  @if ($errors->has('department'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('department') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Designation</span></label>
                  <select name="designation" id="designation" class="form-control mt-n3">
                    <option value="" disabled selected >Select Designation</option>
                    @foreach ($designation as $d)
                    <option value="{{$d->id}}" @if($data->designation == $d->id) selected @endif >{{ $d->name }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('designation'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('designation') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Address</span></label>
                  <textarea class="form-control mt-n3" id="address" name="address1" >{{$data->address1}}</textarea>
                  @if ($errors->has('address2'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('address2') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              {{-- <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">State</span></label>
                  <select class="form-control mt-n3" name="state">
                    <option value="">Select State</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    <option value="Assam">Assam</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Chandigarh">Chandigarh</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                    <option value="Daman and Diu">Daman and Diu</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Lakshadweep">Lakshadweep</option>
                    <option value="Puducherry">Puducherry</option>
                    <option value="Goa">Goa</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Manipur">Manipur</option>
                    <option value="Meghalaya">Meghalaya</option>
                    <option value="Mizoram">Mizoram</option>
                    <option value="Nagaland">Nagaland</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Sikkim">Sikkim</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="West Bengal">West Bengal</option>
                  </select>
                  @if ($errors->has('state'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('state') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">City</span></label>
                  <input type="text" class="form-control mt-n3" name="city" value="">
                  @if ($errors->has('city'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="input1" class="col-sm-2">
                  <span class="h6 small bg-white text-muted pl-2 pr-2">Pincode</span></label>
                  <input type="text" class="form-control mt-n3" name="pincode" value="">
                  @if ($errors->has('pincode'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('pincode') }}</strong>
                        </span>
                    @endif
                </div>
              </div> --}}



            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2 file">Problem File (if applicable)</span></label>
                <input type="file" class="form-control mt-n3" name="problem_file" value="">
                @if(!empty($data->problem_file))
                  <img src="{{ URL::to('/') }}/{{$data->problem_file}}" style="width:100%;height:150px;" >
                  @endif
                @if ($errors->has('problem_file'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('problem_file') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

          </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="input1" class="col-sm-2">
                <span class="h6 small bg-white text-muted pl-2 pr-2">Problem Description</span></label>
                <textarea class="form-control mt-n3" name="problem">{{$data->problem}}</textarea>
                @if ($errors->has('problem'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('problem') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

          </div>

          <div class="row justify-content-end">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-md btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
