<?php

namespace App\Http\Controllers\Site\Contact;

use App\Models\Info;
use App\Models\News;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\NewsRepositoryInterface;
use App\Http\Requests\Contact\ContactRequest;
use App\Repository\ContactRepositoryInterface;

class ContactController extends Controller
{
    use FileManagerTrait;
    private $contact;

    public function __construct(ContactRepositoryInterface $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        try
        {
            $info = Info::first();
            return view('site.contact.index',compact('info'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function store(ContactRequest $request)
    {
        try
        {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'msg' => $request->msg,
                'phone' => $request->phone,
                'status' => 'unread',
            ];

            $this->contact->create($data);
            return back()->with('success' , __('lang.sent'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
