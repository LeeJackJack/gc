<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Speedy;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Speedy::getModelInstance('project')->where('valid','1')->orderBy('created_at','DESC')->get
        ();
        foreach ($projects as $p)
        {
            $industry_label = Speedy::getModelInstance('label')->where('code',$p->industry)->where('valid','1')
                ->first()->label;
            $maturity_label = Speedy::getModelInstance('label')->where('code',$p->maturity)->where('valid','1')
                ->first()->label;
            $cooperation_label = Speedy::getModelInstance('label')->where('code',$p->cooperation)->where('valid','1')
            ->first()->label;
            $p->setAttribute('industry_label',$industry_label);
            $p->setAttribute('maturity_label',$maturity_label);
            $p->setAttribute('cooperation_label',$cooperation_label);
            $p->belongsToUser;
        }

        return view( 'vendor.speedy.admin.project.index-vue' , compact( 'projects'  ) );

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
        $project = Speedy::getModelInstance('project')->where('ids',$id)->first();
        $industry_label = Speedy::getModelInstance('label')->where('code',$project->industry)->where('valid','1')
            ->first()->label;
        $maturity_label = Speedy::getModelInstance('label')->where('code',$project->maturity)->where('valid','1')
            ->first()->label;
        $cooperation_label = Speedy::getModelInstance('label')->where('code',$project->cooperation)->where('valid','1')
            ->first()->label;
        $project->setAttribute('industry_label',$industry_label);
        $project->setAttribute('maturity_label',$maturity_label);
        $project->setAttribute('cooperation_label',$cooperation_label);

        return view( 'vendor.speedy.admin.project.show' , compact( 'project'  ) );

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
