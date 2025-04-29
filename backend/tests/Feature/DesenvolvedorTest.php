<?php

use App\Enums\Sexo;
use App\Models\Desenvolvedor;
use App\Models\Nivel;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $nivel = Nivel::factory()->create();
    $this->storePayload = [
        'nivel_id' => $nivel->id,
        'nome' => fake()->name(),
        'sexo' => fake()->randomElement(Sexo::cases())->value,
        'data_nascimento' => fake()->date(),
        'hobby' => fake()->sentence(),
    ];
});

it('create desenvolvedor', function () {
    $response = $this->postJson(route('desenvolvedor.store'), $this->storePayload);

    $desenvolvedor = Desenvolvedor::first();

    $response->assertCreated();
    expect($desenvolvedor->nivel_id)->toBe($this->storePayload['nivel_id'])
                                    ->and($desenvolvedor->nome)->toBe(Str::title($this->storePayload['nome']))
                                    ->and($desenvolvedor->sexo->value)->toBe($this->storePayload['sexo'])
                                    ->and($desenvolvedor->data_nascimento->format('Y-m-d'))->toBe($this->storePayload['data_nascimento'])
                                    ->and($desenvolvedor->hobby)->toBe(Str::ucfirst($this->storePayload['hobby']))
                                    ->and($response->json('data.id'))->toBe($desenvolvedor->id)
                                    ->and($response->json('data.nivel.id'))->toBe($this->storePayload['nivel_id'])
                                    ->and($response->json('data.nome'))->toBe(Str::title($this->storePayload['nome']))
                                    ->and($response->json('data.sexo'))->toBe($this->storePayload['sexo'])
                                    ->and(CarbonImmutable::createFromFormat('d/m/Y',$response->json('data.data_nascimento'))->format('Y-m-d'))->toBe
        ($this->storePayload['data_nascimento'])
        ->and($response->json('data.hobby'))->toBe(Str::ucfirst($this->storePayload['hobby']));
});

it('update desenvolvedor', function () {
    $desenvolvedor = Desenvolvedor::factory()->create();
    $nivel = Nivel::factory()->create();
    $this->updatePayload = [
        'nivel_id' => $nivel->id,
        'nome' => fake()->name(),
        'sexo' => fake()->randomElement(Sexo::cases())->value,
        'data_nascimento' => fake()->date('Y-m-d'),
        'hobby' => fake()->sentence(),
    ];

    $response = $this->putJson(route('desenvolvedor.update', $desenvolvedor), $this->updatePayload);

    $desenvolvedor->refresh();

    $response->assertOk();
    expect($desenvolvedor->nivel_id)->toBe($this->updatePayload['nivel_id'])
                                    ->and($desenvolvedor->nome)->toBe(Str::title($this->updatePayload['nome']))
                                    ->and($desenvolvedor->sexo->value)->toBe($this->updatePayload['sexo'])
                                    ->and($desenvolvedor->data_nascimento->format('Y-m-d'))->toBe($this->updatePayload['data_nascimento'])
                                    ->and($desenvolvedor->hobby)->toBe(Str::ucfirst($this->updatePayload['hobby']))
                                    ->and($response->json('data.id'))->toBe($desenvolvedor->id)
                                    ->and($response->json('data.nivel.id'))->toBe($this->updatePayload['nivel_id'])
                                    ->and($response->json('data.nome'))->toBe(Str::title($this->updatePayload['nome']))
                                    ->and($response->json('data.sexo'))->toBe($this->updatePayload['sexo'])
                                    ->and(CarbonImmutable::createFromFormat('d/m/Y',$response->json('data.data_nascimento'))->format('Y-m-d'))->toBe
        ($this->updatePayload['data_nascimento'])
        ->and($response->json('data.hobby'))->toBe(Str::ucfirst($this->updatePayload['hobby']));
});

it('delete desenvolvedor', function () {
    $desenvolvedor = Desenvolvedor::factory()->create();

    $response = $this->deleteJson(route('desenvolvedor.destroy', $desenvolvedor));

    $response->assertNoContent();
    expect(Desenvolvedor::find($desenvolvedor->id))->toBeNull();
});
