<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    static function getAll($key = null)
    {
        $convenios = file_get_contents(database_path('convenios.json'));

        $convenios = json_decode($convenios);

        return $key ? collect($convenios)->pluck($key) : $convenios;
    }
}
