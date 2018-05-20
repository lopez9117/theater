<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Validator;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = DB::table("users")
        //             ->select('users.name','users.last_name','user_id')
        //             ->join( "reservations",'users.id','=','reservations.user_id' )
        //             ->groupBy('name','last_name','user_id')
        //             ->get();
        $users = DB::select("
            SELECT users.name, users.last_name, users.email,users.id, COUNT(reservations.user_id) reservations FROM users
            LEFT JOIN reservations ON users.id=reservations.user_id
            GROUP BY reservations.user_id,users.name,users.last_name,users.email,users.id
        ");
        return view('users.index',['usuarios'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mensaje = [
            'required' => ':attribute es requerido'
        ];
        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|max:255',
            'password'   => 'required|max:255'
        ],$mensaje);
        if ($validator->fails()) {
            return response()->json(['mensaje'=>'Datos incorrectos']);
        }else{
            $user = User::create([
                'name'      => $request['name'],
                'last_name' => $request['last_name'],
                'email'     => $request['email'],
                'rol'     => 'cliente',
                'password'  => bcrypt($request['password'])
            ]);
            return redirect('/usuarios');
            // return response()->json(['mensaje'=>'Usuario Creado','user'=>$user]);
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
        $user = DB::table('users')
                    ->select('users.*')
                    ->where('id','=',$id)
                    ->get();
        // $user = User::where('id','=',$id)->get();
        return view('users.show',['usuario'=>$user]);
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
        $mensaje = [
            'required' => ':attribute es requerido'
        ];
        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|max:255'
        ],$mensaje);
        if ($validator->fails()) {
            return response()->json(['mensaje'=>'Datos incorrectos']);
        }else{
            $user = User::find($id);
            
            $user->name      = $request['name'];
            $user->last_name = $request['last_name'];
            $user->email     = $request['email'];
            if( $request['password'] != "" ){
                $user->password = bcrypt($request['password']);
            }
            
            $user->save();
            
            return response()->json(['mensaje'=>'Usuario Actualizado','user'=>$user,'pass'=>$request['password'],'status'=>1]);
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
        $user = User::find($id);
        $user->delete();
        return response()->json(['mensaje'=>'Usuario Eliminado']);
    }
}
