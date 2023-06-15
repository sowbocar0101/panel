<?php

namespace App\Http\Controllers;

use App\StatisticUserApp;
use Illuminate\Http\Request;

class StatisticUserAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('statuserapp');
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
     * @param  \App\StatisticUserApp  $statisticUserApp
     * @return \Illuminate\Http\Response
     */
    public function show(StatisticUserApp $statisticUserApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatisticUserApp  $statisticUserApp
     * @return \Illuminate\Http\Response
     */
    public function edit(StatisticUserApp $statisticUserApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatisticUserApp  $statisticUserApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatisticUserApp $statisticUserApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatisticUserApp  $statisticUserApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatisticUserApp $statisticUserApp)
    {
        //
    }
}
