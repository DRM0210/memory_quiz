<?php

namespace App\Http\Controllers\dashboard;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
  ClientType,
  ClientGroup,
  Category,
  SubCategory,
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
  ClientJob,
  ClientMachine,
  job
};

class ClientController extends Controller
{
  // Client Start
  public function clientDraft()
  {
    $data = Client::where('status', 0)->get();
    return view('content.dashboard.client.draft', compact('data'));
  }

  public function client()
  {
    $data = Client::where('parent_id', '=', null)->where('status', 1)->get();
    $draft = Client::where('status', 0)->count();
    return view('content.dashboard.client.index', compact('data', 'draft'));
  }

  public function clientLocation(Request $request)
  {
    //dd($request->all());
    $state = State::select('name')
      ->where('id', $request->a_state)
      ->first();

    $city = City::select('city_name')
      ->where('city_state', $state->name)
      ->where('id', $request->a_city)
      ->first();

    $data = new CLientAddress;
    $data->name = $request->a_name;
    $data->client_id = $request->client_id;
    $data->address = json_encode([
      'address1' => $request->a_address1,
      'address2' => $request->a_address2,
      'state' => $state->name,
      'city' => $city->city_name,
      'pincode' => $request->a_pincode
    ]);

    if ($data->save()) {
      $data1 = ClientAddress::select('id', 'name', 'address', 'client_id')->where('client_id', $request->client_id)->get();
      foreach ($data1 as $item) {
        $var = json_decode($item->address);
        $item['address'] = $var->address1 . ', ' . $var->address2 . ', ' . $var->city . ', ' . $var->state . ', ' . $var->pincode;
      }

      return response()->json([
        'status' => true,
        'message' => 'Address added successfully !',
        'data' => $data1
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Something went wrong !'
      ]);
    }
  }

  public function clientLocationDelete(Request $request, $id)
  {
    ClientAddress::where('id', $request->id)->where('client_id', $request->cid)->delete();
    $data = ClientAddress::select('id', 'name', 'address', 'client_id')->where('client_id', $request->cid)->get();

    foreach ($data as $item) {
      $var = json_decode($item->address);
      $item['address'] = $var->address1 . ', ' . $var->address2 . ', ' . $var->city . ', ' . $var->state . ', ' . $var->pincode;
    }
    return response()->json([
      'status' => true,
      'message' => 'Address deleted successfully !',
      'data' => $data
    ]);
  }

  public function clientView($id)
  {
    $job = job::where('status', 1)->get();
    $clientjobs = ClientJob::where('status', 1)->get();
    $type = MachineType::where('status', 1)->get();
    // dd($type);
    $data = Machine::join('plant_departments', 'client_machines.department_id', '=', 'plant_departments.id')
      ->where('client_machines.client_id', request()->id)
      ->select('client_machines.*', 'plant_departments.name as department_name')
      ->get();
    $contact = ClientContact::select('email', 'phone', 'service_address', 'billing_address')
      ->where('client_id', request()->id)
      ->first();

    $client = Client::select('clients.*', 'client_types.name as client_type')
      ->join('client_types', 'clients.client_type', '=', 'client_types.id')
      ->where('clients.id', request()->id)
      ->first();
    // dd($client);
    $stateModal = State::select('id', 'name')
      ->where('status', 1)
      ->get();

    $plant = Client::where('parent_id', request()->id)->where('status', 1)->get();
    $department = PlantDepartment::where('client_id', request()->id)->get();
    $clientAddress = ClientAddress::where('client_id', $id)->get();

    return view(
      'content.dashboard.client.view2',
      compact('client', 'plant', 'type', 'data', 'department', 'contact', 'stateModal', 'clientAddress', 'job', 'clientjobs')
    );
  }

  public function searchDept(Request $request, $cid, $mtype)
  {
    $data = $request->input('data');
    $departments = PlantDepartment::where('client_id', $cid)
      ->where('name', 'like', '%' . $data . '%')
      ->get();

    $result = [];

    foreach ($departments as $department) {
      $machines = \App\Models\Machine::where('client_id', $cid)
        ->where('department_id', $department->id)
        ->where('machine_type', $mtype)
        ->get();

      $machineDetails = $machines->map(function ($machine) {
        return [
          'name' => $machine->name,
          'machine_type' => $machine->machine_type,
          'make_model' => $machine->make . ' ' . $machine->model
        ];
      });

      $result[] = [
        'department' => $department->name,
        'machine_count' => $machines->count(),
        'machines' => $machineDetails
      ];
    }
    dd($result);

    return response()->json($result);
  }



