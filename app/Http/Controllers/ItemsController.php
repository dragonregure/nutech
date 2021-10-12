<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('home', [
            'items' => Items::where('name', 'ILIKE', '%'.$request->search.'%')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|unique:items|max:255',
                'buyprice' => 'required',
                'sellprice' => 'required',
                'stock' => 'required',
            ]);

            $file = $request->file('path');
            if($file) {
                if($file->getSize() > 100000) throw new \Exception('Maximum file size limit is 100 KB!');
                $fileName = Str::uuid().'.'.$file->getClientOriginalExtension();
                $file->move(base_path('public/images'), $fileName);
            }

            $model = Items::create([
                'name' => $request->name,
                'buyprice' => $request->buyprice,
                'sellprice' => $request->sellprice,
                'stock' => $request->stock,
                'path' => isset($fileName) ? '/images/'.$fileName : '/images/example.jpg',            
            ]);
    
            if(!$model) return back()->with('error', 'Failed saving data!');
            DB::commit();
            return back()->with('success', 'Data created successfully.');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', 'Failed saving data! '.$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return response()->json(Items::where('id', $request->id)->first()->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'sometimes|required|max:255',
                'buyprice' => 'required',
                'sellprice' => 'required',
                'stock' => 'required',
            ]);

            $file = $request->file('path');
            if($file) {
                if($file->getSize() > 100000) throw new \Exception('Maximum file size limit is 100 KB!');
                $fileName = Str::uuid().'.'.$file->getClientOriginalExtension();
                $file->move(base_path('public/images'), $fileName);
            }

            $model = Items::find($request->id);
            $model->name = $request->name;
            $model->buyprice = $request->buyprice;
            $model->sellprice = $request->sellprice;
            $model->stock = $request->stock;
            if(isset($fileName)) $model->path = '/images/'.$fileName;
    
            if(!$model->save()) return back()->with('error', 'Failed saving data!');
            DB::commit();
            return back()->with('success', 'Data updated successfully.');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', 'Failed saving data! '.$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Items::destroy($request->id);
        return back()->with('success', 'Item successfully deleted.');
    }
}
