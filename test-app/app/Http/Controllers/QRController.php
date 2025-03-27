<?php

namespace App\Http\Controllers;

use App\Models\QRcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QRController extends Controller
{
    public function generate(int $type_id): void
    {
        //TODO: handle if dupe
        QRcodes::create([
            'code' => Str::random(6),
            'equipment_type_id' => $type_id,
        ]);
    }

    public function open(string $qrcode): View
    {
        $equipment_type = QRcodes::where('code', $qrcode)->with('equipmentType.equipment')->first();
        if ($equipment_type->equipment_type_id == null) {
            return view('addApplianceFromQrCode', [
                'equipment_type' => null,
            ]);
        } else {
            return view('addApplianceFromQrCode', [
                'equipment_type' => $equipment_type,
            ]);
        }
    }
}
