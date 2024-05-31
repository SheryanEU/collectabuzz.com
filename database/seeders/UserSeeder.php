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
        $users = [
            [
                'name' => 'Virgil de Meijer',
                'email' => 'virgil.de.meijer@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('admn_tmp'),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($users as $user) {
            $user['slug'] = Str::slug($user['name']);
            $count = User::where('slug', $user['slug'])->count();

            if ($count > 0) {
                $user['slug'] .= '-' . $count;
            }

            User::create($user);
        }
    }
}
