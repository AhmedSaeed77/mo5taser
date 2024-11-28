<?php

namespace App\Http\Controllers\Site\Privacy;

use App\Models\Privacy;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\PrivacyRepositoryInterface;

class PrivacyController extends Controller
{
    use FileManagerTrait;
    private $privacy;

    public function __construct(PrivacyRepositoryInterface $privacy)
    {
        $this->privacy = $privacy;
    }

    public function index()
    {
        try
        {
            $privacies = $this->privacy->getAll();
            return view('site.privacies.index',compact('privacies'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
