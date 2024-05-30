<?php

namespace App\Http\Controllers;

use App\Models\SystemPreference;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SystemPreferenceController extends Controller
{
    public function list(): Response
    {
        $systemPreferences = SystemPreference::where('user_id', auth()->user()->id)->get();

        return $this->createApiResponse($systemPreferences);
    }

    public function index(SystemPreference $systemPreference): Response
    {
        return $this->createApiResponse($systemPreference);
    }

    public function update(SystemPreference $systemPreference, Request $request): Response
    {
        $systemPreference->update(['value' => $request->get('value')]);

        return $this->createApiResponse();
    }
}
