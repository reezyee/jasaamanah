<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $clients = User::where('role', 'client')->get();
        $workers = User::where('role', 'worker')->get();

        if ($clients->isEmpty() || $workers->isEmpty()) {
            return;
        }
        
        Task::create([
            'title'       => 'Buat Kontrak Kerja',
            'description' => 'Menyusun kontrak kerja untuk client',
            'division'    => 'legalitas',
            'status'      => 'Drafting',
            'assigned_to' => $workers->random()->id,
            'client_id'   => $clients->random()->id,
        ]);

        Task::create([
            'title'       => 'Desain Logo Baru',
            'description' => 'Membuat desain logo sesuai brief client',
            'division'    => 'design',
            'status'      => 'Concepting',
            'assigned_to' => $workers->random()->id,
            'client_id'   => $clients->random()->id,
        ]);

        Task::create([
            'title'       => 'Develop Landing Page',
            'description' => 'Membuat halaman landing page sesuai desain',
            'division'    => 'website',
            'status'      => 'Planning',
            'assigned_to' => $workers->random()->id,
            'client_id'   => $clients->random()->id,
        ]);
    }
}
