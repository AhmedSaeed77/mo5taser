<?php

namespace App\Http\Controllers\Site\Payment;

use App\Http\Requests\Payment\ElectronicPaymanetRequest;
use App\Models\Bank;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\UserRepositoryInterface;
use App\Http\Requests\Payment\PaymentRequest;
use App\Repository\CourseRepositoryInterface;
use App\Repository\SubscribeRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use FileManagerTrait;
    private $course , $subscribe ,$user;

    public function __construct(CourseRepositoryInterface $course , SubscribeRepositoryInterface $subscribe
        ,UserRepositoryInterface $user)
    {
        $this->course = $course;
        $this->subscribe = $subscribe;
        $this->user = $user;
    }

    public function index()
    {
        try
        {
            $carts = Cart::query()->where('user_id', auth()->id())->get();
            if($carts->count() > 0)
            {
                $banks = Bank::get();
                $total = array_sum($carts->pluck('price')->toArray());
                return view('site.payment.index',compact('banks','total'));
            }
            else
            {
                return back()->with('failed' , __('lang.no_courses_in_cart'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function store(PaymentRequest $request)
    {

        try
        {
            $carts = Cart::where('user_id' , auth()->id())->get();
            if($carts->count() > 0)
            {
                if($request->type == 'by_check')
                {
                    foreach ($carts as $key => $item)
                    {
                        $data = [
                            'course_id' => $item->course_id,
                            'coupon' => $item->coupon,
                            'difference' => $item->difference,
                            'user_id' => auth()->id(),
                            'user_account_name' => $request->user_account_name,
                            'bank_name' => $request->bank_name,
                            'transfer_date' => $request->transfer_date,
                            'type' => $request->type,
                            'total' => $item->price,
                            'image' => $this->upload('image','subscribes'),
                        ];

                        $this->subscribe->create($data);
                    }

                    foreach ($carts as $key => $index) {
                        $index->delete();
                    }

                    return redirect()->route('checkout')->with('success' , __('lang.un_active_subscribe'));
                }

            }
            else
            {
                return back()->with('failed' , __('lang.no_courses_in_cart'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function electronic(ElectronicPaymanetRequest $request) {
        $cart = Cart::query()->where('user_id', auth()->id())->get();
        if ($cart->count() > 0) {
            $amount = array_sum($cart->pluck('price')->toArray()) ?? 0;
            $currency = 'SAR';
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $email = $request->email ?? auth()->user()->email;
            $source = $request->payment_token;
            $redirect_url = route('electronic_payment_callback');
            $webhook_url = route('electronic_payment_webhook');


            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer '.env('TAP_PAYMENT_TEST_SK'),
                'lang_code: AR',
            ];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.tap.company/v2/charges",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $amount,
                    'currency' => $currency,
                    'customer_initiated' => true,
                    'threeDSecure' => true,
                    'save_card' => false,
                    'description' => 'Buy products from AlMokhtasar AlShamil Institution.',
                    'metadata' => [
                        'udf1' => Carbon::now()->toDateTimeString(),
                        'udf2' => auth()->id(),
                    ],
                    'receipt' => [
                        'email' => true,
                        'sms' => false
                    ],
                    'customer' => [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                    ],
                    'source' => [
                        'id' => $source
                    ],
                    'reference' => [
                        ''
                    ],
                    'post' => [
                        'url' => $webhook_url
                    ],
                    'redirect' => [
                        'url' => $redirect_url
                    ]
                ]),
                CURLOPT_HTTPHEADER => $headers,
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $payment = json_decode($response)->transaction;
            if(!isset($payment->url)) {
                return redirect()->route('payment.index', ['method' => 'tap'])->with(['failed' => __('lang.Payment failed')]);
            }

            return redirect()->to($payment->url);
        } else {
            return redirect()->back()->with(['failed' => __('lang.no_courses_in_cart')]);
        }
    }

    public function electronicCallback() {
        if (\request('tap_id') !== null) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.tap.company/v2/charges/".request('tap_id'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer ".env('TAP_PAYMENT_TEST_SK'),
                    "accept: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $payment = json_decode($response);
            if ($payment->status == 'CAPTURED') {
                $this->activateCart($payment);
                return redirect('/')->with(['success' => __('lang.Cart contents activated successfully')]);
            } else {
                return redirect()->route('payment.index', ['method' => 'tap'])->with(['failed' => __('lang.Payment failed')]);
            }
        } else {
            return redirect('/');
        }
    }

    public function webhook(Request $request) {
        Log::info('webhook started');
        if ($request->status == 'CAPTURED') {
            $this->activateCart($request);
            Log::info('webhook ended');
            return true;
        } else {
            return false;
        }
    }

    private function activateCart($source) {
        $source = (object) $source;
        $user_id = is_array($source->metadata) ? $source->metadata['udf2'] : $source->metadata->udf2;
        $transaction_time = is_array($source->metadata) ? $source->metadata['udf1'] : $source->metadata->udf1;
        $cart = Cart::query()->where('user_id', $user_id)->where('updated_at', '<=', $transaction_time)->get();
        foreach ($cart as $course) {
            Subscribe::query()->create([
                'course_id' => $course->course_id,
                'user_id' => $user_id,
                'coupon' => $course->coupon,
                'difference' => $course->difference,
                'type' => 'electronic',
                'total' => $course->price,
                'start_subscribe' => Carbon::today()->format('Y-m-d'),
                'end_subscribe' => Carbon::now()->addDays((int)$course->course->peroid)->format('Y-m-d'),
                'active' => true,
            ]);
        }
        Cart::query()->where('user_id', $user_id)->where('updated_at', '<=', $transaction_time)->delete();
    }

}
