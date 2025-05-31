<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = Storage::disk('public')->get('countries.json');

        DB::table('countries')->truncate();

        $countryData = [];

        foreach (json_decode($countries) as $key => $country) {
            $countryData[] = [
                'id' => $key + 1,
                'name' => $country->country,
            ];
        }

        Country::query()->insert($countryData);
    }
}
