<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    use HasFactory;

    static function getAll($key = null)
    {
        $instituicoes = file_get_contents(database_path('instituicoes.json'));

        $instituicoes = json_decode($instituicoes);

        return $key ? collect($instituicoes)->pluck($key) : $instituicoes;

    }
}
