<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Langue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;

class SettingController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::getSetting();
        $langues = Langue::getLangue();
        return view('settings')->with(['settings' => $settings, 'langues' => $langues]);
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
        session(['form'=>'setting.store']);

        $settings = Setting::getSetting();
        if($settings->count() > 0){
            $setting = Setting::findOrFail($settings[0]->id);
            $setting->fill([
                'title' => $request->title,
                'footer' => $request->footer,
                'email' => $request->email,
                'user_id' => Auth::user()->id,
            ]);
            $setting->save();
        }else{
            $setting = Setting::create([
                'title' => $request->title,
                'footer' => $request->footer,
                'email' => $request->email,
                'user_id' => Auth::user()->id,
            ]);
        }

        if($setting){
            session(['status'=>'successfuly','msg'=>'Le setting was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show($setting)
    {
        $setting = Setting::findOrFail($setting);
        return $this->successResponse($setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $setting)
    {
        session(['form'=>'setting.update']);
        session(['setting_url'=>$request->url()]);
        session(['setting_id' => $setting]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('settings','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('setting_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $setting = Setting::findOrFail($setting);
        $setting->fill([
            'title' => $request->title_mod,
            'footer' => $request->footer_mod,
            'email' => $request->email_mod,
            'user_id' => Auth::user()->id,
        ]);
        $setting->save();
        
        if($setting){
            session(['status'=>'successfuly','msg'=>'Le setting was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $setting = Setting::findOrFail($request->setting_id);
        $setting->status_del = $request->status;

        if($setting->save()){
            session(['status'=>'successfuly','msg'=>'Le setting was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
