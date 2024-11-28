<?php

namespace App\Http\Controllers\Api\Bank;

use App\Models\Privacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Http\Resources\ModelCollection;
use App\Repository\BankRepositoryInterface;

class BankController extends Controller
{
    private $bank;

    public function __construct(BankRepositoryInterface $bank)
    {
        $this->bank = $bank;
    }

    public function index()
    {
        try
        {
            $banks = $this->bank->getAll();
            return response()->json(['data' => new ModelCollection(BankResource::collection($banks)),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