  public function clientContact($id)
  {
    $data = ClientContact::where('client_id', $id)->get();
    $department = Department::where('status', 1)->get();
    $designation = Designation::where('status', 1)->get();
    return view('content.dashboard.client.contact', compact('data', 'designation', 'department'));
  }

  public function childClientCreate($id)
  {
    $client_type = ClientType::where('status', 1)->get();
    $client_group = ClientGroup::where('status', 1)->get();
    $designation = Designation::where('status', 1)->get();
    $category = Category::where('status', 1)->get();
    $subcategory = SubCategory::where('status', 1)->get();
    $state = State::select('id', 'name')
      ->where('status', 1)
      ->get();
    return view(
      'content.dashboard.client.child',
      compact('client_type', 'client_group', 'designation', 'state', 'category', 'subcategory')
    );
  }

  public function clientContactUpdate(Request $request, $id)
  {
    $this->validate($request, [
      'contact_person' => 'required',
      'phone' => 'required|string',
      'mobile' => 'required|string',
      'email' => 'required|email',
      'designation' => 'required|string',
      'department' => 'required|string',
    ]);
    $data = [
      'contact_person' => $request->contact_person,
      'phone' => $request->phone,
      'mobile' => $request->mobile,
      'email' => $request->email,
      'designation' => $request->designation,
      'department' => $request->department,
    ];
    ClientContact::where('id', $id)->update($data);
    session()->flash('success', 'Contact Detail updated successfully');
    return redirect()->back();
  }

  public function getSubcategories(Request $request)
  {
    $subcategories = SubCategory::where('category_id', $request->category_id)
      ->where('status', 1)
      ->select('id', 'name')
      ->get();

    return response()->json(['subcategories' => $subcategories]);
  }

  public function clientCreate()
  {
    $client_type = ClientType::where('status', 1)->get();
    $category = Category::where('status', 1)->get();
    $subcategory = SubCategory::where('status', 1)->get();
    $designation = Designation::where('status', 1)->get();
    $department = Department::where('status', 1)->get();
    $state = State::select('id', 'name')
      ->where('status', 1)
      ->get();
    return view(
      'content.dashboard.client.create',
      compact('client_type', 'category', 'subcategory', 'designation', 'state', 'department')
    );
  }

  public function getCity(Request $request)
  {
    $state = State::select('name')
      ->where('id', $request->sid)
      ->first();

    $data = City::select('id', 'city_name')
      ->where('status', 1)
      ->where('city_state', $state->name)
      ->get();
    return response()->json($data);
  }

  public function childClientSave(Request $request, $id)
  {
    if (!isset($request->draft)) {
      $this->validate($request, [
        'name' => 'required|string',
        'category_id' => 'nullable|exists:categories,id',
        'subcategory_id' => 'nullable|exists:sub_categories,id',
        'client_type' => 'required',
        'client_reference' => 'required',
        'b_country' => 'required|string',
        'b_state' => 'required|string',
        'b_city' => 'required|string',
        'b_pincode' => 'required|numeric',
        'b_address1' => 'required|string',
        'b_address2' => 'required|string',

        // multiple billing contact rows
        'contact_person' => 'required|array',
        'contact_person.*' => 'required|string',
        'email' => 'nullable|array',
        'email.*' => 'nullable|email',
        'phone' => 'nullable|array',
        'phone.*' => 'nullable|string',
        'mobile' => 'nullable|array',
        'mobile.*' => 'nullable|string',
        'designation' => 'nullable|array',
        'designation.*' => 'nullable',
        'department' => 'nullable|array',
        'department.*' => 'nullable'
      ]);
    }

    $data = new Client();
    $data->name = $request->name;
    $data->parent_id = $id;
    $data->category_id = $request->category_id ?? null;
    $data->subcategory_id = $request->subcategory_id ?? null;
    $data->client_code = $this->generate_client_code();
    $data->client_type = $request->client_type;
    $data->client_reference = $request->client_reference;

    $data->iec_no = $request->iec_no;
    $data->cin_no = $request->cin_no;
    $data->msme_no = $request->msme_no;
    $data->pancard_no = $request->pancard_no;
    $data->gst_no = $request->gst_no;
    $data->status = isset($request->draft) ? 0 : 1;

    // upload files
    $uploadPath = public_path('assets/uploads/client');
    if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

    $fileFields = ['client_cin', 'client_iec', 'msme', 'pancard', 'gst', 'certification'];
    foreach ($fileFields as $field) {
      if ($request->hasFile($field)) {
        $file = $request->file($field);
        $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);
        $data->$field = 'assets/uploads/client/' . $filename;
      }
    }

