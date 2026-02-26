<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
  Complaint,
  Staff,
  Client,
  ClientGroup,
  Department,
  Machine,
  MachineType,
  Plant,
  PlantDepartment,
  Designation
};

class ComplaintController extends Controller
{
  public function getClientGroup(Request $request)
  {
    $group = Client::join('client_groups', 'clients.client_group', '=', 'client_groups.id')
      ->where('clients.id', '=', $request->cid)
      ->select('client_groups.id', 'client_groups.name')
      ->get();
    $plant = Plant::select('id', 'name')
      ->where('client_id', $request->cid)
      ->get();
    $response = [
      'group' => $group,
      'plant' => $plant,
    ];
    return $response;
  }

  public function getClientDepartmentContact(Request $request)
  {
    $plant = Plant::select(
      'id',
      'client_id',
      'contact_person',
      'phone',
      'email',
      'mobile',
      'department',
      'designation',
      'address'
    )
      ->where('id', $request->pid)
      ->first();
    $department = PlantDepartment::select('id', 'name')
      ->where('plant_id', $request->pid)
      ->get();
    $response = [
      'department' => $department,
      'plant' => $plant,
    ];
    return $response;
  }

  public function getClientMachine(Request $request)
  {
    $machine = Machine::select('id', 'name')
      ->where('client_id', $request->cid)
      ->where('plant_id', $request->pid)
      ->where('machine_type', $request->tid)
      ->get();
    return $machine;
  }

  public function getClientMachineDetail(Request $request)
  {
    $machine = Machine::select('machine_model', 'machine_make')
      ->where('id', $request->mid)
      ->first();
    $response = [
      'machine' => $machine,
    ];
    return $response;
  }

  public function index()
  {
    $data = Complaint::leftJoin('staff', 'complaints.assigned_to', '=', 'staff.id')
      ->select('complaints.id', 'complaints.complaint_id', 'complaints.status', 'staff.name as staff_name')
      ->get();

    return view('content.dashboard.complain.index', compact('data'));
  }

  public function complainStaff($id)
  {
    $staff = Staff::select('name')
      ->where('id', $id)
      ->first();

    $data = Complaint::join('clients', 'complaints.client_id', '=', 'clients.id')
      ->select('complaints.id', 'complaints.complaint_id', 'complaints.status', 'clients.name as client_name')
      ->where('assigned_to', $id)
      ->get();

    return view('content.dashboard.complain.complaintStaff', compact('data', 'staff'));
  }

  public function complainStaffView($id)
  {
    $data = Complaint::where('id', $id)->first();
    $plant = Plant::select('name')
      ->where('id', $data->plant_id)
      ->first();
    $group = ClientGroup::select('name')
      ->where('id', $data->client_group)
      ->first();
    $department = PlantDepartment::select('name')
      ->where('id', $data->department_id)
      ->first();
    $type = MachineType::select('name')
      ->where('id', $data->product_type)
      ->first();
    $machine = Machine::select('name')
      ->where('id', $data->product_code)
      ->first();
    $designation = Designation::select('name')
      ->where('id', $data->designation)
      ->first();

    return view(
      'content.dashboard.complain.complainStaffView',
      compact('data', 'plant', 'group', 'department', 'type', 'machine', 'designation')
    );
  }

