<?php

namespace App\Http\Controllers\Admin\Assemble;

use App\Models\Payment;
use App\Models\Assemble;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Assemble\StoreRequest;


class AssembleRequestsController extends Controller
{
    public function index()
    {
        try
        {
            $type = request()->type;
            $date_from = request()->date_from;
            $date_to = request()->date_to;

            $payments = Payment::query()->whereHas('assemble', function ($query) {
                $query->where('show_flag', 'assemble');
            })->when($type != null, function ($item) use ($type) {
                    if($type != 'all')
                    {
                        return $item->where('type', $type);
                    }
                    else
                    {
                        return $item;
                    }
                })->when($date_from != null, function ($item) use ($date_from) {
                    return $item->where('created_at', '>=' , $date_from);
                })
                ->when($date_to != null, function ($item) use ($date_to) {
                    return $item->where('created_at', '<=' , $date_to);
                })->get();



            $printed_payments = array_sum($payments->where('type','printed')->pluck('price')->toArray());
            $pdf_payments = array_sum($payments->where('type','pdf')->pluck('price')->toArray());
            $all_payments = $printed_payments + $pdf_payments;
            return view('dashboard.assemblies-requests.index',compact('payments','printed_payments','pdf_payments','all_payments'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function show($id)
    {
        $payment = Payment::find($id);
        try
        {
            if(isset($payment))
            {
                return view('dashboard.assemblies-requests.show',compact('payment'));
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

    public function destroy($id)
    {
        try
        {
            $payment = Payment::find($id);
            if(isset($payment))
            {
                $payment->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function getLevels(Request $request)
    {
        $department_id = $request->department_id;
        if($department_id != NULL)
        {
            $levels = Category::where(['parent_id' => $department_id,'type' => 'assemblies'])->get();
        }
        else
        {
            $levels = '';
        }
        return response()->json($levels);
    }
}
