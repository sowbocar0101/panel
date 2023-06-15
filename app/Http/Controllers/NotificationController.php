<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;

class NotificationController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::getNotification();
        return view('notification')->with('notifications', $notifications);
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
        session(['form'=>'notification.store']);

        $notification = Notification::create([
            'titre' => $request->titre,
            'message' => $request->message,
            'user_id' => Auth::user()->id,
        ]);

        if($notification){
            session(['status'=>'successfuly','msg'=>'La notification was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($notification)
    {
        $notification = Notification::findOrFail($notification);
        return $this->successResponse($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $notification)
    {
        session(['form'=>'notification.update']);
        session(['notification_url'=>$request->url()]);
        session(['notification_id' => $notification]);

        $notification = Notification::findOrFail($notification);
        $notification->fill([
            'titre' => $request->titre_mod,
            'message' => $request->message_mod,
            'user_id' => Auth::user()->id,
        ]);
        $notification->save();
        
        if($notification){
            session(['status'=>'successfuly','msg'=>'La notification was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $notification = Notification::findOrFail($request->notification_id);
        $notification->status_del = $request->status;

        if($notification->save()){
            session(['status'=>'successfuly','msg'=>'La notification was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
