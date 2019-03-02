<?php

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items_to_seed = 43;
        echo "[+] Creating Todos";
        if (Todo::count() < $items_to_seed)
            factory(Todo::class, $items_to_seed - Todo::count())->create();
    }
}
