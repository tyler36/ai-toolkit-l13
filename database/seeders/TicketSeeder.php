<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::factory([
            'title' => 'Database error when creating AI run',
            'body' => 'errno: 150 "Foreign key constraint is incorrectly formed"',
        ])->create();

        Ticket::factory([
            'title' => 'Bluetooth headset stopped',
            'body' => 'Audio drops when I press pause',
        ])->create();


        Ticket::factory([
            'title' => 'BSOD',
            'body' => 'After updating Windows 98, I get a blue screen of death every time I try to open Internet Explorer',
        ])->create();

        Ticket::factory(10)->create();
    }
}
