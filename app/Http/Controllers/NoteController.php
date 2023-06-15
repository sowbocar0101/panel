<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class NoteController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $rules = [
            'id_user_app' => 'required|string',
            'id_conducteur' => 'required|string',
            'note_value' => 'required|string',
            'comment' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $checking = Note::select('id')->where(['user_app_id' => $request->id_user_app, 'conducteur_id' => $request->id_conducteur])->first();
        if(!empty($checking)){
            $note = Note::findOrFail($checking->id);
            $note->fill([
                'niveau' => $request->note_value,
                'comment' => $request->comment,
            ]);
            $note->save();
            $reqNbAvis = Note::select('niveau')->where('conducteur_id', $request->id_conducteur)->get();
            $somme = 0;
            foreach($reqNbAvis as $reqNbAvi){
                $somme = $somme + $reqNbAvi->niveau;
            }
            $nb_avis = $reqNbAvis->count();
            $moyenne = $somme/$nb_avis;

            $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $request->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
            $note->nb_avis = $nb_avis;
            if(!empty($reqComment)){
                $note->niveau = $reqComment->niveau;
                $note->comment = $reqComment->comment;
            }else{
                $note->niveau = "";
                $note->comment = "";
            }
            $note->moyenne = $moyenne;
            $note->creer = date('Y-m-d H:i:s', strtotime($note->created_at));
            $note->modifier = date('Y-m-d H:i:s', strtotime($note->updated_at));
            $response['msg']['note'] = $note;
            $response['msg']['etat'] = 1;
        }else{
            $note = Note::create([
                'niveau' => $request->note_value,
                'conducteur_id' => $request->id_conducteur,
                'user_app_id' => $request->id_user_app,
                'statut' => 'yes',
                'comment' => $request->comment,
                'user_id' => $request->user_id,
            ]);
            $reqNbAvis = Note::select('niveau')->where('conducteur_id', $request->id_conducteur)->get();
            $somme = 0;
            foreach($reqNbAvis as $reqNbAvi){
                $somme = $somme + $reqNbAvi->niveau;
            }
            $nb_avis = $reqNbAvis->count();
            $moyenne = $somme/$nb_avis;

            $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $request->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
            $note->nb_avis = $nb_avis;
            if(!empty($reqComment)){
                $note->niveau = $reqComment->niveau;
                $note->comment = $reqComment->comment;
            }else{
                $note->niveau = "";
                $note->comment = "";
            }
            $note->moyenne = $moyenne;
            $note->creer = date('Y-m-d H:i:s', strtotime($note->created_at));
            $note->modifier = date('Y-m-d H:i:s', strtotime($note->updated_at));
            $response['msg']['note'] = $note;
            $response['msg']['etat'] = 1;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
