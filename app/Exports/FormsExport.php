<?php

namespace App\Exports;

use App\Models\Form;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FormsExport implements FromView
{
    public function view(): View
    {
        return view('dashboard.exports.forms', [
            'forms' => Form::all()
        ]);
    }
}
