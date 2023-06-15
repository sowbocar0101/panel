<?php

namespace App\Http\Controllers;

use App\StatisticConducteur;
use Illuminate\Http\Request;

class StatisticConducteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('statconducteur');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StatisticConducteur  $statisticConducteur
     * @return \Illuminate\Http\Response
     */
    public function show(StatisticConducteur $statisticConducteur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatisticConducteur  $statisticConducteur
     * @return \Illuminate\Http\Response
     */
    public function edit(StatisticConducteur $statisticConducteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatisticConducteur  $statisticConducteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatisticConducteur $statisticConducteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatisticConducteur  $statisticConducteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatisticConducteur $statisticConducteur)
    {
        //
    }
}
