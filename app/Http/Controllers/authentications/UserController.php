<?php

namespace App\Http\Controllers\authentications;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\CompanyInfo;

class UserController extends Controller
{
    public function profile(){
      $data = Auth::user();
      return view("content.dashboard.profile",compact("data"));
    }

    public function profileUpdate(Request $request,$id){
      $user = User::find($id);
      //$data = $request->all();
      $data = $request->except('_token');
      //dd($request->image);
      if ($request->hasFile('image')) {
        $file = $request->file('image');
        $upload_name = 'assets/uploads/user/' . rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/user'), $upload_name);
        $data['image'] = $upload_name;
      } else {
          $data['image'] = $user->image;
      }
      //dd($data);
      if(User::where('id',$id)->update($data)){
        session()->flash('success', 'User updated successfully');
        return redirect()->back();
      }else{
        session()->flash('error', 'Invalid details');
        return redirect()->back();
      }

    }

    public function profilePassword(){
      $data = Auth::user();
      return view("content.dashboard.profilePassword",compact("data"));
    }

    public function profilePasswordUpdate(Request $request){
      //dd($request->all());
      $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
      ]);
      $user = auth()->user();
      if (!Hash::check($request->old_password, $user->password)) {
        session()->flash('error', 'Invalid details');
        return redirect()->back();
      }
      $user->update([
        'password' => Hash::make($request->new_password),
      ]);
      session()->flash('success', 'Password updated successfully');
      return redirect()->back();
    }

    public function user(){
      $data = User::select('id', 'name', 'email','role_id','image')
      ->whereNotNull('email')
      ->get();
      return view('content.dashboard.user.index',compact('data'));
    }

    public function userEdit($id){
      $data = User::select('id', 'name', 'email','role_id')
      ->where('id', $id)
      ->get();
      $role = Role::get();
      return view('content.dashboard.user.edit',compact('data','role'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();
        session()->flash('success', 'User updated successfully');
        return redirect()->back();
    }

    public function role()
    {
        $data = Role::get();
        return view('content.dashboard.role.index',compact('data'));
    }

    public function roleCreate()
    {
      $permissions = Permission::select('id','name')->get();
        return view('content.dashboard.role.create',compact('permissions'));
    }

    public function roleSave(Request $request){
        //dd($request->all());
        $data = new Role;
        $data->name = $request->name;
        $data->permissions = json_encode($request->permission);
        $data->save();
        session()->flash('success', 'Role created successfully');
        return redirect()->back();
    }

    public function roleEdit($id){
      $data = Role::select('id', 'name','permissions')
      ->where('id', $id)
      ->get();
      $permissions = Permission::select('id','name')->get();
      return view('content.dashboard.role.edit',compact('data','permissions'));
    }

    public function roleUpdate(Request $request,$id){
        //dd($request->all());
        $data = Role::where('id',$id)->first();
        $data->name = $request->name;
        $data->permissions = $request->permission;
        $data->save();
        session()->flash('success', 'Role updated successfully');
        return redirect()->back();
    }

    public function roleDelete($id){
      $data = Role::where('id',$id)->delete();
      session()->flash('success', 'Role deleted successfully');
      return redirect()->back();
    }
}
