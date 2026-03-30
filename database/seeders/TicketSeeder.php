<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Ticket::create([
            'subject' => 'Database error when creating AI run',
            'body' => 'errno: 150 "Foreign key constraint is incorrectly formed"',
        ]);

        \App\Models\Ticket::create([
            'subject' => 'Bluetooth headset stopped',
            'body' => 'Audio drops when I press pause',
        ]);


        \App\Models\Ticket::create([
            'subject' => 'BSOD',
            'body' => 'After updating Windows 98, I get a blue screen of death every time I try to open Internet Explorer',
        ]);

        \App\Models\Ticket::factory(10)->create();
    }
}
