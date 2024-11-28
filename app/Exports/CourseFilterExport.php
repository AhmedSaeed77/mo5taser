<?php

namespace App\Exports;

use App\Models\Subscribe;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CourseFilterExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('dashboard.filter.exports.course', [
            'subscribes' => collect(json_decode($this->data)),
        ]);
    }
}
