<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ApplianceController extends Controller
{
    public function show(): View
    {
        $equipments = Equipment::all();
        $equipmentTypes = EquipmentType::all();
        return view('addAppliance', compact('equipments', 'equipmentTypes'));
    }

    public function update(): View
    {
        $equipmentTypes = EquipmentType::all();

        return view('update-appliance', compact('equipmentTypes'));
    }

    public function searchEquipmentTypes(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $equipmentTypes = EquipmentType::where('type_number', 'like', "%{$query}%")->get();

        return response()->json($equipmentTypes);
    }

    public function getApplianceByType($typeNumber): JsonResponse
    {
        $equipmentType = EquipmentType::where('type_number', $typeNumber)->first();

        if ($equipmentType && $equipmentType->equipment) {
            return response()->json([
                'name' => $equipmentType->equipment->name,
                'brand' => $equipmentType->equipment->brand,
                'type' => $equipmentType->equipment->type,
                'status' => $equipmentType->status ?? 'active',
                'id' => $equipmentType->equipment->id,
            ]);
        }

        return response()->json(null);
    }

    public function updateEquipment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|in:active,needs_repair,marked_for_disposal',
        ]);

        DB::beginTransaction();

        try {
            // Equipments update
            $equipment = Equipment::findOrFail($id);
            $equipment->update([
                'name' => $request['name'],
                'brand' => $request['brand'],
                'type' => $request['type'],
            ]);

            // EquipmentTypes update
            $equipmentType = EquipmentType::where('equipment_id', $id)->firstOrFail();
//            dd($validated['status']);
            Log::info("Összes request: ",[$request->all()]);
            Log::info("Status request: ",[$request['status']]);
            Log::info("EquipmentType: ",[$equipmentType]);
            $equipmentType->update([
                'status' => $request['status'],
            ]);
            Log::info('Itt ez a büdös szar', [$equipmentType]);
            DB::commit();
            return redirect()->back()->with('success', 'Equipment and status updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error during update: ' . $e->getMessage());
        }
    }

    public function updateAppliance(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $appliance = Equipment::findOrFail($id);

        $appliance->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'type' => $request->type,
        ]);

        return redirect()->route('updateAppliance')->with('success', 'Appliance has been updated');
    }

    public function showStorage(Request $request): View
    {
        $query = EquipmentType::whereNull('room_id')->with('equipment');

        if ($request->filled('type_number')) {
            $query->where('type_number', 'like', '%' . $request->type_number . '%');
        }
        if ($request->filled('brand')) {
            $query->whereHas('equipment', function ($q) use ($request) {
                $q->where('brand', $request->brand);
            });
        }
        if ($request->filled('type')) {
            $query->whereHas('equipment', function ($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        $equipmentWithoutRoom = $query->get();

        $brands = Equipment::whereNotNull('brand')->distinct()->pluck('brand');
        $types = Equipment::whereNotNull('type')->distinct()->pluck('type');

        return view('storage', compact('equipmentWithoutRoom', 'brands', 'types'));
    }

    public function storeEquipment(Request $request): RedirectResponse
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

    public function storeEquipmentType(Request $request): RedirectResponse
    {
        //TODO: after qr code read save the id to the qrcode table
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

    public function destroy(EquipmentType $equipment)
    {
        try {
            $equipment->delete();
            return redirect()->route('storage')->with('success', 'Equipment deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting equipment: ' . $e->getMessage());
            return redirect()->route('storage')->with('error', 'Error deleting equipment.');
        }

    }
}

