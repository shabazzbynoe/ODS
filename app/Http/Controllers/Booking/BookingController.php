<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $bookings = null;
        if ($user->role == "ODSAdministrator") {
            $bookings = Booking::all();
        }else{
            $bookings = Booking::all()->where('driverID', '=', $user->id);
        }
        
        $drivers = User::all()->where('role', '=', 'driver');
        return view('booking/index')->with('bookings', $bookings)->with('drivers', $drivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booking/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Booking::create([
            'driverID' => $request->driverID,
            'itemName' => $request->itemName,
            'itemDosage' => $request->itemDosage,
            'amount' => $request->amount,
            'signaturePic' => $request->signaturePic,
            'perscriptionPic' => $request->perscriptionPic,
            'customerName' => $request->customerName,
            'customerAddress' => $request->customerAddress,
        ]);

        return redirect(url('booking'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking/show')->with('booking', $booking);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking/edit')->with('booking', $booking);
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
        $booking = Booking::find($id);
        $booking->driverID = $request->driverID;
        $booking->itemName = $request->itemName;
        $booking->itemDosage = $request->itemDosage;
        $booking->amount = $request->amount;
        $booking->signaturePic = $request->signaturePic;
        $booking->perscriptionPic = $request->perscriptionPic;
        $booking->customerName = $request->customerName;
        $booking->customerAddress = $request->customerAddress;
        $booking->save();
        return redirect(url('booking'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('booking.index');
    }
}