<?php

namespace App\Http\Controllers;

use App\Models\EducationProgress;

class EducationProgressController extends Controller
{
    public function index()
    {
        return EducationProgress::all();
    }
}
