<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/5/19
 * Time: 11:43
 */

use Illuminate\Database\Seeder;
class PostsTableSeeder extends Seeder
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
            \App\Models\Post::create([
                'user_id' => random_int(1, 1000),
                'title' => $faker->title,
                'content' => $faker->text,
                'comment_count' => random_int(1, 100)
            ]);
        }
    }
}
