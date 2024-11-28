<?php

namespace App\Http\Controllers\Admin\Export;

use App\Exports\FormsExport;
use App\Exports\UsersExport;
use App\Exports\SubscribesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function exportUsers()
    {
        try
        {
            return Excel::download(new UsersExport, 'users.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
    public function exportForms()
    {
        try
        {
            return Excel::download(new FormsExport, 'forms.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
    public function exportSubscribes()
    {
        try
        {
            return Excel::download(new SubscribesExport, 'subscribes.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
