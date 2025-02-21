<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class ApplianceController extends Controller
{
    public function show()
    {
        $equipments = Equipment::all();
        $equipmentTypes = EquipmentType::all();
        return view('addAppliance', compact('equipments', 'equipmentTypes'));
    }

    public function showStorage()
    {
        // Fetch equipment types where room_id is NULL and load related equipment
        $equipmentWithoutRoom = EquipmentType::whereNull('room_id')->with('equipment')->get();

        return view('storage', compact('equipmentWithoutRoom'));
    }

    public function storeEquipment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        Equipment::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'type' => $request->type,
        ]);

        return redirect()->route('addAppliance')->with('success', 'Equipment added successfully!');
    }

    public function storeEquipmentType(Request $request)
    {
        $request->validate([
            'type_number' => 'required|string|unique:equipment_types,type_number|max:255',
            'equipment_id' => 'required|exists:equipments,id',
        ]);

        EquipmentType::create([
            'type_number' => $request->type_number,
            'equipment_id' => $request->equipment_id,
        ]);

        return redirect()->route('addAppliance')->with('success', 'Type Number added successfully!');
    }
}

