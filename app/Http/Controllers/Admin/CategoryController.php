<?php

namespace App\Http\Controllers\Admin;

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


        $category = Category::create($request->all());
        $category->slug=$request->slug;
        $category->is_active=$request->is_active;
        $this->parent_id=$request->parent_id;



        //save translations
        $category->name = $request->name;
        $category->save();

        DB::commit();
          return redirect()->route('maincategories.index')->with(['success' => 'تم ألاضافة بنجاح']);


      } catch (\Exception $ex) {
        DB::rollback();
        return $ex;
//        return redirect()->route('maincategories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
