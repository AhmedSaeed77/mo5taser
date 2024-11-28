<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{

    public function getSubjects(Request $request)
    {
        $val = $request->val;
        if($val != NULL)
        {
            $childs = Subject::where('parent_id' , $val)->get();
        }
        else
        {
            $childs = '';
        }
        return response()->json($childs);
    }
}
