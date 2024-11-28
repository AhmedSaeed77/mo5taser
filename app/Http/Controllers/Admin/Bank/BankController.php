<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Models\Subject;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\BankRequest;
use App\Repository\BankRepositoryInterface;

class BankController extends Controller
{
    use FileManagerTrait;
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
            return view('dashboard.banks.index',compact('banks'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $bank = $this->bank->getById($id);
        try
        {
            if(isset($bank))
            {
                $bank = $this->bank->getById($id);
                return view('dashboard.banks.edit',compact('bank'));
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

    public function store(BankRequest $request)
    {
        try
        {
            $data = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'account_number' => $request->account_number,
                'iban' => $request->iban,
            ];

            $this->bank->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(BankRequest $request,$id)
    {
        $bank = $this->bank->getById($id);
        try
        {
            if(isset($bank))
            {
                $data = [
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'account_number' => $request->account_number,
                    'iban' => $request->iban,
                ];

                $this->bank->update($id,$data);
                return redirect()->route('bank.index')->with('success' , __('lang.updated'));
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
        $bank = $this->bank->getById($id);
        try
        {
            if(isset($bank))
            {
                $bank->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
