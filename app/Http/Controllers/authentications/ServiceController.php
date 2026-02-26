<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Service};

class ServiceController extends Controller
{
  // service start
  public function service()
  {
    $data = Service::get();
    return view('content.dashboard.master.service', compact('data'));
  }

  public function serviceCreate()
  {
    return view('content.dashboard.master.serviceCreate');
  }

  public function serviceSave(Request $request)
  {
    //dd($request->all());
    $this->validate($request, [
      'name' => 'required|string',
      'service_code' => 'required|string',
      'fix_visit' => 'required|string',
      'extra_visit' => 'required|string',
      'fee_spares' => 'required|string',
      'description' => 'nullable|string',
    ]);
    $data = new Service();
    $data->name = $request->name;
    $data->service_code = $request->service_code;
    $data->fix_visit = $request->fix_visit;
    $data->extra_visit = $request->extra_visit;
    $data->fee_spares = $request->fee_spares;
    $data->description = $request->description;
    $data->save();

    if ($data->save()) {
      session()->flash('success', 'Service created successfully');
      return redirect()->route('service');
    } else {
      session()->flash('error', 'Invalid Data');
      return redirect()->back();
    }
  }

  public function serviceEdit($id)
  {
    $data = Service::where('id', $id)->get();
    return view('content.dashboard.master.serviceEdit', compact('data'));
  }

  public function serviceUpdate(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'service_code' => 'required|string',
      'fix_visit' => 'required|string',
      'extra_visit' => 'required|string',
      'fee_spares' => 'required|string',
      'description' => 'nullable|string',
    ]);

    $data = [
      'name' => $request->name,
      'service_code' => $request->service_code,
      'fix_visit' => $request->fix_visit,
      'extra_visit' => $request->extra_visit,
      'fee_spares' => $request->fee_spares,
      'description' => $request->description,
    ];

    Service::where('id', $id)->update($data);
    session()->flash('success', 'Service updated successfully');
    return redirect()->back();
  }

  public function serviceStatus(Request $request)
  {
    if ($request->state == 1) {
      $data = Service::where('id', $request->id)->update(['status' => 0]);
      return true;
    } else {
      $data = Service::where('id', $request->id)->update(['status' => 1]);
      return true;
    }
  }

  public function serviceDelete(Request $request)
  {
    Service::where('id', $request->id)->delete();
    session()->flash('success', 'Service deleted successfully');
    return true;
  }
}
