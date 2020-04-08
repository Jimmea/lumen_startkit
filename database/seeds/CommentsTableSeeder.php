<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/5/19
 * Time: 11:43
 */

use Illuminate\Database\Seeder;
class CommentsTableSeeder extends Seeder
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
            \App\Models\Comment::create([
                'post_id' => random_int(1,1000),
                'user_id' => random_int(1, 1000),
                'content' => $faker->sentence(10),
            ]);
        }
    }
}