  public function create()
  {
    $staff = Staff::select('id', 'name')
      ->where('status', 1)
      ->get();
    $designation = Designation::select('id', 'name')
      ->where('status', 1)
      ->get();
    $client = Client::select('id', 'name', 'client_code')
      ->where('status', 1)
      ->get();
    $machine_type = MachineType::select('id', 'name')
      ->where('status', 1)
      ->get();
    return view('content.dashboard.complain.create', compact('staff', 'client', 'machine_type', 'designation'));
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      // 'assigned_to' => 'required|string',
      'client_id' => 'required|string',
      'client_group' => 'required|string',
      'plant_id' => 'required|string',
      'department_id' => 'required|string',
      'product_type' => 'required|string',
      'product_code' => 'required|string',
      'product_model' => 'required|string',
      'product_make' => 'required|string',
      'product_purchase_date' => 'required',
      'warrenty' => 'required',
      'problem_file' => 'mimes:jpeg,png,jpg,gif',
      'problem' => 'required|string',

      'contact_person' => 'required|string',
      'email' => 'required|email',
      'phone' => 'required|string',
      'mobile' => 'required|string',
      'department' => 'required|string',
      'designation' => 'required|string',
      'address1' => 'required|string',
    ]);

    $data = new Complaint();
    $data->complaint_id = $this->generate_client_code();

    $data->contact_person = $request->contact_person;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->mobile = $request->mobile;
    $data->department = $request->department;
    $data->designation = $request->designation;
    $data->address1 = $request->address1;

    // $data->assigned_to = $request->assigned_to;
    // $data->assigned_by = auth()->user()->id;
    $data->client_id = $request->client_id;
    $data->client_group = $request->client_group;
    $data->plant_id = $request->plant_id;
    $data->department_id = $request->department_id;
    $data->product_type = $request->product_type;
    $data->product_code = $request->product_code;
    $data->product_model = $request->product_model;
    $data->product_make = $request->product_make;
    $data->product_purchase_date = $request->product_purchase_date;
    $data->warrenty = $request->warrenty;
    $data->problem = $request->problem;
    $data->status = 1;

    if ($request->hasFile('problem_file')) {
      $file = $request->file('problem_file');
      $upload_name = 'assets/uploads/complain/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/uploads/complain'), $upload_name);
      $data->problem_file = $upload_name;
    }

    if ($data->save()) {
      session()->flash('success', 'Complaint created successfully');
      return redirect()->route('complaint');
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }

  public function generate_client_code()
  {
    $latestClient = Complaint::max('id');

    if ($latestClient) {
      $stringClientCode = (int) $latestClient;
      $newClientCode = sprintf('%04d', $stringClientCode + 1);
      return $newClientCode;
    } else {
      return '0001';
    }
  }

  public function edit($id)
  {
    $data = Complaint::find($id);
    $staff = Staff::select('id', 'name')
      ->where('status', 1)
      ->get();
    $designation = Designation::select('id', 'name')
      ->where('status', 1)
      ->get();
    $client = Client::select('id', 'name', 'client_code')
      ->where('status', 1)
      ->get();
    $group = ClientGroup::select('id', 'name')
      ->where('status', 1)
      ->get();

    $plant = Plant::select('id', 'name')
      ->where('client_id', $data->client_id)
      ->get();

    $plantdepartment = PlantDepartment::select('id', 'name')
      ->where('client_id', $data->client_id)
      ->get();

    $machine = Machine::select('id', 'name')
      ->where('client_id', $data->client_id)
      ->get();

    $machinedata = Machine::select('machine_model', 'machine_make')
      ->where('client_id', $data->client_id)
      ->first();

    $machine_type = MachineType::select('id', 'name')
      ->where('status', 1)
      ->get();
    return view(
      'content.dashboard.complaintEdit',
      compact(
        'data',
        'staff',
        'client',
        'designation',
        'machine_type',
        'group',
        'plant',
        'plantdepartment',
        'machine',
        'machinedata'
      )
    );
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      // 'assigned_to' => 'required|string',
      'client_id' => 'required|string',
      'client_group' => 'required|string',
      'plant_id' => 'required|string',
      'department_id' => 'required|string',
      'product_type' => 'required|string',
      'product_code' => 'required|string',
      'product_model' => 'required|string',
      'product_make' => 'required|string',
      'product_purchase_date' => 'required',
      'warrenty' => 'required',
      'problem_file' => 'mimes:jpeg,png,jpg,gif',
      'problem' => 'required|string',

      'contact_person' => 'required|string',
      'email' => 'required|email',
      'phone' => 'required|string',
      'mobile' => 'required|string',
      'department' => 'required|string',
      'designation' => 'required|string',
      'address1' => 'required|string',
    ]);
    $complaint = Complaint::where('id', $id)->get();
    $data = [
      'assigned_to' => $request->assigned_to,
      'client_id' => $request->client_id,
      'client_group' => $request->client_group,
      'plant_id' => $request->plant_id,
      'department_id' => $request->department_id,
      'product_type' => $request->product_type,
      'product_code' => $request->product_code,
      'product_model' => $request->product_model,
      'product_make' => $request->product_make,
      'product_purchase_date' => $request->product_purchase_date,
      'warrenty' => $request->warrenty,
      'problem' => $request->problem,

      'contact_person' => $request->contact_person,
      'email' => $request->email,
      'phone' => $request->phone,
      'mobile' => $request->mobile,
      'department' => $request->department,
      'designation' => $request->designation,
      'address1' => $request->address1,
    ];

    if ($request->hasFile('problem_file')) {
      $file = $request->file('problem_file');
      $upload_name = 'assets/uploads/client/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/uploads/client'), $upload_name);
      $data['problem_file'] = $upload_name;
    } else {
      $data['problem_file'] = $complaint[0]['problem_file'];
    }

    if (Complaint::where('id', $id)->update($data)) {
      session()->flash('success', 'Complain updated successfully');
      return redirect()->route('complaint');
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }

  public function status(Request $request)
  {
    if ($request->state == 1) {
      $data = Complaint::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = Complaint::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function delete(Request $request)
  {
    $data = Complaint::where('id', $request->id)->delete();
    session()->flash('success', 'Complain deleted successfully');
    return redirect()->route('complaint');
  }
}
