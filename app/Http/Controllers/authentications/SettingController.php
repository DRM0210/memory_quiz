<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CompanyInfo;

class SettingController extends Controller
{
  public function adminSetting()
  {
    $data = Auth::user();
    $company = CompanyInfo::where('user_id', $data->id)->first();

    if ($company == null) {
      $company = new CompanyInfo();
      $company->user_id = $data->id;
      $company->name = 'ISPL';
      $company->email = 'info@ispl.com';
      $company->phone = '9983103046';
      $company->website = 'ispl.com';
      $company->address = json_encode([
        'address' => 'Gali No.10, Saraswati Colony, Rangpur Road',
        'pincode' => '324002',
      ]);
      $company->save();
    }

    return view('layouts.setting', compact('data', 'company'));
  }

  public function adminSettingUpdate(Request $request)
  {
    $request->validate([
      'company_name' => 'required|string|max:255',
      'company_address' => 'required|string',
      'pincode' => 'required|string|max:20',
      'company_phone' => 'required|string|max:20',
      'company_email' => 'required|email',
      'company_website' => 'required|string|max:255',
    ]);

    $data = Auth::user();
    $company = CompanyInfo::where('user_id', $data->id)->first();
    if (!$company) {
      $company = new CompanyInfo();
      $company->user_id = $data->id;
    }

    $company->name = $request->company_name;
    $company->phone = $request->company_phone;
    $company->email = $request->company_email;
    $company->website = $request->company_website;

    $uploadPath = public_path('assets/uploads/user');
    if (!is_dir($uploadPath)) {
      @mkdir($uploadPath, 0755, true);
    }

    if ($request->hasFile('logo')) {
      $file = $request->file('logo');
      $upload_name = 'assets/uploads/user/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
      $file->move($uploadPath, basename($upload_name));
      $company->logo = $upload_name;
    }

    if ($request->hasFile('icon')) {
      $file = $request->file('icon');
      $upload_name = 'assets/uploads/user/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
      $file->move($uploadPath, basename($upload_name));
      $company->icon = $upload_name;
    }

    $company->address = json_encode([
      'address' => $request->company_address,
      'pincode' => $request->pincode,
    ]);

    $company->save();

    session()->flash('success', 'Company information updated successfully.');
    return redirect()->route('admin-setting');
  }


}
