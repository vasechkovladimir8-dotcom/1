<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- ДОБАВИТЬ ЭТО
use App\Models\Plant;
use App\Models\Characteristic;

return new class extends Migration
{
    public function up(): void
    {
        $plants = Plant::all();

        foreach ($plants as $plant) {
            // 1. Полив (watering)
            if ($plant->watering) {
                $char = Characteristic::firstOrCreate([
                    'name' => 'Полив',
                    'value' => $plant->watering
                ]);
                $plant->characteristics()->syncWithoutDetaching([$char->id]);
            }

            // 2. Освещение (lighting)
            if ($plant->lighting) {
                $char = Characteristic::firstOrCreate([
                    'name' => 'Освещение',
                    'value' => $plant->lighting
                ]);
                $plant->characteristics()->syncWithoutDetaching([$char->id]);
            }

            // 3. Уход (care)
            if ($plant->care) {
                $char = Characteristic::firstOrCreate([
                    'name' => 'Уход',
                    'value' => $plant->care
                ]);
                $plant->characteristics()->syncWithoutDetaching([$char->id]);
            }
        }
    }

    public function down(): void
    {
        DB::table('characteristic_plant')->truncate();
        Characteristic::whereIn('name', ['Полив', 'Освещение', 'Уход'])->delete();
    }
};