<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
  ClientType,
  ClientGroup,
  Client,
  MachineType,
  Plant,
  Machine,
  Designation,
  Department,
  ClientContact,
  PlantDepartment,
  Complaint,
  State,
  City,
  ClientAddress,
  job
};

class MachineController extends Controller
{
  public function machine()
  {
    $data = Machine::get();
    $plant = Plant::where('status', 1)->get();
    return view('content.dashboard.machine.machine', compact('data', 'plant'));
  }

  public function machinePlant(Request $request)
  {
    $data = Machine::where('plant_id', $request->plant)->get();
    $plant = Plant::where('status', 1)->get();
    return view('content.dashboard.machine.machine', compact('data', 'plant'));
  }

  public function machineCreate($id, $did, $mtid)
  {
    $machine_types = MachineType::where('status', 1)->get();
    $client = Client::select('id', 'name')
      ->where('id', $id)
      ->first();
    $department = PlantDepartment::where('status', 1)
      ->where('id', $did)
      ->first();

    return view(
      'content.dashboard.machine.machineCreate',
      compact('machine_types', 'department', 'id', 'did', 'mtid', 'client')
    );
  }

  public function machineSave(Request $request)
  {
    $validatedData = $request->validate([
      'client_id' => 'required|integer',
      'department_id' => 'required|integer',
      'machine_type' => 'required|integer',
      'name' => 'required|string|max:255',
      'add_type' => 'required|string|max:255',
      'type' => 'nullable|string',
      'make_model' => 'nullable|string|max:255',
      'offer_details' => 'required|array',
      'po_details' => 'required|array',
      'invoice' => 'required|array',
      'offer_details_file.*' => 'nullable|file|mimes:pdf|max:5120',
      'po_details_file.*' => 'nullable|file|mimes:pdf|max:5120',
      'invoice_file.*' => 'nullable|file|mimes:pdf|max:5120',
      'serial' => 'nullable|string|max:255',
      'platform_size' => 'nullable|string|max:255',
      'platform_max_capacity' => 'nullable|string|max:255',
      'platform_min_capacity' => 'nullable|string|max:255',
      'platform_least_count' => 'nullable|string|max:255',
      'loadcell_modal' => 'nullable|string|max:255',
      'loadcell_type' => 'nullable|string|max:255',
      'loadcell_capacity' => 'nullable|string|max:255',
      'loadcell_serial_no' => 'nullable|string|max:255',
      'system_modal' => 'nullable|string|max:255',
      'system_type' => 'nullable|string|max:255',
      'system_cables' => 'nullable|string|max:255',
      'system_least_count' => 'nullable|string|max:255',
      'jb_modal' => 'nullable|string|max:255',
      'jb_ports' => 'nullable|string|max:255',
      'inclusion' => 'nullable|array',
      'exclusion' => 'nullable|array',
      'inclusionAdditional' => 'nullable|array',
      'exclusionAdditional' => 'nullable|array',
      'additional' => 'nullable|array',
      'specification' => 'nullable|string',
      'description' => 'nullable|string',
      'stamping_vc.*' => 'nullable|file|mimes:pdf|max:5120',
      'brochure.*' => 'nullable|file|mimes:pdf|max:5120',
      'datasheet.*' => 'nullable|file|mimes:pdf|max:5120',
      'product_link' => 'nullable|url',
      'inclusion.pdf.*' => 'nullable|file|mimes:pdf|max:5120',
      'exclusion.pdf.*' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $machine = new Machine();
    $machine->client_id = $request->client_id;
    $machine->department_id = $request->department_id;
    $machine->machine_type = $request->machine_type;
    $machine->name = $request->name;
    $machine->add_type = $request->add_type;
    $machine->type = $request->type;
    $machine->make_model = $request->make_model;
    $machine->offer_details = json_encode($request->offer_details);
    $machine->po_details = json_encode($request->po_details);
    $machine->invoice = json_encode($request->invoice);
    $machine->serial = $request->serial;
    $machine->platform_size = $request->platform_size;
    $machine->platform_max_capacity = $request->platform_max_capacity;
    $machine->platform_min_capacity = $request->platform_min_capacity;
    $machine->platform_least_count = $request->platform_least_count;
    $machine->loadcell_modal = $request->loadcell_modal;
    $machine->loadcell_type = $request->loadcell_type;
    $machine->loadcell_capacity = $request->loadcell_capacity;
    $machine->loadcell_serial_no = $request->loadcell_serial_no;
    $machine->system_modal = $request->system_modal;
    $machine->system_type = $request->system_type;
    $machine->system_cables = $request->system_cables;
    $machine->system_least_count = $request->system_least_count;
    $machine->jb_modal = $request->jb_modal;
    $machine->jb_ports = $request->jb_ports;
    $machine->specification = $request->specification;
    $machine->description = $request->description;
    $machine->product_link = $request->product_link;
    $machine->inclusionAdditional = json_encode($request->inclusionAdditional);
    $machine->exclusionAdditional = json_encode($request->exclusionAdditional);
    $machine->additional = json_encode($request->additional);

    if ($request->hasFile('offer_details_file')) {
      foreach ($request->file('offer_details_file') as $file) {
        $upload_name = 'assets/uploads/machine/offers/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/offers'), $upload_name);
        $offer_files[] = $upload_name;
      }
      $machine->offer_details_file = json_encode($offer_files);
    }

    if ($request->hasFile('po_details_file')) {
      foreach ($request->file('po_details_file') as $file) {
        $upload_name = 'assets/uploads/machine/pos/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/pos'), $upload_name);
        $po_files[] = $upload_name;
      }
      $machine->po_details_file = json_encode($po_files);
    }

    if ($request->hasFile('invoice_file')) {
      foreach ($request->file('invoice_file') as $file) {
        $upload_name = 'assets/uploads/machine/invoices/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/invoices'), $upload_name);
        $invoice_files[] = $upload_name;
      }
      $machine->invoice_file = json_encode($invoice_files);
    }

    if ($request->hasFile('inclusion.pdf')) {
      $inclusion_files = [];
      foreach ($request->file('inclusion.pdf') as $file) {
        $upload_name = 'assets/uploads/machine/inclusion/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/inclusion'), $upload_name);
        $inclusion_files[] = $upload_name;
      }
      $inclusionData = [
        'label' => $request->input('inclusion.label'),
        'start_date' => $request->input('inclusion.start_date'),
        'end_date' => $request->input('inclusion.end_date'),
        'pdf' => json_encode($inclusion_files),
      ];
      $machine->inclusion = json_encode($inclusionData);
    }

    if ($request->hasFile('exclusion.pdf')) {
      $exclusion_files = [];
      foreach ($request->file('exclusion.pdf') as $file) {
        $upload_name = 'assets/uploads/machine/exclusion/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/exclusion'), $upload_name);
        $exclusion_files[] = $upload_name;
      }
      $exclusionData = [
        'label' => $request->input('exclusion.label'),
        'start_date' => $request->input('exclusion.start_date'),
        'end_date' => $request->input('exclusion.end_date'),
        'pdf' => json_encode($exclusion_files),
      ];
      $machine->exclusion = json_encode($exclusionData);
    }

    if ($request->hasFile('stamping_vc')) {
      foreach ($request->file('stamping_vc') as $file) {
        $upload_name = 'assets/uploads/machine/stamping/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/stamping'), $upload_name);
        $stamping_vc_files[] = $upload_name;
      }
      $machine->stamping_vc = json_encode($stamping_vc_files);
    }

    if ($request->hasFile('brochure')) {
      foreach ($request->file('brochure') as $file) {
        $upload_name = 'assets/uploads/machine/brochure/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/brochure'), $upload_name);
        $brochure_files[] = $upload_name;
      }
      $machine->brochure = json_encode($brochure_files);
    }

    if ($request->hasFile('datasheet')) {
      foreach ($request->file('datasheet') as $file) {
        $upload_name = 'assets/uploads/machine/datasheet/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/datasheet'), $upload_name);
        $datasheet_files[] = $upload_name;
      }
      $machine->datasheet = json_encode($datasheet_files);
    }


    $machine->save();

    return redirect()
      ->back()
      ->with('success', 'Machine saved successfully!');
  }

  public function machineStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = Machine::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = Machine::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function machineEdit($cid, $mid)
  {
    $data = Machine::find($mid);
    // dd($data);
    $client = Client::select('id', 'name')
      ->where('id', $cid)
      ->first();
    $department = PlantDepartment::where('status', 1)
      ->where('id', $data->department_id)
      ->first();
    return view('content.dashboard.machine.machineEdit', compact('data', 'client', 'department'));
  }

  public function machineUpdate(Request $request, $clientId, $machineId)
  {
    $validatedData = $request->validate([
      'client_id' => 'required|integer',
      'department_id' => 'required|integer',
      'machine_type' => 'required|integer',
      'name' => 'required|string|max:255',
      'add_type' => 'required|string|max:255',
      'type' => 'nullable|string',
      'make_model' => 'nullable|string|max:255',
      'offer_details' => 'required|array',
      'po_details' => 'required|array',
      'invoice' => 'required|array',
      'offer_details_file.*' => 'nullable|file|mimes:pdf|max:5120',
      'po_details_file.*' => 'nullable|file|mimes:pdf|max:5120',
      'invoice_file.*' => 'nullable|file|mimes:pdf|max:5120',
      'serial' => 'nullable|string|max:255',
      'platform_size' => 'nullable|string|max:255',
      'platform_max_capacity' => 'nullable|string|max:255',
      'platform_min_capacity' => 'nullable|string|max:255',
      'platform_least_count' => 'nullable|string|max:255',
      'loadcell_modal' => 'nullable|string|max:255',
      'loadcell_type' => 'nullable|string|max:255',
      'loadcell_capacity' => 'nullable|string|max:255',
      'loadcell_serial_no' => 'nullable|string|max:255',
      'system_modal' => 'nullable|string|max:255',
      'system_type' => 'nullable|string|max:255',
      'system_cables' => 'nullable|string|max:255',
      'system_least_count' => 'nullable|string|max:255',
      'jb_modal' => 'nullable|string|max:255',
      'jb_ports' => 'nullable|string|max:255',
      'inclusion' => 'nullable|array',
      'exclusion' => 'nullable|array',
      'inclusionAdditional' => 'nullable|array',
      'exclusionAdditional' => 'nullable|array',
      'additional' => 'nullable|array',
      'specification' => 'nullable|string',
      'description' => 'nullable|string',
      'stamping_vc.*' => 'nullable|file|mimes:pdf|max:5120',
      'brochure.*' => 'nullable|file|mimes:pdf|max:5120',
      'datasheet.*' => 'nullable|file|mimes:pdf|max:5120',
      'product_link' => 'nullable|url',
      'inclusion.pdf.*' => 'nullable|file|mimes:pdf|max:5120',
      'exclusion.pdf.*' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $machine = Machine::findOrFail($machineId);
    $machine->client_id = $request->client_id;
    $machine->department_id = $request->department_id;
    $machine->machine_type = $request->machine_type;
    $machine->name = $request->name;
    $machine->add_type = $request->add_type;
    $machine->type = $request->type;
    $machine->make_model = $request->make_model;
    $machine->offer_details = json_encode($request->offer_details);
    $machine->po_details = json_encode($request->po_details);
    $machine->invoice = json_encode($request->invoice);
    $machine->serial = $request->serial;
    $machine->platform_size = $request->platform_size;
    $machine->platform_max_capacity = $request->platform_max_capacity;
    $machine->platform_min_capacity = $request->platform_min_capacity;
    $machine->platform_least_count = $request->platform_least_count;
    $machine->loadcell_modal = $request->loadcell_modal;
    $machine->loadcell_type = $request->loadcell_type;
    $machine->loadcell_capacity = $request->loadcell_capacity;
    $machine->loadcell_serial_no = $request->loadcell_serial_no;
    $machine->system_modal = $request->system_modal;
    $machine->system_type = $request->system_type;
    $machine->system_cables = $request->system_cables;
    $machine->system_least_count = $request->system_least_count;
    $machine->jb_modal = $request->jb_modal;
    $machine->jb_ports = $request->jb_ports;
    $machine->specification = $request->specification;
    $machine->description = $request->description;
    $machine->product_link = $request->product_link;
    $machine->inclusionAdditional = json_encode($request->inclusionAdditional);
    $machine->exclusionAdditional = json_encode($request->exclusionAdditional);
    $machine->additional = json_encode($request->additional);

    $offer_files = [];
    if ($request->hasFile('offer_details_file')) {
      foreach ($request->file('offer_details_file') as $file) {
        $upload_name = 'assets/uploads/machine/offers/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/offers'), $upload_name);
        $offer_files[] = $upload_name;
      }
      $machine->offer_details_file = json_encode($offer_files);
    }

    $po_files = [];
    if ($request->hasFile('po_details_file')) {
      foreach ($request->file('po_details_file') as $file) {
        $upload_name = 'assets/uploads/machine/pos/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/pos'), $upload_name);
        $po_files[] = $upload_name;
      }
      $machine->po_details_file = json_encode($po_files);
    }

    $invoice_files = [];
    if ($request->hasFile('invoice_file')) {
      foreach ($request->file('invoice_file') as $file) {
        $upload_name = 'assets/uploads/machine/invoices/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/invoices'), $upload_name);
        $invoice_files[] = $upload_name;
      }
      $machine->invoice_file = json_encode($invoice_files);
    }

    if ($request->hasFile('inclusion.pdf')) {
      $inclusion_files = [];
      foreach ($request->file('inclusion.pdf') as $file) {
        $upload_name = 'assets/uploads/machine/inclusion/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/inclusion'), $upload_name);
        $inclusion_files[] = $upload_name;
      }
      $inclusionData = [
        'label' => $request->input('inclusion.label'),
        'start_date' => $request->input('inclusion.start_date'),
        'end_date' => $request->input('inclusion.end_date'),
        'pdf' => json_encode($inclusion_files),
      ];
      $machine->inclusion = json_encode($inclusionData);
    }

    if ($request->hasFile('exclusion.pdf')) {
      $exclusion_files = [];
      foreach ($request->file('exclusion.pdf') as $file) {
        $upload_name = 'assets/uploads/machine/exclusion/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/exclusion'), $upload_name);
        $exclusion_files[] = $upload_name;
      }
      $exclusionData = [
        'label' => $request->input('exclusion.label'),
        'start_date' => $request->input('exclusion.start_date'),
        'end_date' => $request->input('exclusion.end_date'),
        'pdf' => json_encode($exclusion_files),
      ];
      $machine->exclusion = json_encode($exclusionData);
    }

    $stamping_vc_files = [];
    if ($request->hasFile('stamping_vc')) {
      foreach ($request->file('stamping_vc') as $file) {
        $upload_name = 'assets/uploads/machine/stamping/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/stamping'), $upload_name);
        $stamping_vc_files[] = $upload_name;
      }
      $machine->stamping_vc = json_encode($stamping_vc_files);
    }

    $brochure_files = [];
    if ($request->hasFile('brochure')) {
      foreach ($request->file('brochure') as $file) {
        $upload_name = 'assets/uploads/machine/brochure/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/brochure'), $upload_name);
        $brochure_files[] = $upload_name;
      }
      $machine->brochure = json_encode($brochure_files);
    }

    $datasheet_files = [];
    if ($request->hasFile('datasheet')) {
      foreach ($request->file('datasheet') as $file) {
        $upload_name = 'assets/uploads/machine/datasheet/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/machine/datasheet'), $upload_name);
        $datasheet_files[] = $upload_name;
      }
      $machine->datasheet = json_encode($datasheet_files);
    }

    $machine->save();

    return redirect()
      ->back()->with('success', 'Machine updated successfully.');
  }

  public function machineDelete(Request $request)
  {
    $data = Machine::where('id', $request->id)->delete();
    session()->flash('success', 'Machine deleted successfully');
    return true;
  }

  public function clientMachine(Request $request)
  {
    $type = MachineType::where('status', 1)->get();
    $data = Machine::where('plant_id', $request->plant_id)
      ->where('department_id', $request->department_id)
      ->get();
    $client = Client::select('clients.*', 'client_types.name as client_type', 'client_groups.name as client_group')
      ->join('client_types', 'clients.client_type', '=', 'client_types.id')
      ->join('client_groups', 'clients.client_group', '=', 'client_groups.id')
      ->where('clients.id', request()->id)
      ->first();
    $state = State::select('name')
      ->where('id', $client->state)
      ->first();

    $city = City::select('city_name')
      ->where('city_state', $state->name)
      ->where('id', $client->city)
      ->first();

    $plant = Plant::where('client_id', request()->id)
      ->where('status', 1)
      ->get();

    $department = PlantDepartment::where('client_id', request()->id)->get();
    return view(
      'content.dashboard.master.clientView2',
      compact('client', 'plant', 'type', 'data', 'department', 'state', 'city')
    );
  }

  public function departmentMachineFind(Request $request)
  {
    $department = PlantDepartment::where('id', $request->sid)->first();
    $data = Machine::select('id', 'name', 'machine_code', 'machine_model', 'department_id', 'machine_type')
      ->where('department_id', $request->sid)
      ->where('client_id', $department->client_id)
      ->get();
    foreach ($data as $datas) {
      $datas['machine_type'] = MachineType::find($datas->machine_type)->name;
      $datas['department_id'] = PlantDepartment::find($datas->department_id)->name;
    }
    //dd($data);
    return response()->json($data);
  }
}
