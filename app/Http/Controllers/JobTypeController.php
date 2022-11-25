<?php

namespace App\Http\Controllers;

use App\Models\JobType;

class JobTypeController extends Controller
{
    public function index()
    {
        return JobType::all();
    }
}
