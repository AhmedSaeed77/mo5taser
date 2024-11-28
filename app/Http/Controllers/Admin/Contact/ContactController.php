<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Models\Contact;
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
            $contacts = $this->contact->getAll();
            return view('dashboard.contacts.index',compact('contacts'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function show($id)
    {
        $contact = Contact::find($id);
        try
        {
            if(isset($contact))
            {
                $contact = $this->contact->getById($id);
                $contact->update(['status' => 'read']);
                return view('dashboard.contacts.show',compact('contact'));
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

    public function destroy($id)
    {
        try
        {
            $contact = Contact::find($id);
            if(isset($contact))
            {
                $contact->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