    // state/city names
    $stateBilling = State::find($request->b_state);
    $cityBilling = City::find($request->b_city);
    $stateService = State::find($request->s_state);
    $cityService = City::find($request->s_city);

    // ---------------------------------------------
    // 🔥 BUILD MULTIPLE BILLING CONTACT ROWS
    // ---------------------------------------------
    $billingContacts = [];
    $cp = $request->input('contact_person', []);
    $email = $request->input('email', []);
    $phone = $request->input('phone', []);
    $mobile = $request->input('mobile', []);
    $designation = $request->input('designation', []);
    $department = $request->input('department', []);

    foreach ($cp as $i => $person) {
      if (!filled($person)) continue;
      $billingContacts[] = [
        'contact_person' => $person,
        'email' => $email[$i] ?? '',
        'phone' => $phone[$i] ?? '',
        'mobile' => $mobile[$i] ?? '',
        'designation' => $designation[$i] ?? '',
        'department' => $department[$i] ?? '',
      ];
    }

    // ---------------------------------------------------------
    // 🔥 BUILD MULTIPLE SERVICE CONTACT ROWS (makesame support)
    // ---------------------------------------------------------
    // dd($request->all());
    if ($request->makesame == 1) {
      $serviceContacts = $billingContacts;
    } else {
      $serviceContacts = [];
      $scp = $request->input('s_contact_person', []);
      $sem = $request->input('s_email', []);
      $sph = $request->input('s_phone', []);
      $smob = $request->input('s_mobile', []);
      $sdes = $request->input('s_designation', []);
      $sdept = $request->input('s_department', []);

      foreach ($scp as $i => $person) {
        if (!filled($person)) continue;
        $serviceContacts[] = [
          'contact_person' => $person,
          'email' => $sem[$i] ?? '',
          'phone' => $sph[$i] ?? '',
          'mobile' => $smob[$i] ?? '',
          'designation' => $sdes[$i] ?? '',
          'department' => $sdept[$i] ?? '',
        ];
      }
    }

    // ------------------------------------------------
    // 🔥 SAVE BILLING ADDRESS (MULTIPLE CONTACTS)
    // ------------------------------------------------
    $data->billing_address = json_encode([
      'address1' => $request->b_address1 ?? '',
      'address2' => $request->b_address2 ?? '',
      'country' => $request->b_country ?? '',
      'state' => $stateBilling->name ?? '',
      'city' => $cityBilling->city_name ?? '',
      'pincode' => $request->b_pincode ?? '',
      'contacts' => $billingContacts
    ]);

    // ------------------------------------------------
    // 🔥 SAVE SERVICE/SHIPPING ADDRESS (MULTIPLE CONTACTS)
    // ------------------------------------------------
    $data->service_address = json_encode([
      'address1' => $request->makesame ? $request->b_address1 : ($request->s_address1 ?? ''),
      'address2' => $request->makesame ? $request->b_address2 : ($request->s_address2 ?? ''),
      'country' => $request->makesame ? $request->b_country : ($request->s_country ?? ''),
      'state' => $request->makesame ? ($stateBilling->name ?? '') : ($stateService->name ?? ''),
      'city' => $request->makesame ? ($cityBilling->city_name ?? '') : ($cityService->city_name ?? ''),
      'pincode' => $request->makesame ? $request->b_pincode : ($request->s_pincode ?? ''),
      'contacts' => $serviceContacts
    ]);
    // dd($data);
    // save client
    if ($data->save()) {

      session()->flash('success', isset($request->draft)
        ? 'Client saved as draft'
        : 'Client created successfully');

      return isset($request->draft)
        ? redirect()->route('client')
        : redirect()->route('client-view', $data->id);
    }

