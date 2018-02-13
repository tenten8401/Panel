<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Pterodactyl\Models\User;
use Tests\Traits\DatabaseTruncations;
use Tests\Browser\Pages\User\MyAccount;

class MyAccountTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUpdatePasswordWithValidInformation()
    {
        $user = factory(User::class)->create();
        $newUser = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user, $newUser) {
            $browser->loginAs($user)
                ->visit(new MyAccount())
                ->updatePassword($newUser->name_first, $newUser->name_last, $newUser->username)
                ->assertSee(trans('base.account.details_updated'))
                ->assertInputValue('name_first', $newUser->name_first)
                ->assertInputValue('name_last', $newUser->name_last)
                ->assertInputValue('username', $newUser->username);
        });
    }

    public function testUpdatePasswordWithInvalidCurrentPassword()
    {
        $user = factory(User::class)->create();
        $newUser = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user, $newUser) {
            $browser->loginAs($user)
                ->visit(new MyAccount())
                ->updatePassword($newUser->name_first, $newUser->name_last, $newUser->username)
                ->assertSee(trans('base.account.details_updated'))
                ->assertInputValue('name_first', $newUser->name_first)
                ->assertInputValue('name_last', $newUser->name_last)
                ->assertInputValue('username', $newUser->username);
        });
    }

    public function testUpdatePasswordWithInvalidPasswordConfirmation()
    {
        $user = factory(User::class)->create();
        $newUser = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user, $newUser) {
            $browser->loginAs($user)
                ->visit(new MyAccount())
                ->updatePassword($newUser->name_first, $newUser->name_last, $newUser->username)
                ->assertSee(trans('base.account.details_updated'))
                ->assertInputValue('name_first', $newUser->name_first)
                ->assertInputValue('name_last', $newUser->name_last)
                ->assertInputValue('username', $newUser->username);
        });
    }

    public function testUpdateIdentity()
    {
        $user = factory(User::class)->create();
        $newUser = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user, $newUser) {
            $browser->loginAs($user)
                ->visit(new MyAccount())
                ->updateIdentity($newUser->name_first, $newUser->name_last, $newUser->username)
                ->assertSee(trans('base.account.details_updated'))
                ->assertInputValue('name_first', $newUser->name_first)
                ->assertInputValue('name_last', $newUser->name_last)
                ->assertInputValue('username', $newUser->username);
        });
    }

}