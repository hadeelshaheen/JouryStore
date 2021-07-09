<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $data = Category::select('id','s_image',
            's_name_'.app()->getLocale() .' as s_name',
            's_description_'.app()->getLocale() .' as s_description'
        )->get();

        return response()->json(
            [
                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'All categories'

                ],
                'category'=>$data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            's_name_ar' => 'required',
            's_description_ar' => 'required',
            's_name_en' => 'required',
            's_description_en' => 'required',
            's_image' => 'image'
        ]);

        $data = $request->all();

        if($request->hasfile('s_image')) {
            $request->file('s_image')->move(public_path('img/products/'), $request->file('s_image')->getClientOriginalName());
            $data['s_image'] = 'https://newlinetech.site/jourystore/public/img/products/' . $request->file('s_image')->getClientOriginalName();
        }

        $category = Category::create($data);
        return response()->json($category, 201);


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
        $category = Category::destroy($id);
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ],
            'category'=>$category]);

    }
}
