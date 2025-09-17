<?php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Purchase::with(['supplier', 'currency', 'product'])->get();
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
            'date'        => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'currency_id' => 'required|exists:currencies,id',
            'product_id'  => 'required|exists:products,id',
            'qty'         => 'required|integer',
            'total_price' => 'required|numeric',
        ]);

        return Purchase::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return $purchase->load(['supplier', 'currency', 'product']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            'date'        => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'currency_id' => 'required|exists:currencies,id',
            'product_id'  => 'required|exists:products,id',
            'qty'         => 'required|integer|min:1',
            'total_price' => 'required|numeric',
        ]);

        $purchase->update($data);
        return $purchase;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return response()->json(['message' => 'Purchase deleted']);
    }
    public function report()
    {
        $purchases = Purchase::with(['supplier', 'currency', 'product'])->get();
        $report    = [];

        foreach ($purchases as $p) {
            $rate = ExchangeRate::where('currency_id', $p->currency_id)
                ->whereDate('date', '<=', $p->date)
                ->orderBy('date', 'desc')
                ->first();

            $converted = $p->total_price * ($rate ? $rate->rate : 0);

            $report[] = [
                'date'            => $p->date,
                'supplier'        => $p->supplier->name,
                'address'         => $p->supplier->address,
                'product'         => $p->product->name,
                'qty'             => $p->qty,
                'total_price_idr' => $converted,
            ];
        }

        return response()->json($report);
    }
}
