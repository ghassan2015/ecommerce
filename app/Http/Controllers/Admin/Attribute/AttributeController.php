<?php

namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::get();
        return view('dashboard.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.attributes.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //validation




        $attribute=Attribute::create($request->except('_token'));
        //save translations
        $attribute->name = $request->name;

        $attribute->save();
        DB::commit();
        return redirect()->route('admin.attributes')->with(['success' => 'تم ألاضافة بنجاح']);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $attribute = Attribute::find($id);
            return view('dashboard.attributes.edit', compact('attribute'));
        } catch (\Exception $exception) {
            return redirect()->route('admin.attribute')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $attribute = Attribute::find($id);

            $attribute->update($request->except('_token', 'id'));
            return redirect()->route('admin.attributes')->with(['success' => 'تم التعديل بنجاح']);
        } catch (\Exception $exception) {
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $attribute = Attribute::find($id);
            $attribute->delete();
            return redirect()->route('admin.attributes')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $exception) {
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
}
