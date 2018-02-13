<?php

namespace Tests\Browser\Pages\User;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class MyAccount extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/account';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
        $browser->assertSee(trans('base.account.header_sub'));
    }

    public function updateIdentity(Browser $browser, $firstName, $lastName, $username)
    {
        $browser->type('name_first', $firstName)
            ->type('name_last', $lastName)
            ->type('username', $username)
            ->press(trans('base.account.update_identity'));
    }

    public function updateEmail(Browser $browser, $newEmail, $currentPassword)
    {
        $browser->type('new_email', $newEmail)
            ->type('current_password', $currentPassword)
            ->press(trans('base.account.update_email'));
    }

    public function updatePassword(Browser $browser, $currentPassword, $newPassword, $newPasswordConfirmation=null)
    {
        $newPasswordConfirmation = $newPasswordConfirmation ?? $newPassword;

        $browser->type('current_password', $currentPassword)
            ->type('new_password', $newPassword)
            ->type('new_password_confirmation', $newPasswordConfirmation)
            ->press(trans('base.account.update_pass'));
    }

}