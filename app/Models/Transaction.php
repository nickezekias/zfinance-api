<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TRANS_TYPE_ENTRY = 1;
    const TRANS_TYPE_EXPENSE = 0;
}
