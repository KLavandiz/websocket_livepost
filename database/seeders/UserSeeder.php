<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    public function run()
    {

        $this->disableForeignKeys();
        $this->truncate('users');
        $user = User::factory(10)->create();
        $this->enableForeignKeys();
    }

}
