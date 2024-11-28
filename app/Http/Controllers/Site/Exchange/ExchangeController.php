<?php

namespace App\Http\Controllers\Site\Exchange;

use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exchange\ExchangeRequest;
use App\Repository\ExchangeRepositoryInterface;

class ExchangeController extends Controller
{
    use FileManagerTrait;
    private $exchange;

    public function __construct(ExchangeRepositoryInterface $exchange)
    {
        $this->exchange = $exchange;
    }

    public function store(ExchangeRequest $request)
    {
        try
        {
            $data = [
                'amount' => $request->amount,
                'user_id' => auth()->id(),
                'paid' => 0,
                'status' => 'un_read',
            ];

            $this->exchange->create($data);
            return back()->with('success' , __('lang.sent'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
