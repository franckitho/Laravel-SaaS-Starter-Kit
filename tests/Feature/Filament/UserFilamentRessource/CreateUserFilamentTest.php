<?php

use function Pest\Livewire\livewire;

use App\Models\Filament\UserFilament;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UserFilamentResource\Pages\CreateUserFilament;

beforeEach(function () {
    $this->user = UserFilament::factory()->create();
    Permission::create([
        'name' => 'create UserFilament',
        'guard_name' => 'filament'
    ]);
    Permission::create([
        'name' => 'view UserFilament',
        'guard_name' => 'filament'
    ]);
    Permission::create([
        'name' => 'view-any UserFilament',
        'guard_name' => 'filament'
    ]);
    $this->user->givePermissionTo(['create UserFilament', 'view UserFilament', 'view-any UserFilament']);
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