<?php

namespace App\Repositories;

use App\Models\SystemPreference;

class SystemPreferenceRepository
{
    protected $model;

    public function __construct(SystemPreference $model)
    {
        $this->model = $model;
    }

    public function getSystemPreferenceByName(string $name): string
    {
        return $this->model
            ->select('value')
            ->where('user_id', auth()->user()->id)
            ->where('name', $name)
            ->first();
    }
}
