<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = ['name', 'brand', 'type'];
    public function equipmentType(): belongsTo
    {
        return $this->hasMany(EquipmentType::class);
    }
}
