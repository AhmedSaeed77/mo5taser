<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Repository\UserRepositoryInterface;

class UserController extends Controller
{
    use FileManagerTrait;
    private $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        try
        {
            $users = $this->user->getAll();
            return view('dashboard.users.index',compact('users'));
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
            $roles = Role::whereIn('id',[5,4])->get();
            return view('dashboard.users.create',compact('roles'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        try
        {
            if(isset($user))
            {
                $user = $this->user->getById($id);
                $roles = Role::whereIn('id',[5,4])->get();
                return view('dashboard.users.edit',compact('user','roles'));
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

    public function store(UserRequest $request)
    {
        try
        {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'active' => $request->active,
                'educational_level' => $request->educational_level,
                'level' => $request->level,
                'type' => $request->role == 4 ? 'student' : 'markteer',
                'role_id' => $request->role,
                'image' => $this->upload('image','users'),
            ];

            $this->user->create($data);
            return redirect()->route('users.index')->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(UserRequest $request,$id)
    {
        try
        {
            $user = User::find($id);
            if(isset($user))
            {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password ? bcrypt($request->password) : $user->password,
                    'active' => $request->active,
                    'educational_level' => $request->educational_level,
                    'level' => $request->level,
                    // 'type' => $request->role == 4 ? 'student' : 'markteer',
                    'role_id' => $request->role,
                    'image' => $request->image ?  $this->updateFile('image','users',$user->image) : $user->image,
                ];

                $this->user->update($id,$data);

                if ($data['active']) {
                    Mail::send('emails.activated_user', [], function ($message) use ($user)
                    {
                        $message->to($user->email)
                            ->subject('تم تفعيل حسابك!');
                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });
                }

                return redirect()->route('users.index')->with('success' , __('lang.updated'));
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
            $user = User::find($id);
            if(isset($user))
            {
                $this->user->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
