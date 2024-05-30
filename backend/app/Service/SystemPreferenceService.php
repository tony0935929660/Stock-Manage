<?php

namespace App\Service;

use App\Models\SystemPreference;

class SystemPreferenceService
{
    protected array $prefrenceValues;

    const SYSTEM_THEME = 'System.Theme';

    public function __construct()
    {
        $this->prefrenceValues = [
            self::SYSTEM_THEME => [
                'value' => 'light',
                'is_frontend_cached' => true,
                'options' => [
                    'dark',
                    'light'
                ]
            ]
        ];
    }

    public function createDefaultSystemPreferences(string $userId)
    {
        foreach ($this->prefrenceValues as $key => $value) {
            SystemPreference::create([
                'user_id' => $userId,
                'name' => $key,
                'value' => $value['value'],
                'is_frontend_cached' => $value['is_frontend_cached'],
                'options' => $value['options'],
                'created_by' => 'System-Default',
                'updated_by' => 'System-Default'
            ]);
        }
    }
}