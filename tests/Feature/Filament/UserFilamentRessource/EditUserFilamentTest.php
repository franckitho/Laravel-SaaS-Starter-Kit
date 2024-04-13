<?php

use App\Filament\Resources\UserFilamentResource\Pages\EditUserFilament;
use App\Models\User;

use function Pest\Livewire\livewire;
use App\Models\Filament\UserFilament;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UserResource\Pages\EditUser;

beforeEach(function () {
    $this->user = UserFilament::factory()->create();
    Permission::create([
        'name' => 'update UserFilament',
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
    $this->user->givePermissionTo(['update UserFilament', 'view UserFilament', 'view-any UserFilament']);
});

test('can render page', function () {
    $user = UserFilament::factory()->create(['name' => 'Timy']);
    $this->actingAs($this->user, 'filament');

    livewire(EditUserFilament::class, ['record' => $user->id])->assertSuccessful();
});

test('can create user', function () {
    $user = UserFilament::factory()->create(['name' => 'Toy']);
    $this->actingAs($this->user, 'filament');

    livewire(EditUserFilament::class, ['record' => $user->id])
    ->fillForm([
        'name' => 'Tony',
        'email' => $user->email,
        'password' => null,
    ])
    ->call('save')
    ->assertHasNoFormErrors();

    $this->assertDatabaseHas('users_filament', ['name' => 'Tony']);
});