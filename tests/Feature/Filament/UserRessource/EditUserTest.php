<?php

use App\Models\User;

use function Pest\Livewire\livewire;
use App\Models\Filament\UserFilament;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UserResource\Pages\EditUser;

beforeEach(function () {
    $this->user = UserFilament::factory()->create();
    Permission::create([
        'name' => 'update User',
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
    $this->user->givePermissionTo(['update User', 'view User', 'view-any User']);
});

test('can render page', function () {
    $user = User::factory()->create(['name' => 'Timy']);
    $this->actingAs($this->user, 'filament');

    livewire(EditUser::class, ['record' => $user->id])->assertSuccessful();
});

test('can create user', function () {
    $user = User::factory()->create(['name' => 'Timy']);
    $this->actingAs($this->user, 'filament');

    livewire(EditUser::class, ['record' => $user->id])
    ->fillForm([
        'name' => 'Timmy',
        'email' => $user->email,
        'email_verified_at' => $user->email_verified_at,
        'password' => null,
    ])
    ->call('save')
    ->assertHasNoFormErrors();

    $this->assertDatabaseHas('users', ['name' => 'Timmy']);
});