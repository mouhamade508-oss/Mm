<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flashSales = FlashSale::with('product')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.flash-sales.index', compact('flashSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.flash-sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lt:original_price',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'is_active' => 'nullable|boolean',
            'timezone' => 'nullable|string'
        ]);

        $timezone = $validated['timezone'] ?? config('app.timezone');

        // Convert user-selected datetime-local to UTC to avoid timezone shift issues
        $validated['start_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['start_at'], $timezone)->setTimezone('UTC');
        $validated['end_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['end_at'], $timezone)->setTimezone('UTC');

        $validated['is_active'] = isset($validated['is_active']) ? (bool)$validated['is_active'] : true;

        FlashSale::create($validated);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'تم إضافة عرض الفلاش بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FlashSale $flashSale)
    {
        return view('admin.flash-sales.edit', compact('flashSale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlashSale $flashSale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lt:original_price',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'is_active' => 'nullable|boolean',
            'timezone' => 'nullable|string'
        ]);

        $timezone = $validated['timezone'] ?? config('app.timezone');

        $validated['start_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['start_at'], $timezone)->setTimezone('UTC');
        $validated['end_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['end_at'], $timezone)->setTimezone('UTC');

        $validated['is_active'] = isset($validated['is_active']) ? (bool)$validated['is_active'] : true;

        $flashSale->update($validated);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'تم تحديث عرض الفلاش بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlashSale $flashSale)
    {
        $flashSale->delete();

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'تم حذف عرض الفلاش بنجاح');
    }
}
