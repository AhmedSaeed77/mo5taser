<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Models\Assemble;
use App\Traits\FileManagerTrait;

class StoreController extends Controller
{
    use FileManagerTrait;

    public function index()
    {
        try
        {
            $products = Assemble::query()->where('show_flag', 'store')->get();
            return view('dashboard.store.index',compact('products'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function store(StoreRequest $request)
    {
        try
        {
            $data = $request->validated();
            $data['book'] = $this->upload('book','store');
            $data['book_preview'] = $this->upload('book_preview','store');

            $data['image'] = $this->upload('image','store');
            Assemble::create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $product = Assemble::find($id);
        try
        {
            if(isset($product))
            {
                return view('dashboard.store.edit',compact('product'));
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

    public function update(StoreRequest $request, $id)
    {
        $product = Assemble::find($id);
        try
        {
            if(isset($product))
            {
                $data = $request->validated();

                $data['book'] = $request->book ? $this->updateFile('book','assemblies',$product->book) : $product->book;
                $data['book_preview'] = $request->book_preview ? $this->updateFile('book_preview','assemblies',$product->book_preview) : $product->book_preview;

                $data['image'] = $request->image ? $this->updateFile('image','assemblies',$product->image) : $product->image;

                $product->update($data);
                return redirect()->route('store.index')->with('success' , __('lang.updated'));
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
        try
        {
            $product = Assemble::find($id);
            if(isset($product))
            {
                $product->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
