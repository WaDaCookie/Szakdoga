<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = ['name', 'brand', 'type'];
    public function equipmentType(): HasMany
    {
        return $this->hasMany(EquipmentType::class);
    }
}
