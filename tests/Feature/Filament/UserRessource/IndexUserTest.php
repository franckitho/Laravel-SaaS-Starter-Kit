<?php

use App\Models\User;
use function Pest\Livewire\livewire;
use App\Models\Filament\UserFilament;
use App\Filament\Resources\UserResource;
use Spatie\Permission\Models\Permission;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\UserResource\Pages\ListUsers;

beforeEach(function () {
    $this->user = UserFilament::factory()->create();
    $this->user->assignRole(['filament.admin']);
});

test('can render page', function () {
    $this->actingAs($this->user, 'filament');

    livewire(ListUsers::class)->assertSuccessful();
});

test('can render page with data', function () {
    $this->actingAs($this->user, 'filament');
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can render page with data and search', function () {
    $this->actingAs($this->user, 'filament');
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->searchTable($user->name)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can render page with data and search and sort', function () {
    $this->actingAs($this->user, 'filament');
    $user = User::factory()->create();

    livewire(ListUsers::class)
        ->searchTable($user->name)
        ->sortTable('name', 'desc')
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can delete user', function () {
    $this->actingAs($this->user, 'filament');
    $user = User::factory()->create();
 
    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction(DeleteAction::class, $user->id);
    $user->refresh();
    $this->assertTrue($user->trashed());
});

test('can block user', function () {
    $this->actingAs($this->user, 'filament');
    $user = User::factory()->create(['status' => 1]);
 
    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction('Block user', $user);

    $user->refresh();

    $this->assertEquals(0, $user->status);
});

test('can unblock user', function () {
    $this->actingAs($this->user, 'filament');
    $user = User::factory()->create(['status' => 0]);
 
    livewire(UserResource\Pages\ListUsers::class)
        ->callTableAction('Unblock user', $user);

    $user->refresh();
    
    $this->assertEquals(1, $user->status);
});