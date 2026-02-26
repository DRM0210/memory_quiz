<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\{job_visit, JobTask, Machine, MachineType, SparePart, Staff};
use Illuminate\Http\Request;
use App\Models\job;
use App\Models\ClientJob;

class JobController extends Controller
{
  public function job($cid, $mid)
  {
    $data = ClientJob::where('client_id', $cid)->get();
    $machine = Machine::find($mid);
    $client = Client::find($cid);
    return view("content.dashboard.job.index", compact("data", "mid", "cid"));
  }

  public function jobCreate($cid, $mid)
  {
    $machine = Machine::find($mid);
    $client = Client::find($cid);
    $machinetype = MachineType::where('status', 1)->get();
    return view('content.dashboard.job.create', compact('machine', 'client', 'machinetype', "mid", "cid"));
  }

  public function jobView($jid)
  {
    $job = ClientJob::find($jid);
    $machine = Machine::find($job->machine_id);
    $client = Client::find($job->client_id);
    $visit = job_visit::where('job_id', $jid)->get();
    $staff = Staff::where('status', 1)->get();
    $sparepart = SparePart::where('status', 1)->get();
    $task = JobTask::where('status',1)->get();
    // dd($visit);
    return view('content.dashboard.job.view', compact('machine', 'client', 'job', 'visit', 'staff', 'sparepart','task'));
  }

  public function saveVisit(Request $request)
  {
    // dd($request->all());
    $validatedData = $request->validate([
      'job_id' => 'required|integer',
      'name' => 'required|string|max:255',
      'assign_member_id' => 'required|integer',
      'spare' => 'required|integer',
      'description' => 'nullable|string',
    ]);
    $visit = new job_visit();
    $visit->job_id = $request->job_id;
    $visit->name = $request->name;
    $visit->assign_member_id = $request->assign_member_id;
    $visit->spare = $request->spare;
    $visit->spare_id = json_encode($request->spare_id) ?? '';
    $visit->subtask = json_encode($request->task_id) ?? '';
    $visit->description = $request->description;
    if ($visit->save()) {
      $data = job_visit::where('job_id', $request->job_id)->get();
      return response()->json([
        'success' => true,
        'message' => 'Visit saved successfully',
        'data' => $data,
      ], 200);
    }
    return response()->json([
      'success' => false,
      'message' => 'Failed to save visit',
    ], 500);
  }

  public function editVisit(Request $request)
  {
    $data = job_visit::find($request->vid);
    if (!empty($data)) {
      return response()->json([
        'status' => true,
        'message' => 'Visit fetched successfully',
        'data' => $data,
      ], 200);
    }

    return response()->json([
      'status' => false,
      'message' => 'Failed to fetch visit',
    ], 500);
  }

  public function updateVisit(Request $request)
  {
    $validatedData = $request->validate([
      'job_id' => 'required|integer',
      'name' => 'required|string|max:255',
      'assign_member_id' => 'required|integer',
      'spare_edit' => 'required|integer',
      'description' => 'nullable|string',
    ]);

    $visit = $request->has('visit_id') && $request->visit_id ? job_visit::find($request->visit_id) : new job_visit();

    if ($request->has('visit_id') && !$visit) {
      return response()->json([
        'success' => false,
        'message' => 'Visit not found',
      ], 404);
    }

    $visit->job_id = $request->job_id;
    $visit->name = $request->name;
    $visit->assign_member_id = $request->assign_member_id;
    $visit->spare = $request->spare_edit;
    if ($request->spare_edit == 0) {
      $visit->spare_id = '';
    } else {
      $visit->spare_id = json_encode($request->spare_id);
    }
    $visit->subtask = json_encode($request->task_id) ?? '';
    $visit->description = $request->description;
    $visit->status = $request->status;
    if ($visit->save()) {
      $data = job_visit::where('job_id', $request->job_id)->get();
      return back()->with('message', 'Your visit update successfully')->withInput();
    }

    return back()->with('message', 'Error , please check form')->withInput();
  }


  public function deleteVisit(Request $request)
  {
    try {
      $visit = job_visit::find($request->vid);
      if (!$visit) {
        return response()->json(['status' => false, 'message' => 'Visit not found'], 404);
      }
      $visit->delete();
      return response()->json(['status' => true, 'message' => 'Visit deleted successfully']);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => 'An error occurred while deleting the visit'], 500);
    }
  }
}
