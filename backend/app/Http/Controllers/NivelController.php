<?php

namespace App\Http\Controllers;

use App\Actions\CreateNivelAction;
use App\Actions\DeleteNivelAction;
use App\Actions\UpdateNivelAction;
use App\Data\FilterData;
use App\Http\Requests\NivelRequest;
use App\Http\Resources\NivelCollection;
use App\Http\Resources\NivelResource;
use App\Models\Nivel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

final class NivelController extends Controller
{
    public function index(Request $request): NivelCollection
    {
        return new NivelCollection(Nivel::index(FilterData::fromRequest($request)));
    }

    public function store(NivelRequest $request, CreateNivelAction $action): NivelResource
    {
        return new NivelResource($action->execute($request));
    }

    public function show(Nivel $nivel): NivelResource
    {
        return new NivelResource($nivel);
    }

    public function update(NivelRequest $request, Nivel $nivel, UpdateNivelAction $action): NivelResource
    {
        return new NivelResource($action->execute($request, $nivel));
    }

    public function destroy(Nivel $nivel, DeleteNivelAction $action): \Illuminate\Http\Response|JsonResponse
    {
        $deleted = $action->execute($nivel);

        return $deleted
            ? Response::noContent()
            : Response::json(['message' => 'Erro ao excluir o nível'], 500);
    }
}
