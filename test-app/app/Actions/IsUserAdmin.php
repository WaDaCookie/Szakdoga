<?php

namespace App\Actions;

class IsUserAdmin
{
    public static function handle(): bool
    {
        $roles = auth()->user()->roles->pluck('slug')->all();
        foreach ($roles as $role) {
            if ($role === 'admin') {
                return true;
            }
        }
        return false;
    }
}