    session()->flash('error', 'Failed to save client');
    return redirect()->back();
  }


  public function clientSave(Request $request)
  {
    // dd($request->all());

    if (!isset($request->draft)) {
      $this->validate($request, [
        'name' => 'required|string',
        'category_id' => 'nullable|exists:categories,id',
        'subcategory_id' => 'nullable|exists:sub_categories,id',
        'client_type' => 'required',
        'client_reference' => 'required',
        'b_country' => 'required|string',
        'b_state' => 'required|string',
        'b_city' => 'required|string',
        'b_pincode' => 'required|numeric',
        'b_address1' => 'required|string',
        'b_address2' => 'required|string',

        // multiple billing contact rows
        'contact_person' => 'required|array',
        'contact_person.*' => 'required|string',
        'email' => 'nullable|array',
        'email.*' => 'nullable|email',
        'phone' => 'nullable|array',
        'phone.*' => 'nullable|string',
        'mobile' => 'nullable|array',
        'mobile.*' => 'nullable|string',
        'designation' => 'nullable|array',
        'designation.*' => 'nullable',
        'department' => 'nullable|array',
        'department.*' => 'nullable'
      ]);
    }

    $data = new Client();
    $data->name = $request->name;
    $data->category_id = $request->category_id ?? null;
    $data->subcategory_id = $request->subcategory_id ?? null;
    $data->client_code = $this->generate_client_code();
    $data->client_type = $request->client_type;
    $data->client_reference = $request->client_reference;

    $data->iec_no = $request->iec_no;
    $data->cin_no = $request->cin_no;
    $data->msme_no = $request->msme_no;
    $data->pancard_no = $request->pancard_no;
    $data->gst_no = $request->gst_no;
    $data->status = isset($request->draft) ? 0 : 1;

    // upload files
    $uploadPath = public_path('assets/uploads/client');
    if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

    $fileFields = ['client_cin', 'client_iec', 'msme', 'pancard', 'gst', 'certification'];
    foreach ($fileFields as $field) {
      if ($request->hasFile($field)) {
        $file = $request->file($field);
        $filename = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);
        $data->$field = 'assets/uploads/client/' . $filename;
      }
    }

    // state/city names
    $stateBilling = State::find($request->b_state);
    $cityBilling = City::find($request->b_city);
    $stateService = State::find($request->s_state);
    $cityService = City::find($request->s_city);

    // ---------------------------------------------
    // 🔥 BUILD MULTIPLE BILLING CONTACT ROWS
    // ---------------------------------------------
    $billingContacts = [];
    $cp = $request->input('contact_person', []);
    $email = $request->input('email', []);
    $phone = $request->input('phone', []);
    $mobile = $request->input('mobile', []);
    $designation = $request->input('designation', []);
    $department = $request->input('department', []);

    foreach ($cp as $i => $person) {
      if (!filled($person)) continue;
      $billingContacts[] = [
        'contact_person' => $person,
        'email' => $email[$i] ?? '',
        'phone' => $phone[$i] ?? '',
        'mobile' => $mobile[$i] ?? '',
        'designation' => $designation[$i] ?? '',
        'department' => $department[$i] ?? '',
      ];
    }

    // ---------------------------------------------------------
    // 🔥 BUILD MULTIPLE SERVICE CONTACT ROWS (makesame support)
    // ---------------------------------------------------------
    // dd($request->all());
    if ($request->makesame == 1) {
      $serviceContacts = $billingContacts;
    } else {
      $serviceContacts = [];
      $scp = $request->input('s_contact_person', []);
      $sem = $request->input('s_email', []);
      $sph = $request->input('s_phone', []);
      $smob = $request->input('s_mobile', []);
      $sdes = $request->input('s_designation', []);
      $sdept = $request->input('s_department', []);

      foreach ($scp as $i => $person) {
        if (!filled($person)) continue;
        $serviceContacts[] = [
          'contact_person' => $person,
          'email' => $sem[$i] ?? '',
          'phone' => $sph[$i] ?? '',
          'mobile' => $smob[$i] ?? '',
          'designation' => $sdes[$i] ?? '',
          'department' => $sdept[$i] ?? '',
        ];
      }
    }

    // ------------------------------------------------
    // 🔥 SAVE BILLING ADDRESS (MULTIPLE CONTACTS)
    // ------------------------------------------------
    $data->billing_address = json_encode([
      'address1' => $request->b_address1 ?? '',
      'address2' => $request->b_address2 ?? '',
      'country' => $request->b_country ?? '',
      'state' => $stateBilling->name ?? '',
      'city' => $cityBilling->city_name ?? '',
      'pincode' => $request->b_pincode ?? '',
      'contacts' => $billingContacts
    ]);

    // ------------------------------------------------
    // 🔥 SAVE SERVICE/SHIPPING ADDRESS (MULTIPLE CONTACTS)
    // ------------------------------------------------
    $data->service_address = json_encode([
      'address1' => $request->makesame ? $request->b_address1 : ($request->s_address1 ?? ''),
      'address2' => $request->makesame ? $request->b_address2 : ($request->s_address2 ?? ''),
      'country' => $request->makesame ? $request->b_country : ($request->s_country ?? ''),
      'state' => $request->makesame ? ($stateBilling->name ?? '') : ($stateService->name ?? ''),
      'city' => $request->makesame ? ($cityBilling->city_name ?? '') : ($cityService->city_name ?? ''),
      'pincode' => $request->makesame ? $request->b_pincode : ($request->s_pincode ?? ''),
      'contacts' => $serviceContacts
    ]);
    // dd($data);
    // save client
    if ($data->save()) {

      session()->flash('success', isset($request->draft)
        ? 'Client saved as draft'
        : 'Client created successfully');

      return isset($request->draft)
        ? redirect()->route('client')
        : redirect()->route('client-view', $data->id);
    }

    session()->flash('error', 'Failed to save client');
    return redirect()->back();
  }




  public function generate_client_code()
  {
    $latestClient = Client::max('id');

    if ($latestClient) {
      $stringClientCode = (int) $latestClient;
      $newClientCode = sprintf('%04d', $stringClientCode + 1);
      return $newClientCode;
    } else {
      return '0001';
    }
  }

  public function clientUpdate(Request $request, $id)
  {
    if (!isset($request->draft)) {
      $this->validate($request, [
        'name' => 'required',
        'category_id' => 'nullable|exists:categories,id',
        'subcategory_id' => 'nullable|exists:sub_categories,id',
        'client_type' => 'required',
        'client_reference' => 'required',

        'b_country' => 'required',
        'b_state' => 'required',
        'b_city' => 'required',
        'b_pincode' => 'required|numeric',
        'b_address1' => 'required',
        'b_address2' => 'required',

        'contact_person' => 'required|array',
      ]);
    }
    // dd($request->all());
    $client = Client::findOrFail($id);

    // --- STATE / CITY NAMES ---
    $stateBilling = State::find($request->b_state);
    $cityBilling  = City::find($request->b_city);

    $stateService = State::find($request->s_state);
    $cityService  = City::find($request->s_city);

    // ---------------------------------------------
    // 🔥 BILLING CONTACTS (MULTIPLE)
    // ---------------------------------------------
    $billingContacts = [];
    foreach ($request->contact_person as $i => $p) {
      if (!filled($p)) continue;

      $billingContacts[] = [
        'contact_person' => $p,
        'email'          => $request->email[$i] ?? '',
        'phone'          => $request->phone[$i] ?? '',
        'mobile'         => $request->mobile[$i] ?? '',
        'designation'    => $request->designation[$i] ?? '',
        'department'     => $request->department[$i] ?? '',
      ];
    }

    // ---------------------------------------------
    // 🔥 SERVICE CONTACTS (COPY if makesame == 1)
    // ---------------------------------------------
    // dd($request->s_contact_person);
    if ($request->makesame == 1 && $request->makesame != null) {
      $serviceContacts = $billingContacts;
    } else {
      $serviceContacts = [];

      foreach ($request->s_contact_person as $i => $p) {
        if (!filled($p)) continue;

        $serviceContacts[] = [
          'contact_person' => $p,
          'email'          => $request->s_email[$i] ?? '',
          'phone'          => $request->s_phone[$i] ?? '',
          'mobile'         => $request->s_mobile[$i] ?? '',
          'designation'    => $request->s_designation[$i] ?? '',
          'department'     => $request->s_department[$i] ?? '',
        ];
      }
    }
    // dd($serviceContacts);
    // ---------------------------------------------
    // 🔥 BUILD BILLING ADDRESS JSON
    // ---------------------------------------------
    $billing_address = [
      'address1' => $request->b_address1,
      'address2' => $request->b_address2,
      'country'  => $request->b_country,
      'state'    => $stateBilling->name ?? '',
      'city'     => $cityBilling->city_name ?? '',
      'pincode'  => $request->b_pincode,
      'contacts' => $billingContacts
    ];

    // ---------------------------------------------
    // 🔥 BUILD SERVICE ADDRESS JSON
    // ---------------------------------------------
    if ($request->makesame == 1) {

      $service_address = $billing_address; // direct copy (address + contacts)

    } else {
      $service_address = [
        'address1' => $request->s_address1 ?? '',
        'address2' => $request->s_address2 ?? '',
        'country'  => $request->s_country ?? '',
        'state'    => $stateService->name ?? '',
        'city'     => $cityService->city_name ?? '',
        'pincode'  => $request->s_pincode ?? '',
        'contacts' => $serviceContacts,
      ];
    }

    // ---------------------------------------------
    // 🔥 FINAL UPDATE ARRAY
    // ---------------------------------------------
    $updateData = [
      'name'             => $request->name,
      'category_id'      => $request->category_id,
      'subcategory_id'   => $request->subcategory_id,
      'client_type'      => $request->client_type,
      'client_reference' => $request->client_reference,

      'billing_address'  => json_encode($billing_address),
      'service_address'  => json_encode($service_address),

      'iec_no'           => $request->iec_no,
      'cin_no'           => $request->cin_no,
      'msme_no'          => $request->msme_no,
      'pancard_no'       => $request->pancard_no,
      'gst_no'           => $request->gst_no,

      'status'           => isset($request->draft) ? 0 : 1,
    ];
    // dd($updateData);
    $client->update($updateData);

    return redirect()->route('client-view', $id)
      ->with('success', 'Client updated successfully');
  }




  public function clientStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = Client::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = Client::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function clientEdit($id)
  {
    $client = Client::where('id', $id)->first();
    $designation = Designation::where('status', 1)->get();
    $contact = ClientContact::where('client_id', $id)->get();
    $clientAddress = ClientAddress::where('client_id', $id)->get();
    $client_type = ClientType::where('status', 1)->get();
    $category = Category::where('status', 1)->get();
    $subcategory = SubCategory::where('status', 1)->get();
    $department = Department::where('status', 1)->get();
    $state = State::select('id', 'name')
      ->where('status', 1)
      ->get();

    $state1 = State::select('name')
      ->where('status', 1)
      ->first();

    $city = City::select('id', 'city_name')
      ->where('status', 1)
      ->get();
    return view(
      'content.dashboard.client.edit',
      compact('client_type', 'category', 'subcategory', 'client', 'designation', 'contact', 'state', 'city', 'department', 'clientAddress')
    );
  }

  public function clientDelete(Request $request)
  {
    $data = Complaint::select('id')
      ->where('client_id', $request->id)
      ->count();

    if ($data == 0) {
      Client::where('id', $request->id)->delete();
      Client::where('parent_id', $request->id)->delete();
      PlantDepartment::where('client_id', $request->id)->delete();
      Machine::where('client_id', $request->id)->delete();

      session()->flash('success', 'Client deleted successfully');
      return true;
    }
    session()->flash('error', 'First clear complain of this client');
    return false;
  }

  // Plant start
  public function plant()
  {
    $data = Plant::where('client_id', request()->id)->get();
    return view('content.dashboard.master.plant', compact('data'));
  }

  public function plantCreate($id)
  {
    $data = Designation::where('status', 1)->get();
    return view('content.dashboard.master.plantCreate', compact('id', 'data'));
  }

  public function plantSave(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'contact_person' => 'required|string',
      'email' => 'required|string|email',
      'phone' => 'required|string',
      'mobile' => 'required|string',
      'designation' => 'required|string',
      'department' => 'required|string',
      'address' => 'required|string',
      'description' => 'nullable|string',
    ]);
    $data = new Plant();
    $data->name = $request->name;
    $data->contact_person = $request->contact_person;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->mobile = $request->mobile;
    $data->designation = $request->designation;
    $data->department = $request->department;
    $data->client_id = request()->id;
    $data->address = $request->address;
    $data->description = $request->description;
    $data->save();

    PlantDepartment::create([
      'name' => 'General',
      'description' => 'General',
      'client_id' => request()->id,
      'plant_id' => $data->id,
    ]);
    session()->flash('success', 'Plant created successfully');
    return redirect()->route('plant', request()->id);
  }

  public function plantStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = Plant::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = Plant::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function plantEdit(Request $request, $id)
  {
    $data = Plant::where('id', request()->id1)->first();
    $data1 = Designation::where('status', 1)->get();
    return view('content.dashboard.master.plantEdit', compact('data', 'data1'));
  }

  public function plantUpdate(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'contact_person' => 'required|string',
      'email' => 'required|string|email',
      'phone' => 'required|string',
      'mobile' => 'required|string',
      'designation' => 'required|string',
      'department' => 'required|string',
      'address' => 'required|string',
      'description' => 'nullable|string',
    ]);

    $data = [
      'name' => $request->name,
      'contact_person' => $request->contact_person,
      'email' => $request->email,
      'phone' => $request->phone,
      'mobile' => $request->mobile,
      'designation' => $request->designation,
      'department' => $request->department,
      'address' => $request->address,
      'description' => $request->description,
    ];
    //dd(request()->client_id);
    Plant::where('id', $id)->update($data);
    session()->flash('success', 'Plant updated successfully');
    return redirect()->route('plant', request()->client_id);
  }

  public function plantDelete(Request $request)
  {
    $data = Plant::where('id', $request->id)->delete();
    session()->flash('success', 'Plant deleted successfully');
    return redirect()->route('plant', request()->id);
  }

  // Department start
  public function department()
  {
    $data = PlantDepartment::where('client_id', request()->id)->get();
    return view('content.dashboard.master.department', compact('data'));
  }

  public function clientDepartment(Request $request)
  {
    $data = PlantDepartment::select('id', 'name')
      ->where('client_id', $request->pid)
      ->get();
    return response()->json($data);
  }

  public function departmentCreate()
  {
    $data = Plant::where('client_id', request()->id)->get();
    return view('content.dashboard.master.departmentCreate', compact('data'));
  }

  public function departmentSave(Request $request)
  {
    //dd($request->all());
    $this->validate($request, [
      'name' => 'required|string',
    ]);
    $data = new PlantDepartment();
    $data->name = $request->name;
    $data->client_id = request()->id;
    $data->plant_id = 0;
    $data->description = $request->description != null ? $request->description : '';
    $data->save();
    if ($data->save()) {
      session()->flash('success', 'Department created successfully');
      return redirect()->route('department', request()->id);
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }

  public function departmentStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = PlantDepartment::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = PlantDepartment::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function departmentEdit(Request $request, $id)
  {
    $data = PlantDepartment::where('id', request()->id1)->first();
    $plant = Plant::where('client_id', request()->id)->get();
    return view('content.dashboard.master.departmentEdit', compact('data', 'plant'));
  }

  public function departmentUpdate(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);
    $data = PlantDepartment::where('id', request()->id1)->update([
      'name' => $request->name,
      'description' => $request->description,
    ]);
    session()->flash('success', 'Department updated successfully');
    return redirect()->route('department', request()->id);
  }

  public function departmentDelete(Request $request)
  {
    $data = PlantDepartment::where('id', $request->id)->delete();
    session()->flash('success', 'Department deleted successfully');
    return true;
  }

  // Machine start

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

    $plant = Plant::where('client_id', request()->id)->where('status', 1)->get();

    $department = PlantDepartment::where('client_id', request()->id)->get();
    return view(
      'content.dashboard.master.clientView2',
      compact('client', 'plant', 'type', 'data', 'department', 'state', 'city')
    );
  }

  // Client Job

  public function clientJob($id)
  {
    $clientjobs = ClientJob::where('client_id', $id)->where('status', 1)->get();

    return view('content.dashboard.client-job.index', compact('clientjobs', 'id'));
  }

  public function clientJobCreate($id)
  {
    $client = Client::find($id);
    $machines = Machine::where('client_id', $id)->get();

    return view('content.dashboard.client-job.create', compact('machines', 'client', 'id'));
  }

  public function clientJobSave(Request $request)
  {
    $request->validate([
      'client_id' => 'required|exists:clients,id',
      'machine_id' => 'required|exists:machines,id',
      'complaint_no' => 'required|unique:client_jobs',
      'complaint_date' => 'required|date',
      'caller_name' => 'required|string',
      'caller_contact' => 'required|string',
      'caller_type' => 'nullable|string',
      'call_for' => 'nullable|string',
      'call_description' => 'nullable|string',
      'call_tasks_list' => 'nullable|string',
      'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,doc',
    ]);

    $attachmentPath = null;
    if ($request->hasFile('attachments')) {
      $file = $request->file('attachments');
      $upload_name = 'assets/uploads/client/' . uniqid() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/uploads/client'), $upload_name);
      $attachmentPath = $upload_name;
    }

    $clientJob = new ClientJob();
    $clientJob->client_id = $request->client_id;
    $clientJob->machine_id = $request->machine_id;
    $clientJob->complaint_no = $request->complaint_no;
    $clientJob->complaint_date = $request->complaint_date;
    $clientJob->caller_name = $request->caller_name;
    $clientJob->caller_contact = $request->caller_contact;
    $clientJob->caller_type = $request->caller_type;
    $clientJob->call_for = $request->call_for;
    $clientJob->call_description = $request->call_description;
    $clientJob->call_tasks_list = $request->call_tasks_list;
    $clientJob->attachments = $attachmentPath;
    $clientJob->status = 1;
    $clientJob->save();

    return redirect()->route('client.job.create', $request->client_id)
      ->with('success', 'Job created successfully.');
  }

  public function clientJobEdit($id)
  {
    $job = ClientJob::findOrFail($id);
    $machines = Machine::where('client_id', $job->client_id)->get();
    $client = Client::findOrFail($job->client_id);

    return view('content.dashboard.client-job.edit', compact('job', 'machines', 'client'));
  }

  public function clientJobUpdate(Request $request, $id)
  {
    $job = ClientJob::findOrFail($id);

    $request->validate([
      'machine_id' => 'required|exists:machines,id',
      'caller_name' => 'required|string',
      'caller_contact' => 'required|string',
      'caller_type' => 'nullable|string',
      'call_for' => 'nullable|string',
      'call_description' => 'nullable|string',
      'call_tasks_list' => 'nullable|string',
      'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,doc',
    ]);

    if ($request->hasFile('attachments')) {
      if ($job->attachments && file_exists(public_path($job->attachments))) {
        unlink(public_path($job->attachments));
      }

      $file = $request->file('attachments');
      $upload_name = 'assets/uploads/client/' . uniqid() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/uploads/client'), $upload_name);
      $job->attachments = $upload_name;
    }

    $job->update([
      'machine_id' => $request->machine_id,
      'caller_name' => $request->caller_name,
      'caller_contact' => $request->caller_contact,
      'caller_type' => $request->caller_type,
      'call_for' => $request->call_for,
      'call_description' => $request->call_description,
      'call_tasks_list' => $request->call_tasks_list,
    ]);

    return redirect()->route('client.job.edit', $job->id)
      ->with('success', 'Job updated successfully.');
  }

  public function clientMachineInfo($machine_id)
  {
    $machine = Machine::find($machine_id);

    if ($machine) {
      return response()->json($machine->only([
        'name',
        'make_model',
        'type',
        'serial',
        'platform_size',
        'platform_max_capacity',
        'platform_min_capacity',
        'platform_least_count',
        'loadcell_modal',
        'loadcell_type',
        'loadcell_capacity',
        'loadcell_serial_no',
        'system_modal',
        'system_type',
        'system_cables',
        'system_least_count',
        'jb_modal',
        'jb_ports'
      ]));
    }

    return response()->json(['error' => 'Machine not found'], 404);
  }

  public function clientJobDelete(Request $request)
  {
    $job = ClientJob::find($request->id);
    if (!$job) {
      return response()->json(['error' => 'Job not found'], 404);
    }
    $job->delete();
    return response()->json(['success' => 'Job deleted successfully']);
  }

  public function clientBulk()
  {
    return view('content.dashboard.client.bulk');
  }

  public function clientBulkStore(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:csv,xlsx,xls'
    ]);

    try {
      Excel::import(new ClientImport, $request->file('file'));
      return redirect()->route('client')->with('success', 'Clients imported successfully!');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
    }
  }
}
