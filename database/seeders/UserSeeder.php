<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = file_get_contents('users.json');
        $users = json_decode($users, true);

        $users = $users['users'];
        $users = collect($users)->map(function ($item) {
            $item['created_at'] = Carbon::parse(str_replace('/', '-', $item['created_at']));
            $item['updated_at'] = Carbon::parse(str_replace('/', '-', $item['created_at']));
            return $item;
        })->toArray();
        // Log::info(collect($users)->toJson());
        User::insert($users);
    }
}
