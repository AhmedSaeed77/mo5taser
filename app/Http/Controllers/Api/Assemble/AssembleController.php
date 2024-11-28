<?php

namespace App\Http\Controllers\Api\Assemble;

use App\Models\Category;
use App\Models\Assemble;
use App\Models\Payment;
use App\Models\Info;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssembleResource;
use App\Http\Resources\PillResource;
use App\Http\Resources\SingleAssembleResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\ModelCollection;
use App\Http\Requests\Checkout\CheckoutRequest;


class AssembleController extends Controller
{

    public function index()
    {
        try
        {
            $categories = Category::category('assemblies')->whereHas('assemblies', function ($query) {
                $query->where('show_flag', 'assemble');
            })->where('parent_id',NULL)->get();
            return response()->json(['data' => new ModelCollection(AssembleResource::collection($categories)),'status' => 200]);

        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function show($id)
    {
        $assemble = Assemble::findOrFail($id);
        try
        {
            if($assemble && $assemble->type == 'book')
            {
                return response()->json(['data' => new SingleAssembleResource($assemble),'status' => 200]);
            }
            return response()->json(['data' => __('lang.not_pdf'),'status' => 400]);
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function ConvertToHEX($value)
    {
        return pack("H*", sprintf("%02X", $value));
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

                $setting = Info::first();
                $assemble = Assemble::findOrFail($payment->assemble_id);

                $sellerName		=	$setting->company_name;
                $varNumber		=	$setting->tax_number;
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

                if($request->type == 'pdf')
                {

                    $file = public_path($payment->assemble->book);

                    \Mail::send('emails.send_book_mail', $data = [],function($message)use($file,$payment) {
                        $message->to($payment->email, $payment->email)
                                ->subject(__('lang.pdf_book'));

                            $message->attach($file);
                    });
                }

                return response()->json(['data' => [
                  'setting' => new SettingResource($setting),
                  'pill' => new PillResource($payment),
                  'qr' => $all
                ],'status' => 200]);

            }
            else
            {
                return response()->json(['data' => __('lang.not_found'),'status' => 400]);
            }
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }




}
