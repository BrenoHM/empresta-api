<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InstituicaoResource;
use App\Models\Instituicao;

class InstituicaoController extends Controller
{
    //

    public function index()
    {
        
        $instituicoes = Instituicao::getAll();

        return InstituicaoResource::collection($instituicoes)->collection;

    }
}
