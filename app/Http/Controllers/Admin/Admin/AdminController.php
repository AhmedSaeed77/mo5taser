<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use Illuminate\Routing\Controller;
use App\Http\Requests\User\AdminRequest;
use App\Repository\AdminRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;

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
        return view('dashboard.admin');
    }

    public function edit($id)
    {
        try
        {
            $admin = Admin::find($id);
            if(isset($admin))
            {
                return view('dashboard.admin_users.edit',compact('admin'));
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
                    'image' => $request->image ?  $this->updateFile('image','admins',$admin->image) : $admin->image,
                ];

                $this->admin->update($id,$data);
                return redirect()->back()->with('success' , __('lang.updated'));
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
}
