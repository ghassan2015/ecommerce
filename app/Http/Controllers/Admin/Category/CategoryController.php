<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cateogries=Category::get();
        return  view('dashboard.categories.index',compact('cateogries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =   Category::select('id','parent_id')->get();
        return view('dashboard.categories.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {

        DB::beginTransaction();

        //validation

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        //if user choose main category then we must remove paret id from the request

        if($request -> type == 1) //main category
        {
            $request->request->add(['parent_id' => null]);
        }

        //if he choose child category we mus t add parent id


          $category = Category::create($request->except('_token'));

          //save translations
          $category->name = $request->name;
          $category->save();

          return redirect()->route('admin.category')->with(['success' => 'تم ألاضافة بنجاح']);
          DB::commit();


      } catch (\Exception $ex) {
        DB::rollback();
    return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
    }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{

            $category =Category::find($id);
            return view('dashboard.categories.edit',compact('category' ));
        }catch (\Exception $exception){
            return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
        }catch (\Exception $exception){
            return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

        }catch (\Exception $exception){
            return redirect()->route('admin.category')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }


    }

}
