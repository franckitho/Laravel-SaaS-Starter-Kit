<?php

use App\Models\User;
use function Pest\Livewire\livewire;
use App\Filament\Resources\UserResource;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\UserResource\Pages\ListUsers;

it('can render page', function () {
    livewire(ListUsers::class)->assertSuccessful();
});

it('can render page with data', function () {
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

it('can render page with data and search', function () {
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->set('search', $user->name)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

it('can render page with data and search and sort', function () {
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->set('search', $user->name)
        ->set('sort', 'name')
        ->assertSee($user->name)
        ->assertSee($user->email);
});

it('can render page with data and search and sort and filter', function () {
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->set('search', $user->name)
        ->set('sort', 'name')
        ->set('filters', ['name' => $user->name])
        ->assertSee($user->name)
        ->assertSee($user->email);
});


it('can render page with data and search and sort and filter and pagination', function () {
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->set('search', $user->name)
        ->set('sort', 'name')
        ->set('filters', ['name' => $user->name])
        ->set('perPage', 1)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

it('can delete user', function () {
    $user = User::factory()->create();
 
    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction(DeleteAction::class, $user);
 
    $this->assertModelMissing($user);
});

it('can block user', function () {
    $user = User::factory()->create(['status' => 1]);
 
    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction('Block user', $user);

    $user->refresh();

    $this->assertEquals(0, $user->status);
});

it('can unblock user', function () {
    $user = User::factory()->create(['status' => 0]);
 
    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction('Unblock user', $user);

    $user->refresh();
    
    $this->assertEquals(1, $user->status);
});