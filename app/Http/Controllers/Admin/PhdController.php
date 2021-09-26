<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Speedy;

class PhdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();

        return view('vendor.speedy.admin.phd.index-vue' , compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();
        foreach ( $provinces as $p )
        {
            $city = Speedy::getModelInstance( 'label' )->where( 'pid' , $p->code )->get();
            $p->setAttribute( 'city' , $city );
        }

        return view('vendor.speedy.admin.phd.edit-vue' , compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $provinces = Speedy::getModelInstance( 'label' )->where( 'pid' , '001' )->get();
        foreach ( $provinces as $p )
        {
            $city = Speedy::getModelInstance( 'label' )->where( 'pid' , $p->code )->get();
            $p->setAttribute( 'city' , $city );
        }


        $student = Speedy::getModelInstance('phd')->where('id',$id)->first();

        return view('vendor.speedy.admin.phd.edit-vue' , compact('provinces','student'));
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
