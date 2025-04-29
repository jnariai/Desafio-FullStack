<?php

namespace App\Http\Controllers;

use App\Actions\CreateDesenvolvedorAction;
use App\Actions\DeleteDesenvolvedorAction;
use App\Actions\UpdateDesenvolvedorAction;
use App\Data\FilterData;
use App\Http\Requests\StoreDesenvolvedorRequest;
use App\Http\Requests\UpdateDesenvolvedorRequest;
use App\Http\Resources\DesenvolvedorCollection;
use App\Http\Resources\DesenvolvedorResource;
use App\Models\Desenvolvedor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

final class DesenvolvedorController extends Controller
{
    public function index(Request $request): DesenvolvedorCollection
    {
        return new DesenvolvedorCollection(Desenvolvedor::index(FilterData::fromRequest($request)));
    }

    public function store(StoreDesenvolvedorRequest $request, CreateDesenvolvedorAction $action): DesenvolvedorResource
    {
        return new DesenvolvedorResource($action->execute($request));
    }

    public function show(Desenvolvedor $desenvolvedor): DesenvolvedorResource
    {
        return new DesenvolvedorResource($desenvolvedor);
    }

    public function update(UpdateDesenvolvedorRequest $request, Desenvolvedor $desenvolvedor, UpdateDesenvolvedorAction $action): DesenvolvedorResource
    {
        return new DesenvolvedorResource($action->execute($request, $desenvolvedor));
    }

    public function destroy(Desenvolvedor $desenvolvedor, DeleteDesenvolvedorAction $action): \Illuminate\Http\Response|JsonResponse
    {
        $deleted = $action->execute($desenvolvedor);

        return $deleted
            ? Response::noContent()
            : Response::json(['message' => 'Erro ao excluir o desenvolvedor'], 500);
    }
}
