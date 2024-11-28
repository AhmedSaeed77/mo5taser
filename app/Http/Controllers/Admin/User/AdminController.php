<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Admin;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AdminRequest;
use App\Repository\AdminRepositoryInterface;

class AdminController extends Controller
{
    use FileManagerTrait;
    private $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        try
        {
            $admins = $this->admin->getAll();
            return view('dashboard.admins.index',compact('admins'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function create()
    {
        try
        {
            $roles = Role::whereIn('id',[3,2])->orderBy('id','desc')->get();
            $subjects = Subject::get();
            return view('dashboard.admins.create',compact('roles','subjects'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        try
        {
            if(isset($admin))
            {
                $admin = $this->admin->getById($id);
                $roles = Role::whereIn('id',[3,2])->get();
                $subjects = Subject::get();
                return view('dashboard.admins.edit',compact('admin','roles','subjects'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function store(AdminRequest $request)
    {
        try
        {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'active' => $request->active,
                'subject' => $request->role == 2 ? '' : $request->subject,
                'type' => $request->role == 2 ? 'admin' : 'teacher',
                'role_id' => $request->role,
                'image' => $this->upload('image','users'),
            ];

            $this->admin->create($data);
            return redirect()->route('admins.index')->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(AdminRequest $request,$id)
    {
        try
        {
            $admin = Admin::find($id);
            if(isset($admin))
            {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password ? bcrypt($request->password) : $admin->password,
                    'active' => $request->active,
                    'subject' =>  $request->role == 2 ? '' : $request->subject,
                    'type' => $request->role == 2 ? 'admin' : 'teacher',
                    'role_id' => $request->role,
                    'image' => $request->image ?  $this->updateFile('image','admins',$admin->image) : $admin->image,
                ];

                $this->admin->update($id,$data);
                return redirect()->route('admins.index')->with('success' , __('lang.updated'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function destroy($id)
    {
        try
        {
            $admin = Admin::find($id);
            if(isset($admin))
            {
                $this->admin->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
