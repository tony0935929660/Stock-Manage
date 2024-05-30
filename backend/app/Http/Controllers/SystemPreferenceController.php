<?php

namespace App\Http\Controllers;

use App\Models\SystemPreference;
use Illuminate\Http\Request;

class SystemPreferenceController extends Controller
{
    public function list()
    {
        $systemPreferences = SystemPreference::where('user_id', auth()->user()->id)->get();

        return $this->createApiResponse($systemPreferences);
    }
}
