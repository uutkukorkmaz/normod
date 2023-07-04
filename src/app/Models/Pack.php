<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uutkukorkmaz\LaravelStatuses\Concerns\HasStatus;

class Pack extends Model
{
	use HasStatus;
    use HasFactory;
}
