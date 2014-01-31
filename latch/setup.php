<?php

/*
Latch SquirrelMail extension - Integrates Latch into the SquirrelMail authentication process.
Copyright (C) 2013 Eleven Paths

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once(SM_PATH . 'functions/page_header.php');
require 'latchOperations.php';

function squirrelmail_plugin_init_latch() {
    global $squirrelmail_plugin_hooks;

    // Hook preferences menu to add a Latch section
    $squirrelmail_plugin_hooks['optpage_register_block']['latch'] = 'latchSettings';

    // Hook authentication
    $squirrelmail_plugin_hooks['login_verified']['latch'] = 'latchHookAfterLogin';
}

/*
 * Includes the Latch settings section in the SquirrelMail options.
 */
function latchSettings() {
    global $optpage_blocks;
    bindtextdomain('latch', SM_PATH . 'locale');
    textdomain('latch');
    $optpage_blocks[] = array(
        'name' => _("Latch settings"),
        'url' => SM_PATH . 'plugins/latch/options.php',
        'desc' => _("Change your Latch settings."),
        'js' => FALSE
    );
}

/*
 * Hooks Latch into the SquirrelMail authentication process.
 */
function latchHookAfterLogin() {
    if (isset($_POST['latchTwoFactor'])) {
        global $data_dir, $username;
        $storedToken = getPref($data_dir, $username, 'latchTwoFactor');
        removePref($data_dir, $username, 'latchTwoFactor');
        if ($storedToken != $_POST['latchTwoFactor']) {
            makeLoginFail();
        }
    } elseif (isLatchAccountBlocked()) {
        makeLoginFail();
    }
}

function makeLoginFail() {
    sqsession_destroy();
    header("Location: login.php");
    exit();
}

function isLatchAccountBlocked() {
    global $data_dir, $username;
    $latchId = getPref($data_dir, $username, 'latchId');
    if (!empty($latchId)) {
        $status = getLatchStatus($latchId);
        if (isset($status['twoFactor'])) {
            setPref($data_dir, $username, 'latchTwoFactor', $status['twoFactor']);
            sqsession_destroy(); // The user cannot be authenticated yet
            loadSecondFactorForm();
        }
        return $status['accountBlocked'];
    }
    return false;  // Not paired accounts
}

function loadSecondFactorForm() {
    include 'twoFactorForm.php';
    exit();
}