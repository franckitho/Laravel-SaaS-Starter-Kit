<?php

use App\Filament\Resources\UserFilamentResource\Pages\ListUserFilaments;
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

    livewire(ListUserFilaments::class)->assertSuccessful();
});

test('can render page with data', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();

    livewire(ListUserFilaments::class)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can render page with data and search', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();

    livewire(ListUserFilaments::class)
        ->searchTable($user->name)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can render page with data and search and sort', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();

    livewire(ListUserFilaments::class)
        ->searchTable($user->name)
        ->sortTable('name', 'desc')
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can delete user', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();
 
    livewire(ListUserFilaments::class)
        ->callTableAction(DeleteAction::class, $user->id);
        
    $this->assertNull($user->fresh());
});