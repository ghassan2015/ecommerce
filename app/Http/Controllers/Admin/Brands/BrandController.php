<?php

namespace App\Http\Controllers\Admin\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::get();
        return view('dashboard.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.brands.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){





        //validation

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);


        $fileName = "";
        if ($request->has('photo')) {

            $fileName = uploadImage('brands', $request->photo);
        }

        $barnd=new Brand();
        $barnd->is_active=$request->is_active;
        //save translations
        $barnd->name = $request->name;
        $barnd->photo = $fileName;

        $barnd->save();
        DB::commit();
        return redirect()->route('admin.brands')->with(['success' => 'تم ألاضافة بنجاح']);
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

            $category = Category::find($id);
            return view('dashboard.categories.edit', compact('category'));
        } catch (\Exception $exception) {
            return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

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
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            $category = Category::find($id);
            $category->update($request->all());

            return redirect()->route('admin.category')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $exception) {
            return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

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
            $subcategory = Category::where('parent_id', $id)->child()->get();
            if ($subcategory->count() > 0)
                return redirect()->route('admin.category')->with(['error' => 'حدث خطا لا يمكن حذفهذا العنصر لانه لذيه ابناء  المحاوله لاحقا']);

            $category = Category::find($id);
            $category->delete();
            return redirect()->route('admin.category')->with(['success' => 'تم الحذف بنجاح']);

        } catch (\Exception $exception) {
            return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }
}
