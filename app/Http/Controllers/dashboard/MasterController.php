<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ClientType, ClientGroup, MachineType, Designation, Department, Staff, Service, Client, JobTask, Machine, SparePart, JobType};

class MasterController extends Controller
{
  // Job Task start
  public function task(){
    $task = JobTask::all();
    return view('content.dashboard.master.Task.index',compact('task'));
  }

  public function taskCreate(){
    return view('content.dashboard.master.Task.create');
  }

  public function taskSave(Request $request){
    $this->validate($request, [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'subtask_name' => 'nullable|array',
        'subtask_name.*' => 'string',
        'subtask_desc' => 'nullable|array',
        'subtask_desc.*' => 'string',
    ]);

    $subtask_name = $request->subtask_name ?? [];
    $subtask_desc = $request->subtask_desc ?? [];

    $subtask = [];
    foreach($subtask_name as $key => $name){
        $subtask[] = [
            'name' => $name,
            'desc' => $subtask_desc[$key] ?? null
        ];
    }
    $task = new JobTask();
    $task->name = $request->name;
    $task->subtask = json_encode($subtask);
    $task->description = $request->description;
    $task->save();
    if($task->save()){
      return redirect()->route('task')->withSuccess(__('Job Task created successfully'));
    }
  }

  public function taskEdit($id){
    $data = JobTask::find($id);
    return view('content.dashboard.master.Task.edit',compact('data'));
  }

  public function taskUpdate(Request $request,$id){
    $this->validate($request, [
      'name' => 'required|string',
      'description' => 'nullable|string',
      'subtask_name' => 'nullable|array',
      'subtask_name.*' => 'string',
      'subtask_desc' => 'nullable|array',
      'subtask_desc.*' => 'string',
  ]);

    $subtask_name = $request->subtask_name ?? [];
    $subtask_desc = $request->subtask_desc ?? [];

    $subtask = [];
    foreach($subtask_name as $key => $name){
        $subtask[] = [
            'name' => $name,
            'desc' => $subtask_desc[$key] ?? null
        ];
    }

    $task = JobTask::find($id);
    $task->name = $request->name;
    $task->subtask = json_encode($subtask);
    $task->description = $request->description;
    if($task->save()){
      return redirect()->route('task-edit',$id)->withSuccess(__('Job Task updated successfully'));
    }
  }

