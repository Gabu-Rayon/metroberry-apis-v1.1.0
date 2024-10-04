<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function InventoryExpense()
    {
        // Logic to handle inventory expense
        return view('inventory.expense');
    }

    public function InventoryExpenseType()
    {
        // Logic to handle inventory expense type
        return view('inventory.type');
    }

    public function InventoryCategory()
    {
        // Logic to handle inventory categories
        return view('inventory.category');
    }

    public function InventoryLocation()
    {
        // Logic to handle inventory locations
        return view('inventory.location');
    }

    public function InventoryStock()
    {
        // Logic to handle inventory stock management
        return view('inventory.stock.management');
    }

    public function InventoryParts()
    {
        // Logic to handle inventory parts
        return view('inventory.parts');
    }

    public function InventoryPartsUsage()
    {
        // Logic to handle inventory parts usage
        return view('inventory.parts.usage');
    }

    public function InventoryVendor()
    {
        // Logic to handle inventory vendors
        return view('inventory.vendors');
    }

    public function InventoryTripType()
    {
        // Logic to handle inventory trip types
        return view('inventory.trip.type');
    }
}