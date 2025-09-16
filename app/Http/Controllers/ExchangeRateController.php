<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ExchangeRate::with('currency')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'rate' => 'required|numeric',
        ]);

        return ExchangeRate::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExchangeRate $exchangeRate)
    {
        return $exchangeRate->load('currency');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        $data = $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'rate' => 'required|numeric',
        ]);

        $exchangeRate->update($data);
        return $exchangeRate;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        $exchangeRate->delete();
        return response()->json(['message' => 'Exchange rate deleted']);
    }
}
