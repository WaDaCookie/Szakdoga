<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    public function equipmentTypes()
    {
        return $this->hasMany(EquipmentType::class);
    }
}
