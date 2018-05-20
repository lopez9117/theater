<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Reservation;
use App\Seat;

class ReservationController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
  
    public function index()
    {
        $reservaciones = Reservation::where('user_id',Auth::user()->id)
                                    ->orderBy('updated_at', 'desc')
                                    ->get();
   
        $data = array();
        $reserva = array();
        foreach( $reservaciones as $reservacion ){
            
            $butacas = DB::select("
                SELECT * FROM seats WHERE reservation_id=".$reservacion->id
            );
           
            array_push($reserva,  json_decode( str_replace('"}', '","butacas":'.json_encode($butacas).'}', json_encode( $reservacion ) )));
        }
        
        
        return view('reservations.index',['reservaciones'=>$reserva]);
    }

   
   
    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $mensaje = [
            'required' => ':attribute es requerido'
        ];
        $validator = Validator::make($request->all(), [
            'number_persons'  => 'required|max:255',
        ],$mensaje);
        if ($validator->fails()) {
            return redirect('/reservaciones/create')
                        ->withErrors($validator)
                        ->withInput();
        }else{
            
                $reservacion = Reservation::create([
                    'user_id' => Auth::user()->id,
                    'date'    => date("Y-m-d H:i:s"),
                    'number_persons'  => $request['number_persons'],
                ]);

            return response()->json(["reservacion" => $reservacion]);
        }
    }

 
    public function show($id)
    {
        $butacas = DB::table('seats')->get();
        return view('reservations.show',["butacas"=>$butacas,"reservacion_id"=>$id]);
    }

  
    public function edit($id)
    {
        
    }

   
    public function update(Request $request, $id)
    {
        $reservacion = Reservation::find($id);

        $reservacion->number_persons = $request['number_persons'];

        $reservacion->save();
        return response()->json(["reservacion" => $reservacion]);
    }

    public function destroy($id)
    {
        $response = Reservation::findOrFail($id)->delete();
        return response()->json(["response"=>"Reserva Eliminada"]);
    }

    public function delete_all_butacas($id)
    {
       
        $deletedRows = Seat::where('reservation_id', $id)->delete();
        return response()->json(["response"=>"Reserva Eliminada"]);
    }
}
