<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/5/19
 * Time: 11:44
 */

use Illuminate\Database\Seeder;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i=0;$i< 1000; $i++)
        {
            \App\Models\User::create([
                'email' => $faker->email,
                'name' => $faker->name,
                'password' => \Illuminate\Support\Facades\Hash::make('admin12345'),
                'avatar' => $faker->imageUrl(200, 200)
            ]);
        }
    }
}
