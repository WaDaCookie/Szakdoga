<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::with('equipmentTypes')->paginate(5); // Fetch rooms with equipment count
        return view('dashboard', compact('rooms'));
    }
}
