<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use App\Seat;
use App\Reservation;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $butacas = DB::table('seats')->get();
        return response()->json(["butacas"=> $butacas]);
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
        $mensaje = [
            'required' => ':attribute es requerido'
        ];
        $validator = Validator::make($request->all(), [
            'taken'  => 'required|max:255',
            'reservacion_id'  => 'required|max:255',
            'number_persons'  => 'required|max:255',
        ],$mensaje);
        if ($validator->fails()) {
            return redirect('/reservaciones/create')
                        ->withErrors($validator)
                        ->withInput();
        }else{
            
                // $reservacion = Reservation::create([
                //     'user_id' => Auth::user()->id,
                //     'date'    => date("Y-m-d H:i:s"),
                //     'number_persons'  => $request['number_persons'],
                // ]);
                // dd($request['seat']);
                $butaca = Seat::create([
                    'reservation_id' => $request['reservacion_id'],
                    'seat'           => $request['seat'],
                    'taken'          => $request['taken'],
                ]);
                
                // $docente_id = Auth::user()->id;
                // $nombreDocente = Auth::user()->name;

            return response()->json([]);
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
