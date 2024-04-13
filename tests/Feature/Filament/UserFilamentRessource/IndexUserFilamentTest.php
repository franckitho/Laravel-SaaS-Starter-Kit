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
    
    Permission::create([
        'name' => 'UserFilament',
        'guard_name' => 'filament'
    ]);

    Permission::create([
        'name' => 'view-any UserFilament',
        'guard_name' => 'filament'
    ]);

    Permission::create([
        'name' => 'view UserFilament',
        'guard_name' => 'filament'
    ]);

    Permission::create([
        'name' => 'delete UserFilament',
        'guard_name' => 'filament'
    ]);

    $this->user->givePermissionTo(['view-any UserFilament', 'view UserFilament', 'delete UserFilament',  'UserFilament']);
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
        ->set('search', $user->name)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can render page with data and search and sort', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();

    livewire(ListUserFilaments::class)
        ->set('search', $user->name)
        ->set('sort', 'name')
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('can render page with data and search and sort and filter', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();

    livewire(ListUserFilaments::class)
        ->set('search', $user->name)
        ->set('sort', 'name')
        ->set('filters', ['name' => $user->name])
        ->assertSee($user->name)
        ->assertSee($user->email);
});


test('can render page with data and search and sort and filter and pagination', function () {
    $this->actingAs($this->user, 'filament');
    $user = UserFilament::factory()->create();

    livewire(ListUserFilaments::class)
        ->set('search', $user->name)
        ->set('sort', 'name')
        ->set('filters', ['name' => $user->name])
        ->set('perPage', 1)
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