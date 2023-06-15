<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\User;
use App\Commune;
use App\DistrictSanitaire;
use App\Region;
use App\Province;
use App\Organisation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Auth;
use App;

class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->successResponse($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    
    public function changePassword()
    {
        return view('change-password');
    }

    public function updateChangePassword(Request $request, $user)
    {
        $rules = [
            'old_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ];

        $this->validate($request, $rules);
        
        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error",__('custom.current_password'));
        }else{
            $user = User::findOrFail($user);
    
            $user->fill([
                'password' => Hash::make($request->password),
            ]);
    
            if($user->save()){
                session(['status'=>'successfuly','msg'=>__('custom.password_successfully')]);
                return redirect()->back();
            }else{
                session(['status'=>'failed','msg'=>__('custom.failed_to_change')]);
                return redirect()->back();
            }
        }
    }
}