<?php

use App\Models\Desenvolvedor;
use App\Models\Nivel;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->payload = [
        'nivel' => fake()->words(2, true),
    ];
});

it('create nivel', function () {
    $response = $this->postJson(route('nivel.store'), $this->payload);

    $nivel = Nivel::first();
    $response->assertCreated();
    expect($nivel->nivel)->toBe(Str::title($this->payload['nivel']))
        ->and($response->json('data.id'))->toBe($nivel->id)
        ->and($response->json('data.nivel'))->toBe(Str::title($this->payload['nivel']));
});

it('does not allow duplicate nivel creation', function () {
    Nivel::factory()->create($this->payload);

    $response = $this->postJson(route('nivel.store'), $this->payload);

    $nivel = Nivel::where('nivel', Str::title($this->payload['nivel']))->get();
    $response->assertUnprocessable();
    expect($nivel->count())->toBe(1);
});

it('update nivel', function () {
    $nivel = Nivel::factory()->create($this->payload);
    $updatePayload = [
        'nivel' => fake()->words(2, true),
    ];

    $response = $this->putJson(route('nivel.update', $nivel->id), $updatePayload);
    $nivel->refresh();

    $response->assertOk();

    expect($response->json('data.nivel'))->toBe(Str::title($updatePayload['nivel']))
        ->and($response->json('data.id'))->toBe($nivel->id)
        ->and($nivel->nivel)->toBe(Str::title($updatePayload['nivel']));
});

it('does not allow to update nivel with name already taken', function () {
    $updatePayload = [
        'nivel' => fake()->words(2, true),
    ];
    $nivel1 = Nivel::factory()->create($this->payload);
    $nivel2 = Nivel::factory()->create($updatePayload);

    $response = $this->putJson(route('nivel.update', $nivel1->id), $updatePayload);

    $response->assertUnprocessable();
    expect($nivel2->refresh()->nivel)->toBe(Str::title($updatePayload['nivel']))
        ->and($nivel1->refresh()->nivel)->toBe(Str::title($this->payload['nivel']));
});

it('delete nivel', function () {
    $nivel = Nivel::factory()->create($this->payload);

    $response = $this->deleteJson(route('nivel.destroy', $nivel->id));

    $response->assertNoContent();
    expect(Nivel::find($nivel->id))->toBeNull();
});

it('does not allow to delete nivel with desenvolvedor attached', function () {
    $nivel = Nivel::factory()->create($this->payload);
    $desenvolvedor = Desenvolvedor::factory()->create(['nivel_id' => $nivel->id]);

    $response = $this->deleteJson(route('nivel.destroy', $nivel->id));

    $response->assertUnprocessable();
    expect(Nivel::find($nivel->id))->not()->toBeNull()
        ->and(Desenvolvedor::find($desenvolvedor->id))->not()->toBeNull();
});
