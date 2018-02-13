<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Pterodactyl\Models\User;
use Tests\Traits\DatabaseTruncations;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLoginFailsWithInvalidCredentials()
    {
        $this->browse(function ($browser) {
            $browser->visit('/auth/login')
                ->type('user', 'fake')
                ->type('password', 'fake')
                ->press(trans('auth.sign_in'))
                ->assertSee(trans('auth.auth_error'));
        });
    }

    public function testLoginSucceedsWithValidCredentialsAndCanLogout()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/')
                ->assertPathIs('/auth/login')
                ->type('user', $user->email)
                ->type('password', 'password')
                ->press(trans('auth.sign_in'))
                ->assertPathIs('/')
                ->assertSee($user->name_first)
                ->click('#logoutButton')
                ->assertPathIs('/auth/login')
                ->assertSee(trans('auth.authentication_required'))
                ->visit('/account')
                ->assertPathIs('/auth/login');
        });
    }
}