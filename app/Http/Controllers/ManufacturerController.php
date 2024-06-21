<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
        public function index()
    {
        $manufacturers = Manufacturer::all();
        return view('manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        return view('manufacturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);
        Manufacturer::create($request->all());
        return redirect()->route('manufacturers.index')->with('success', 'Manufacturer created successfully');
    }

    
    public function show(Manufacturer $manufacturer)
    {
        return view('manufacturers.show', compact('manufacturer'));
    }


    public function edit(Manufacturer $manufacturer)
    {
        
        return view('manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);
        $manufacturer->update($request->all());
        return redirect()->route('manufacturers.index')->with('success', 'Manufacturer updated successfully');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect()->route('manufacturers.index')->with('success', 'Manufacturer deleted successfully');
    }
}
