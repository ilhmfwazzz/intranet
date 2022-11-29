<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Hash;
use App\User;

class ProfileController extends Controller
{
  /**
   * Get data profile of current user
   * 
   */
  public function index(){
    $user_id = app('auth')->user()->id;
    $user = User::find($user_id);

    return view('profile.index', compact('user'));
  }

  public function update(Request $request, $id)
  {
      $this->validate($request, [
          'name' => 'required',
          'email' => 'required|email|unique:users,email,'.$id,
          'username' => 'required|unique:users,username,'.$id,
          'password' => 'same:confirm-password'
      ]);
  
      $input = $request->all();
      if(!empty($input['password'])){ 
          $input['password'] = Hash::make($input['password']);
      }else{
          $input = Arr::except($input,array('password'));    
      }
  
      $user = User::find($id);
      if(!empty($input['password'])){ 
          $user->update([
              'name' => $input['name'],
              'email' => $input['email'],
              'username' => $input['username'],
              'password' => $input['password'],
          ]);
      }else{
          $user->update([
              'name' => $input['name'],
              'email' => $input['email'],
              'username' => $input['username'],
          ]);
      }
  
      return redirect()->route('profile.index')
                      ->with('success','Your profile updated successfully');
  }
}
