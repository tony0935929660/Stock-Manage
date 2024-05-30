<?php

namespace Database\Seeders;

use App\Models\User;
use App\Service\SystemPreferenceService;
use Illuminate\Database\Seeder;

class SystemPreferenceSeeder extends Seeder
{
    protected $systemPreferenceService;

    public function __construct(SystemPreferenceService $systemPreferenceService) 
    {
        $this->systemPreferenceService = $systemPreferenceService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();

        foreach ($users as $user) {
            $this->systemPreferenceService->createDefaultSystemPreferences($user->id);
        }
    }
}
