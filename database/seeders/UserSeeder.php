<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultPassword = bcrypt('admn_tmp');
        $now = now();

        $users = [
            [
                'first_name' => 'Virgil',
                'middle_name' => 'de',
                'last_name' => 'Meijer',
                'email' => 'virgil.de.meijer@gmail.com',
                'email_verified_at' => $now,
                'password' => $defaultPassword,
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Quintijn',
                'middle_name' => null,
                'last_name' => 'Ligtvoet',
                'email' => 'qligtvoet@outlook.com',
                'email_verified_at' => $now,
                'password' => $defaultPassword,
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($users as $user) {
            $user['slug'] = Str::slug($user['first_name'] . ' ' . ($user['middle_name'] ? $user['middle_name'] . ' ' : '') . $user['last_name']);
            $count = User::where('slug', $user['slug'])->count();

            if ($count > 0) {
                $user['slug'] .= '-' . $count;
            }

            User::create($user);
        }
    }
}
