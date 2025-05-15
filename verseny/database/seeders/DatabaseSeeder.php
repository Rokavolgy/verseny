<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Viktor',
            'email' => 'viktor@example.com',
            'password' => null,
            'isAdmin' => false,
            'address' => 'Tanyasi rét 3',
            'phone' => '+36123456789',
            'birthdate' => '1995-04-23'
        ]);

        User::factory()->create([
            'name' => 'Bence',
            'email' => 'bence@example.com',
            'password' => null,
            'isAdmin' => false,
            'address' => 'Árpád utca 8',
            'phone' => '+36123456789',
            'birthdate' => '1995-04-23'
        ]);

        User::factory()->create([
            'name' => 'Lajos Lajos',
            'email' => 'lajoslajos@example.com',
            'password' => null,
            'isAdmin' => false,
            'address' => 'Őszi út 4',
            'phone' => '+36198765432',
            'birthdate' => '1990-11-17'
        ]);

        User::factory()->create([
            'name' => 'Farkas',
            'email' => 'farkas@example.com',
            'password' => null,
            'isAdmin' => false,
            'address' => 'Erdő első elágazása után jobbra',
        ]);


        User::factory()->create([
            'name' => 'Nem Lajos Lajos',
            'email' => 'nemlajoslajos@example.com',
            'password' => null,
            'isAdmin' => false,
            'address' => 'Gombóc utca 1',
            'phone' => '+36201234567',
            'birthdate' => '2000-01-01'
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'user@example.com',
            'isAdmin' => true,
            'password' => 'nagyonbiztonsagosjelszo'
        ]);

        $languageArray= ['Angol','Német','Olasz','Spanyol','Holland','Japán','Kínaí','Koreai'];
        foreach ($languageArray as $item) {
            Language::factory()->create([
                'name' => $item
            ]);
        }

    }
}
