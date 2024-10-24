<?php

namespace App\Actions\Admin;

use App\Models\User;

class GetAdmin
{
    public function execute()
    {
        return User::where('role', '=', 'admin')->first();
    }
}
