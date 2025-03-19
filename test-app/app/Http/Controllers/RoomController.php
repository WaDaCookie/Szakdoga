<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function viewRoom(Room $room): View
    {
        $equipmentTypes = Equipment::select('type')->distinct()->get();

        $equipmentByType = Equipment::with('equipmentType')->get()->groupBy('type');

        $selectedEquipments = EquipmentType::where('room_id', $room->id)->pluck('id')->toArray();

        return view('view-room', compact('room', 'equipmentTypes', 'equipmentByType', 'selectedEquipments'));
    }

    public function updateRoomEquipments(Request $request, Room $room): RedirectResponse
    {
        $validatedData = $request->validate([
            'equipment_types' => 'array',
            'equipment_types.*' => 'nullable|exists:equipment_types,id',
        ]);

        try {
            DB::beginTransaction();

            $selectedEquipmentIds = [];
            $nullIndices = [];

            foreach ($validatedData['equipment_types'] as $index => $equipmentTypeId) {
                if ($equipmentTypeId) {
                    $selectedEquipmentIds[] = $equipmentTypeId;
                } else {
                    $nullIndices[] = $index;
                }
            }

            EquipmentType::where('room_id', $room->id)
                ->whereNotIn('id', $selectedEquipmentIds)
                ->update(['room_id' => null]);

            foreach ($selectedEquipmentIds as $equipmentTypeId) {
                $selectedEquipmentType = EquipmentType::find($equipmentTypeId);
                if ($selectedEquipmentType) {
                    $selectedEquipmentType->room_id = $room->id;
                    $selectedEquipmentType->save();
                    Log::info('Equipment type ID ' . $selectedEquipmentType->id . ' assigned to room ID ' . $room->id);
                }
            }

            if (!empty($nullIndices)) {
                $equipmentByType = Equipment::with('equipmentType')->get()->groupBy('type');
                foreach ($nullIndices as $index) {
                    $type = array_keys($equipmentByType->toArray())[$index];
                    EquipmentType::where('room_id', $room->id)
                        ->whereHas('equipment', function ($query) use ($type) {
                            $query->where('type', $type);
                        })
                        ->update(['room_id' => null]);
                }
            }

            $userId = Auth::id();

            if ($userId) {
                $room->update([
                    'user_id' => $userId
                ]);
            } else {
                Log::error('Auth::id() is null.');
            }

            $room->updated_at = now();
            $room->save();

            DB::commit();
            return redirect()->route('view-room', ['room' => $room->id])->with('success', 'Appliances updates successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating room equipments: ' . $e->getMessage());
            return redirect()->route('view-room', ['room' => $room->id])->with('error', 'Error updating appliances!');
        }
    }

}
