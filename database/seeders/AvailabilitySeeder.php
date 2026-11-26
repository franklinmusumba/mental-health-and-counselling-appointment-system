<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\Therapist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $therapists = Therapist::all();
        $times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];

        for ($d = 0; $d < 14; $d++) {
            $date = Carbon::today()->addDays($d);

            // Skip weekends
            if ($date->isWeekend()) continue;

            foreach ($therapists as $t) {
                foreach ($times as $time) {
                    AvailabilitySlot::firstOrCreate(
                        [
                            'TherapistID' => $t->TherapistID,
                            'SlotDate'    => $date->toDateString(),
                            'SlotTime'    => $time,
                        ],
                        ['IsBooked' => false]
                    );
                }
            }
        }
    }
}