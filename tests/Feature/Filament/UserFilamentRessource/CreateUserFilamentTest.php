<?php

use function Pest\Livewire\livewire;

use App\Models\Filament\UserFilament;
use App\Filament\Resources\UserFilamentResource\Pages\CreateUserFilament;

beforeEach(function () {
    $this->user = UserFilament::factory()->create();
    $this->user->assignRole(['filament.admin']);
});

test('can render page', function () {

    $this->actingAs($this->user, 'filament');

    livewire(CreateUserFilament::class)->assertSuccessful();
});

test('can create user', function () {

    $this->actingAs($this->user, 'filament');

    livewire(CreateUserFilament::class)
    ->fillForm([
        'name' => 'Test User',
        'email' => 'test@test.test',
        'password' => 'password',
    ])
    ->call('create')
    ->assertHasNoFormErrors();

    $this->assertDatabaseHas('users_filament', ['email' => 'test@test.test']);
});