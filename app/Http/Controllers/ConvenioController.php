<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ConvenioResource;
use App\Models\Convenio;

class ConvenioController extends Controller
{
    //

    public function index()
    {

        $convenios = Convenio::getAll();

        return ConvenioResource::collection($convenios)->collection;

    }
}
