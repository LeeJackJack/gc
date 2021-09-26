<?php

    namespace App\Http\Controllers\Admin;

    use function GuzzleHttp\Promise\all;
    use Speedy;
    use Illuminate\Http\Request;
    use Auth;
    use Flash;

    class UserController extends BaseController
    {

        //protected $permissionName = 'user';

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $nowUser = Auth::user();

            //判断权限
            if ( $nowUser->role_id == '1' )
            {
                $users = Speedy::getModelInstance( 'user' )->get();
            }
            else
            {
                $users = Speedy::getModelInstance( 'user' )->where( 'id' , $nowUser->id )->get();
            }
            foreach ( $users as $u )
            {
                $u->role;
            }

            //dd($users);

            return view( 'vendor.speedy.admin.user.index-vue' , compact( 'users' , 'nowUser' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if ( Auth::user()->role_id == '1' )
            {
                $roles = Speedy::getModelInstance( 'role' )->all();
            }
            else
            {
                $roles = Speedy::getModelInstance( 'role' )->where( 'id' , Auth::user()->role_id )->get();
            }

            return view( 'vendor.speedy.admin.user.edit-vue' , compact( 'roles' ) );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store( Request $request )
        {
            $validator = $this->mustValidate( 'user.store' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            $data = [
                'name'     => $payload['name'] ,
                'password' => bcrypt( $payload['password'] ) ,
                'role_id'  => $payload['role_id'],
            ];

            if ( $payload['email'] )
            {
                $data = array_merge( $data , [ 'email' => $payload['email'] ] );
            }

            $result = Speedy::getModelInstance( 'user' )->create( $data );

            if ( $result )
            {
                Flash::success( '创建成功!' );
            }
            else
            {
                Flash::error( '创建失败!' );
            }

            return redirect()->route( 'admin.user.index' );
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show( $id )
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit( $id )
        {
            $user = Speedy::getModelInstance( 'user' )->find( $id );

            $roles = Speedy::getModelInstance( 'role' )->all();

            return view( 'vendor.speedy.admin.user.edit-vue' , compact( 'user' , 'roles' ) );
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update( Request $request , $id )
        {
            $validator = $this->mustValidate( 'user.update' );

            if ( $validator->fails() )
            {
                Flash::error( '必填信息未完整填写！' );

                return redirect()->back();
            }

            $payload = $request->all();

            $data = [
                'name'     => $payload['name'] ,
                'password' => bcrypt( $payload['password'] ) ,
                'role_id'  => $payload['role_id'],
            ];

            if ( $payload['email'] )
            {
                $data = array_merge( $data , [ 'email' => $payload['email'] ] );
            }

            $result = Speedy::getModelInstance( 'user' )->find( $id )->update( $data );

            if ( $result )
            {
                Flash::success( '编辑成功!' );
            }
            else
            {
                Flash::error( '编辑失败!' );
            }

            return redirect()->route( 'admin.user.index' );
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy( $id )
        {
            $result = Speedy::getModelInstance( 'user' )->destroy( $id );

            return $result ? redirect()->route( 'admin.user.index' ) : redirect()->back()->withErrors( trans( 'view.admin.user.delete_user_failed' ) )->withInput();
        }
    }
