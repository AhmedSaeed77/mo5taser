<?php

namespace App\Http\Controllers\Admin\Exchange;

use App\Models\User;
use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\ExchangeRepositoryInterface;

class ExchangeController extends Controller
{
    use FileManagerTrait;
    private $exchange;

    public function __construct( ExchangeRepositoryInterface $exchange)
    {
        $this->exchange = $exchange;
    }

    public function index()
    {
        try
        {
            $exchanges = $this->exchange->getAll();
            return view('dashboard.exchanges.index',compact('exchanges'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $exchange = $this->exchange->getById($id);
        try
        {
            if(isset($exchange))
            {
                $exchange->update(['status' => 'read']);
                return view('dashboard.exchanges.edit',compact('exchange'));
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

    public function update(Request $request,$id)
    {
        $exchange = $this->exchange->getById($id);
        try
        {
            if(isset($exchange))
            {

                if($exchange->paid == 0)
                {
                    if($request->paid == 1)
                    {
                        $user = User::where('id' , $exchange->user_id)->first();
                        if($user)
                        {
                            $user->update(['balance' => $user->balance - $exchange->amount]);
                        }
                    }
                }

                $data = [
                    'status' => $request->status,
                    'paid' => $exchange->paid == 0 ? $request->paid : $exchange->paid,
                    'image_transfer' => $request->image_transfer ?  $this->updateFile('image_transfer','images_transfer',$exchange->image_transfer) : $exchange->image_transfer,
                ];

                $this->exchange->update($id,$data);
                return redirect()->route('exchange.index')->with('success' , __('lang.updated'));
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
            $exchange = Exchange::find($id);
            if(isset($exchange))
            {
                $exchange->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
