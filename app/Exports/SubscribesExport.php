<?php

namespace App\Exports;

use App\Models\Subscribe;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubscribesExport implements FromView
{
    public function view(): View
    {
        return view('dashboard.exports.subscribes', [
            'subscribes' => Subscribe::all()
        ]);
    }
}
