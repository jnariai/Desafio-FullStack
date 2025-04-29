<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectNivelResource;
use App\Models\Nivel;

class SelectNivelController extends Controller
{
    public function __invoke()
    {
        return SelectNivelResource::collection(Nivel::all());
    }
}
