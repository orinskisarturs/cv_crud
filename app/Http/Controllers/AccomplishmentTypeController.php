<?php

namespace App\Http\Controllers;

use App\Models\AccomplishmentType;

class AccomplishmentTypeController extends Controller
{
    public function index()
    {
        return AccomplishmentType::all();
    }
}