  public function taskStatus(Request $request){
    if ($request->state == 1) {
      $data = JobTask::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = JobTask::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  // Staff Start
  public function staff()
  {
    $data = Staff::leftJoin('complaints', 'staff.id', '=', 'complaints.assigned_to')
      ->leftJoin('designations', 'staff.position', '=', 'designations.id')
      ->select(
        'staff.id',
        'staff.status',
        'staff.name',
        'designations.name as position',
        DB::raw('count(complaints.id) as complaint_count')
      )
      ->groupBy('staff.id', 'staff.name', 'staff.status', 'staff.position', 'designations.name')
      ->get();
    return view('content.dashboard.master.Staff.index', compact('data'));
  }

  public function staffCreate()
  {
    $data = Designation::where('status', 1)->get();
    return view('content.dashboard.master.Staff.create', compact('data'));
  }

  public function staffSave(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'email' => 'required|email',
      'phone' => 'required|string',
      'position' => 'required|string',
    ]);
    $data = new Staff();
    $data->name = $request->name;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->position = $request->position;
    $data->status = 1;
    $data->save();

    if ($data->save()) {
      session()->flash('success', 'Staff created successfully');
      return redirect()->route('staff');
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }
  public function staffStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = Staff::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = Staff::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function staffEdit(Request $request, $id)
  {
    $designation = Designation::where('status', 1)->get();
    $data = Staff::where('id', $id)->first();
    return view('content.dashboard.master.Staff.edit', compact('data', 'designation'));
  }

  public function staffUpdate(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'email' => 'required|email',
      'phone' => 'required|string',
      'position' => 'required|string',
    ]);
    $data = Staff::where('id', $id)->update([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'position' => $request->position,
    ]);
    session()->flash('success', 'Staff updated successfully');
    return redirect()->back();
  }

  public function staffDelete(Request $request)
  {
    $data = Staff::where('id', $request->id)->delete();
    session()->flash('success', 'Staff deleted successfully');
    return redirect()->route('staff');
  }



  // Machine type start
  public function machineType()
  {
    $data = MachineType::get();
    return view('content.dashboard.master.Machine-type.index', compact('data'));
  }

  public function machineTypeCreate()
  {
    return view('content.dashboard.master.Machine-type.create');
  }

  public function machineTypeSave(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'description' => 'nullable|string'
    ]);
    $data = new MachineType();
    $data->name = $request->name;
    $data->description = $request->description;
    $data->save();

    if ($data->save()) {
      session()->flash('success', 'machine type Type created successfully');
      return redirect()->route('machine-type');
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }
  public function machineTypeStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = MachineType::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = MachineType::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function machineTypeEdit(Request $request, $id)
  {
    $data = MachineType::where('id', $id)->first();
    //dd($data);
    return view('content.dashboard.master.Machine-type.edit', compact('data'));
  }

  public function machineTypeUpdate(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'description' => 'nullable|string'
    ]);
    $data = MachineType::where('id', $id)->update(['name' => $request->name, 'description' => $request->description]);
    session()->flash('success', 'Machine Type created successfully');
    return redirect()->back();
  }

  public function machineTypeDelete(Request $request)
  {
    $data = Machine::where('machine_type', $request->id)->count();
    if ($data == 0) {
      MachineType::where('id', $request->id)->delete();
      session()->flash('success', 'Client Type deleted successfully');
      return true;
    }
    session()->flash('error', 'This item is used in machine module');
    return false;
  }

  // Spare Parts
  public function spareParts()
  {
    $data = SparePart::all();
    return view('content.dashboard.master.Spare-parts.index', compact('data'));
  }

  public function sparePartsCreate()
  {
    return view('content.dashboard.master.Spare-parts.create');
  }

  public function sparePartsSave(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'serial_no' => 'required|string|unique:spare_parts',
      'description' => 'nullable|string'
    ]);

    $data = new SparePart();
    $data->name = $request->name;
    $data->serial_no = $request->serial_no;
    $data->description = $request->description;

    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $uploadName = 'assets/uploads/spare_parts/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/uploads/spare_parts'), $uploadName);
      $data->image = $uploadName;
    }

    if ($data->save()) {
      session()->flash('success', 'Spare part created successfully');
      return redirect()->route('spare-parts');
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }

  public function sparePartsStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = SparePart::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = SparePart::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function sparePartsEdit($id)
  {
    $data = SparePart::findOrFail($id);
    return view('content.dashboard.master.Spare-parts.edit', compact('data'));
  }

  public function sparePartsUpdate(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'serial_no' => 'required|string|unique:spare_parts,serial_no,' . $id,
      'description' => 'nullable|string'
    ]);

    $data = SparePart::findOrFail($id);
    $data->name = $request->name;
    $data->serial_no = $request->serial_no;
    $data->description = $request->description;

    if ($request->hasFile('image')) {
      if ($data->image && file_exists(public_path($data->image))) {
        unlink(public_path($data->image));
      }

      $file = $request->file('image');
      $uploadName = 'assets/uploads/spare_parts/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/uploads/spare_parts'), $uploadName);
      $data->image = $uploadName;
    }

    $data->save();

    session()->flash('success', 'Spare part updated successfully');
    return redirect()->route('spare-parts');
  }

  public function sparePartsDelete(Request $request)
  {
    SparePart::where('id', $request->id)->delete();
      session()->flash('success', 'Spare parts deleted successfully');
      return true;
  }

    // Job Type
    public function jobType()
    {
      $data = JobType::all();
      return view('content.dashboard.master.jobType', compact('data'));
    }

    public function jobTypeCreate()
    {
      return view('content.dashboard.master.jobTypeCreate');
    }

    public function jobTypeSave(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|string',
        'description' => 'nullable|string'
      ]);

      $data = new JobType();
      $data->name = $request->name;
      $data->description = $request->description;

      if ($data->save()) {
        session()->flash('success', 'Job type created successfully');
        return redirect()->route('job-type');
      } else {
        session()->flash('error', 'Invalid Data');
        return redirect()->back();
      }
    }

    public function jobTypeStatus(Request $request)
    {
      if ($request->state == 1) {
        $data = JobType::where('id', $request->id)->update(['status' => 0]);
        return true;
      } else {
        $data = JobType::where('id', $request->id)->update(['status' => 1]);
        return true;
      }
    }

    public function jobTypeEdit($id)
    {
      $data = JobType::findOrFail($id);
      return view('content.dashboard.master.jobTypeEdit', compact('data'));
    }

    public function jobTypeUpdate(Request $request, $id)
    {
      $this->validate($request, [
        'name' => 'required|string',
        'description' => 'nullable|string'
      ]);

      $data = JobType::findOrFail($id);
      $data->name = $request->name;
      $data->description = $request->description;

      $data->save();

      session()->flash('success', 'Job type updated successfully');
      return redirect()->route('job-type');
    }

    public function jobTypeDelete(Request $request)
    {
      JobType::where('id', $request->id)->delete();
        session()->flash('success', 'Job types deleted successfully');
        return true;
    }
}
