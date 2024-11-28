<?php

namespace App\Http\Controllers\Site\Assemble;

use App\Models\Category;
use App\Models\Assemble;
use App\Models\Info;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Buy\BuyRequest;
use App\Http\Requests\Checkout\CheckoutRequest;



class AssembleController extends Controller
{

    public function index()
    {
        $categories = Category::query()
            ->category('assemblies')
            ->whereHas('assemblies', function ($query) {
                $query->where('show_flag', 'assemble');
            })
            ->where('parent_id',NULL)
            ->with('childs')
            ->get();
        return view('site.assemblies.index',compact('categories'));
    }

    public function show($id)
    {
        $assemble = Assemble::findOrFail($id);
        try
        {
            if(isset($assemble) && $assemble->type == 'book')
            {
                return view('site.assemblies.show',compact('assemble'));
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
    public function buy($id , $type)
    {
        $assemble = Assemble::findOrFail($id);
        try
        {
            if(isset($assemble))
            {
                return view('site.assemblies.payment',compact('assemble','type'));
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
    public function checkout(CheckoutRequest $request)
    {
        $assemble = Assemble::findOrFail($request->assemble);
        try
        {
            if(isset($assemble))
            {
                $payment = new Payment;
                $payment->name = $request->name;
                $payment->email = $request->email;
                $payment->phone = $request->phone;
                $payment->city = $request->city;
                $payment->area = $request->area;
                $payment->street = $request->street;
                $payment->assemble_id = $assemble->id;
                $payment->type = $request->type;
                $payment->price = $assemble->price;
                $payment->user_id = auth()->id();
                $payment->save();
                if($request->type == 'pdf')
                {

                    $file = public_path($payment->assemble->book);

                    \Mail::send('emails.send_book_mail', $data = [],function($message)use($file,$payment) {
                        $message->to($payment->email, $payment->email)
                                ->subject(__('lang.pdf_book'));

                            $message->attach($file);
                    });
                }
                return redirect()->route('assemble_pill',$payment->id);

            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            dd($ex);
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function ConvertToHEX($value)
    {
        return pack("H*", sprintf("%02X", $value));
    }


    public function pill($id)
    {
        $payment = Payment::findOrFail($id);
        $assemble = Assemble::findOrFail($payment->assemble_id);

        try
        {
            if(isset($payment))
            {
                $info = Info::first();

                $sellerName		=	$info->company_name;
                $varNumber		=	$info->tax_number;
                $timezone		=	3;
                $timeInvoice	=	gmdate("Y-m-d H:m:s", time() + 3600*($timezone+date('i')));
                $totalInvoice	=	$payment->price;
                $tax_from_total = 	$totalInvoice-number_format((float)(($totalInvoice*100)/(15+100)), 2, '.', '');

                $HexSeller = $this->ConvertToHEX(1).$this->ConvertToHEX(strlen($sellerName));
                $seller  =  $HexSeller.$sellerName;
                $HexVAT  = $this->ConvertToHEX(2).$this->ConvertToHEX(strlen($varNumber));
                $vat  = $HexVAT.$varNumber;
                $HexTime = $this->ConvertToHEX(3).$this->ConvertToHEX(strlen($timezone));
                $timezone  = $HexTime.$timezone;
                $HexTotal = $this->ConvertToHEX(4).$this->ConvertToHEX(strlen($totalInvoice));
                $totalInvoice  = $HexTotal.$totalInvoice;
                $HexVATN = $this->ConvertToHEX(5).$this->ConvertToHEX(strlen($tax_from_total));
                $VATN  = $HexVATN.$tax_from_total;

                $all   = $seller.$vat.$timezone.$totalInvoice.$VATN;

                $all = base64_encode($all);

                return view('site.assemblies.pill',compact('payment','all'));
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

}
