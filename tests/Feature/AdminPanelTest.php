<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->user = User::factory()->create(['is_admin' => false]);
});

test('admin can access admin dashboard', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Admin Dashboard');
});

test('regular user cannot access admin dashboard', function () {
    $this->actingAs($this->user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('unauthenticated user cannot access admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect('/login');
});

test('admin can access user management', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.users.index'))
        ->assertSuccessful()
        ->assertSee('User Management');
});

test('admin can access communications', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.communications.index'))
        ->assertSuccessful()
        ->assertSee('Communications');
});

test('admin can access notifications', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.notifications.index'))
        ->assertSuccessful()
        ->assertSee('Notification Management');
});

test('admin middleware blocks non-admin users', function () {
    $this->actingAs($this->user)
        ->get(route('admin.users.index'))
        ->assertForbidden();

    $this->actingAs($this->user)
        ->get(route('admin.communications.index'))
        ->assertForbidden();

    $this->actingAs($this->user)
        ->get(route('admin.notifications.index'))
        ->assertForbidden();
});

test('user model has admin functionality', function () {
    expect($this->admin->isAdmin())->toBeTrue();
    expect($this->user->isAdmin())->toBeFalse();
});
