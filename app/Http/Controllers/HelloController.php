<?php

namespace App\Http\Controllers;

use App\Models\Hello;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Hello::all();
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
            'name' => 'required',
        ]);

        $hello = Hello::withTrashed()->updateOrCreate([
            'user_id' => 1,
            'name' => $request->get('name')
        ], [
            'deleted_at' => null
        ]);
        if($hello->trashed()){
            $hello->setHighestOrderNumber();
            $hello->restore();
        }
        return $hello;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Hello::find($id);
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
        $hello = Hello::find($id);
        $hello->update($request->all());
        return $hello;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Hello::destroy($id);
    }
}
