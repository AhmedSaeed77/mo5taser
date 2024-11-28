<?php

namespace App\Http\Controllers\Api\Payment;

use App\Models\Cart;
use App\Models\About;
use App\Models\DevelopmentSetting;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\SubscribeResource;
use App\Repository\UserRepositoryInterface;
use App\Http\Requests\Payment\PaymentRequest;
use App\Repository\CourseRepositoryInterface;
use App\Repository\SubscribeRepositoryInterface;

class PaymentController extends Controller
{

    use FileManagerTrait;
    private $course , $subscribe , $user;

    public function __construct(CourseRepositoryInterface $course , SubscribeRepositoryInterface $subscribe
    ,UserRepositoryInterface $user)
    {
        $this->user = $user;
        $this->course = $course;
        $this->subscribe = $subscribe;
    }

    public function checkout(PaymentRequest $request)
    {
        try
        {
            $carts = Cart::get();
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
                            'user_id' => JWTAuth::user()->id,
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

                    return response()->json(['data' => __('lang.paid_sucessfully'),'status' => 200]);
                }

            }
        }
        catch(Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function getPaymentStatus() {
        $paymentStatus = DevelopmentSetting::query()->where('key', 'show_payments')->first();
        if ($paymentStatus !== null)
            return response()->json([
                'message' => 'success',
                'data' => [
                    'show_payments' => (int) $paymentStatus->value,
                ]
            ]);
        else
            return response()->json([
                'message' => 'fail, key not found',
                'data' => []
            ]);
    }
}
