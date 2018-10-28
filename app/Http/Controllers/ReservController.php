<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use validator;
use Calendar;
use App\boats;
use App\trips;

class ReservController extends Controller
{
    //
    public function index(){
        $events = [];
        $data = trips::all();
        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->boatname,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.' +1 day'),
                    null,
                    // Add color and link on event
	                [
	                    'color' => '#f05050',
	                    'url' => '',
	                ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('reservation.index', compact('calendar'));
    }
 
    public function selectlocation(Request $request){
       
        $this->validate($request,[
            
            'location'=>'required',
            'seats'=>'required',
        ]); 
      
        $sheets=$request->input('seats');
      $location=$request->input('location');
        $events = [];
       
        $data= trips::where('location',$location )->where('availableseats','>=', $sheets)->get();
        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->boatname,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.' +1 day'),
                    null,
                    // Add color and link on event
	                [
	                    'color' => '#f05050',
	                    'url' => "/reserve2/$value->reservationid",
	                ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('reservation.index', compact('calendar'));
    }

    public function startbooking($reservationid){
        return 'sdfsdfdf';
    }
}
