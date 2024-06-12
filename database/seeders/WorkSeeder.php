<?php

namespace Database\Seeders;

use App\Models\Technology;
use App\Models\Type;
use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $types = Type::all(); //collection di oggetti type

        $id = $types->pluck('id')->all(); // array di id [1,2,3,4,5]

        $technologies = Technology::all();

        $tech_id= $technologies->pluck('id')->all();


        for($i=0; $i<10; $i++){
            $new_work = new Work();
            $title = $faker->sentence(4);
            $new_work->title = $title;
            $slug = Str::slug($title, '-');
            $new_work->slug = $slug;
            $new_work->description = $faker->optional()->text(200);
            $new_work->github_link = $faker->url();

            $new_work->type_id = $faker->optional()->randomElement($id);

            //qui il work non ha un technology_id
            $new_work->save();

            //prendo un numero random di id di technologies

            // restituisce un numero di elementi random; con null il numero di restituxioni è random, altrimenti è impostato ad 1. Si può mettere un numero al posto di null per decidere il numero di restituzioni in array.
            $random_tech_id = $faker->randomElements($tech_id, null);

            // popolo la tabella work_technology grazie alla relazione technologies()
            $new_work->technologies()->attach($random_tech_id);
        }
    }
}
