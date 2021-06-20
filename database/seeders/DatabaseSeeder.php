<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $user_id =  DB::table('users')->insertGetId([
            'name' => Str::random(10),
            'email' =>  Str::random(10)."@gmail.com",
            'password' => Hash::make('password'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' =>date("Y-m-d H:i:s")
        ]);

        DB::table('posts')->insert([
            'title' => "seja bem vindo ao parlador",
            'content' => "industry. Lorem Ipsum has been the industry's standard dummy text eve
            r since the 1500s, when an unknown printer took a gal
            ley of type and scrambled it to make a type specimen book. It has survived not only five ce",
            'img_url' => "https://images-na.ssl-images-amazon.com/images/I/81-N8W4ZgUL.jpg",
            'user_id' => $user_id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' =>date("Y-m-d H:i:s")
        ]);

    }
}
