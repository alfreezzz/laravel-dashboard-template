<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(Tests\TestCase::class);

beforeEach(function () {
    \Artisan::call('view:clear');
});

uses(RefreshDatabase::class);

it('shows the login page', function () {
    $this->get('/login')
        ->assertStatus(200)
        ->assertSee('Masuk');
});

it('shows register page when enabled', function () {
    config(['auth.registration_enabled' => true]);
    $this->get('/register')->assertStatus(200)->assertSee('Buat Akun Baru');
});

it('returns 404 for register when disabled', function () {
    config(['auth.registration_enabled' => false]);
    $this->get('/register')->assertStatus(404);
});

it('cannot access admin dashboard without authentication', function () {
    $this->get('/admin')->assertRedirect('/login');
});

it('normal user registration leads to user dashboard and denies admin access', function () {
    config(['auth.registration_enabled' => true]);

    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $this->post('/register', $data)
        ->assertRedirect('/user');

    $this->assertAuthenticated();
    $this->assertEquals('user', auth()->user()->role);
    $this->get('/admin')->assertStatus(403);
});

it('admin user can log in and access admin area only', function () {
    $admin = User::factory()->create([
        'password' => Hash::make('secret123'),
        'role' => 'admin',
    ]);

    $this->post('/login', ['email' => $admin->email, 'password' => 'secret123'])
        ->assertRedirect('/admin');

    $this->get('/admin')->assertStatus(200)->assertSee('Dashboard');

    // admin should not be able to hit user area if restricted
    $this->get('/user')->assertStatus(403);
});

it('normal user after login is sent to user dashboard and blocked from admin', function () {
    $user = User::factory()->create([
        'password' => Hash::make('secret123'),
        'role' => 'user',
    ]);

    $this->post('/login', ['email' => $user->email, 'password' => 'secret123'])
        ->assertRedirect('/user');

    $this->get('/user')->assertStatus(200)->assertSee('Selamat Datang');
    $this->get('/admin')->assertStatus(403);

    // both roles should reach settings
    $this->get('/settings')->assertStatus(200)->assertSee('Pengaturan');
});

it('admin user can also access settings', function () {
    $admin = User::factory()->create([
        'password' => Hash::make('secret123'),
        'role' => 'admin',
    ]);

    $this->post('/login', ['email' => $admin->email, 'password' => 'secret123']);
    $this->get('/settings')->assertStatus(200)->assertSee('Pengaturan');
});

it('inactive account cannot log in', function () {
    $user = User::factory()->create([
        'password' => Hash::make('secret123'),
        'is_active' => false,
    ]);

    $this->post('/login', ['email' => $user->email, 'password' => 'secret123'])
        ->assertStatus(302)
        ->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('admin cannot delete themselves', function () {
    $admin = User::factory()->create([
        'password' => Hash::make('secret123'),
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->delete('/admin/users/' . $admin->id)
        ->assertStatus(403);
});

it('admin can deactivate another account via toggle', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $other = User::factory()->create(['is_active' => true]);

    $this->actingAs($admin)
        ->patch('/admin/users/' . $other->id . '/toggle')
        ->assertRedirect('/admin/users');

    $this->assertFalse($other->fresh()->is_active);
});

it('admin cannot deactivate self via toggle', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->patch('/admin/users/' . $admin->id . '/toggle')
        ->assertStatus(403);
});

it('admin cannot deactivate self when editing profile', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->put('/admin/users/' . $admin->id, [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'admin',
            'is_active' => false,
        ])
        ->assertStatus(403);
});

it('admin user sees user management link and can view index', function () {
    $admin = User::factory()->create([
        'password' => Hash::make('secret123'),
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->get('/admin/users')
        ->assertStatus(200)
        ->assertSee('Master Pengguna');
});

it('admin user can create a new user through the CRUD form', function () {
    $admin = User::factory()->create([
        'password' => Hash::make('secret123'),
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->post('/admin/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'user',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ])
        ->assertRedirect('/admin/users');

    $this->assertDatabaseHas('users', ['email' => 'newuser@example.com', 'is_active' => true]);
});

it('settings page shows profile, theme, and password tabs', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    $this->actingAs($user)
        ->get('/settings')
        ->assertStatus(200)
        ->assertSee('Profil')
        ->assertSee('Tampilan')
        ->assertSee('Password');
});

it('user can update profile settings', function () {
    $user = User::factory()->create(['name' => 'Old', 'email' => 'old@example.com']);

    $this->actingAs($user)
        ->post('/settings', ['name' => 'New', 'email' => 'new@example.com'], ['HTTP_REFERER' => '/settings'])
        ->assertRedirect('/settings')
        ->assertSessionHas('success', 'Profil diperbarui');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New',
        'email' => 'new@example.com',
    ]);
});

it('user can change password with correct current password', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    $this->actingAs($user)
        ->post('/settings/password', [
            'old_password' => 'secret123',
            'new_password' => 'newpass123',
            'new_password_confirmation' => 'newpass123',
        ], ['HTTP_REFERER' => '/settings'])
        ->assertRedirect('/settings')
        ->assertSessionHas('success', 'Password berhasil diubah');

    $this->assertTrue(Hash::check('newpass123', $user->fresh()->password));
});

it('password change fails with incorrect current password', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    $response = $this->actingAs($user)->post('/settings/password', [
        'old_password' => 'wrong',
        'new_password' => 'newpass123',
        'new_password_confirmation' => 'newpass123',
    ], ['HTTP_REFERER' => '/settings']);

    $response->assertRedirect('/settings');
    $response->assertSessionHasErrors('old_password');
});

// notification system tests (basic scaffolding)
it('user has notifications relationship', function () {
    $user = User::factory()->create();
    \App\Models\Notification::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->notifications()->count())->toBe(3);
});

it('navbar displays unread count', function () {
    $user = User::factory()->create();
    \App\Models\Notification::factory()->create(['user_id' => $user->id]);
    \App\Models\Notification::factory()->create(['user_id' => $user->id, 'read_at' => now()]);

    $this->actingAs($user)
        ->get('/user')
        ->assertSee('1');
});

it('notification dropdown shows link to view all', function () {
    $user = User::factory()->create();
    \App\Models\Notification::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/user');
    // because the dropdown requires JS, just ensure the anchor exists in rendered HTML
    $response->assertSee('Lihat semua');
});

it('mark all read route clears unread notifications', function () {
    $user = User::factory()->create();
    \App\Models\Notification::factory()->count(3)->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->patch('/notifications/read-all')
        ->assertRedirect();

    $this->assertDatabaseCount('notifications', 3);
    $this->assertDatabaseMissing('notifications', ['user_id' => $user->id, 'read_at' => null]);
});

it('notifications index shows messages', function () {
    $user = User::factory()->create();
    $n1 = \App\Models\Notification::factory()->create(["user_id" => $user->id, 'data' => ['message' => 'Hello']]);
    $n2 = \App\Models\Notification::factory()->create(["user_id" => $user->id, 'data' => ['message' => 'World']]);

    $this->actingAs($user)
        ->get('/notifications')
        ->assertStatus(200)
        ->assertSee('Hello')
        ->assertSee('World');
});
