<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Blog;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;
class UserController extends GenericController
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete')->only(['index', 'show']);
        $this->middleware('permission:user-create')->only(['create', 'store']);
        $this->middleware('permission:user-edit')->only(['edit', 'update']);
        $this->middleware('permission:user-delete')->only(['delete']);
    }
    //list users
    public function index()
    {
        $data = User::select('users.id as id', 'users.name as name', 'users.email as email')
            ->where('username', '<>', 'admin')
            ->orderBy('users.name', 'asc')->get();
        return view('users.index', compact('data'))->with('i');
    }
    //create user
    public function create()
    {
        $roles = Role::pluck('name','name')->sortBy('name')->all();
        if(!in_array("Admin", (array) app('auth')->user()->getRoleNames()[0])){
            unset($roles['Admin']);
        }
        
        return view('users.create',compact(['roles']));
    }
    //store to database
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $count_user = User::orderByRaw('cast(id as int) desc')->first()->id;
        $count_user++;
    
        $user = User::create([
            'id' => $count_user,
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => $input['password'],
        ]);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    //show specified user
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    //edit specified user
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->sortBy('name')->all();
        if(!in_array("Admin", (array) app('auth')->user()->getRoleNames()[0])){
            unset($roles['Admin']);
        }
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|unique:users,username,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
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
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    //delete specified user
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()
                        ->with('success','User deleted successfully');
    }
}