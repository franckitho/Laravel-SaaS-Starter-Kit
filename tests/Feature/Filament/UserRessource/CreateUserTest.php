<?php

use function Pest\Livewire\livewire;

use App\Models\Filament\UserFilament;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UserResource\Pages\CreateUser;

beforeEach(function () {
    $this->user = UserFilament::factory()->create();
    Permission::create([
        'name' => 'create User',
        'guard_name' => 'filament'
    ]);
    Permission::create([
        'name' => 'view User',
        'guard_name' => 'filament'
    ]);
    Permission::create([
        'name' => 'view-any User',
        'guard_name' => 'filament'
    ]);
    $this->user->givePermissionTo(['create User', 'view User', 'view-any User']);
});

test('can render page', function () {

    $this->actingAs($this->user, 'filament');

    livewire(CreateUser::class)->assertSuccessful();
});

test('can create user', function () {

    $this->actingAs($this->user, 'filament');

    livewire(CreateUser::class)
    ->fillForm([
        'name' => 'Test User',
        'email' => 'test@test.test',
        'email_verified_at' => '2024-01-01 00:00:00',
        'password' => 'password',
    ])
    ->call('create')
    ->assertHasNoFormErrors();
});