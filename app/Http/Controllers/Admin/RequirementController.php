<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Speedy;
use Flash;

class RequirementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requirements = Speedy::getModelInstance('requirement')->where('valid','1')->get();
        return view( 'vendor.speedy.admin.requirement.index-vue' , compact( 'requirements' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'vendor.speedy.admin.requirement.edit-vue' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //校验表单内容是否齐全
        $validator = $this->mustValidate( 'requirement.store' );

        if ( $validator->fails() )
        {
            Flash::error( '必填信息未完整填写！' );

            return redirect()->back();
        }

        $payload = $request->all();

        $detail=trim($payload['detail']); // 取得字串同时去掉头尾空格和空回车
        $detail=str_replace("\r\n","<br>",$detail); // 用p标签取代换行符

        $intro=trim($payload['com_intro']); // 取得字串同时去掉头尾空格和空回车
        $intro=str_replace("\r\n","<br>",$intro); // 用p标签取代换行符

        if ($payload['more'])
        {
            $more=trim($payload['more']); // 取得字串同时去掉头尾空格和空回车
            $more=str_replace("\r\n","<br>",$more); // 用p标签取代换行符
        }

        /*
         * 处理字段
         * */
        $create_data = [
            'company_name'        => $payload['company_name'] ,
            'industry'     => $payload['industry'] ,
            'location'         => $payload['location'] ,
            'property'     => $payload['property'] ,
            'employee_number' => $payload['employee_number'] ,
            'manager_number'      => $payload['manager_number'] ,
            'higher_class_number'      => $payload['higher_class_number'] ,
            'middle_class_number'      => $payload['middle_class_number'] ,
            'junior_class_number'      => $payload['junior_class_number'] ,
            'type'      => $payload['type'] ,
            'classification'      => $payload['classification'] ,
            'patent'      => $payload['patent'] ,
            'appraise'      => $payload['appraise'] ,
            'introduce'      => $payload['introduce'] ,
            'cooperate'      => $payload['cooperate'] ,
            'entrust'      => $payload['entrust'] ,
            'other'      => $payload['other'] ,
            'budget'      => $payload['budget'] ,
            'more'      => $more ,
            'detail'      => $detail ,
            'contact'      => $payload['contact'] ,
            'phone'      => $payload['phone'] ,
            'email'      => $payload['email'] ,
            'com_intro'      => $intro ,
            'requirement_number'      => $payload['requirement_number'] ,
            'problem_number'      => $payload['problem_number'] ,
        ];

        /*
         * 创建数据
         */
        $result  = Speedy::getModelInstance( 'requirement' )->create( $create_data );

        if ( $result )
        {
            Flash::success( '创建项目需求成功!' );
            return redirect()->route( 'admin.requirement.index' );
        }
        else
        {
            Flash::error( '创建项目需求失败!' );

            return redirect()->back();
        }
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
        $requirement = Speedy::getModelInstance('requirement')->where('id',$id)->first();
        return view( 'vendor.speedy.admin.requirement.edit-vue' , compact('requirement'));
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
        //校验表单内容是否齐全
        $validator = $this->mustValidate( 'requirement.update' );

        if ( $validator->fails() )
        {
            Flash::error( '必填信息未完整填写！' );

            return redirect()->back();
        }

        $payload = $request->all();

        $detail=trim($payload['detail']); // 取得字串同时去掉头尾空格和空回车
        $detail=str_replace("\r\n","<br>",$detail); // 用p标签取代换行符

        $intro=trim($payload['com_intro']); // 取得字串同时去掉头尾空格和空回车
        $intro=str_replace("\r\n","<br>",$intro); // 用p标签取代换行符

        if ($payload['more'])
        {
            $more=trim($payload['more']); // 取得字串同时去掉头尾空格和空回车
            $more=str_replace("\r\n","<br>",$more); // 用p标签取代换行符
        }

        /*
         * 处理字段
         * */
        $update_data = [
            'company_name'        => $payload['company_name'] ,
            'industry'     => $payload['industry'] ,
            'location'         => $payload['location'] ,
            'property'     => $payload['property'] ,
            'employee_number' => $payload['employee_number'] ,
            'manager_number'      => $payload['manager_number'] ,
            'higher_class_number'      => $payload['higher_class_number'] ,
            'middle_class_number'      => $payload['middle_class_number'] ,
            'junior_class_number'      => $payload['junior_class_number'] ,
            'type'      => $payload['type'] ,
            'classification'      => $payload['classification'] ,
            'patent'      => $payload['patent'] ,
            'appraise'      => $payload['appraise'] ,
            'introduce'      => $payload['introduce'] ,
            'cooperate'      => $payload['cooperate'] ,
            'entrust'      => $payload['entrust'] ,
            'other'      => $payload['other'] ,
            'budget'      => $payload['budget'] ,
            'more'      => $more ,
            'detail'      => $detail ,
            'contact'      => $payload['contact'] ,
            'phone'      => $payload['phone'] ,
            'email'      => $payload['email'] ,
            'com_intro'      => $intro ,
            'requirement_number'      => $payload['requirement_number'] ,
            'problem_number'      => $payload['problem_number'] ,
        ];

        /*
         * 创建数据
         */
        $result  = Speedy::getModelInstance( 'requirement' )->where('id',$id)->update( $update_data );

        if ( $result )
        {
            Flash::success( '编辑项目需求成功!' );
            return redirect()->route( 'admin.requirement.index' );
        }
        else
        {
            Flash::error( '编辑项目需求失败!' );

            return redirect()->back();
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
        $result = Speedy::getModelInstance( 'requirement' )->where( 'id' , $id )->update( [
            'valid' => '0' ,
        ] );

        if ( $result )
        {
            Flash::success( '删除需求成功!' );

            return redirect()->route( 'admin.requirement.index' );
        }
        else
        {
            Flash::error( '删除需求失败!' );

            return redirect()->back();
        }
    }
}
