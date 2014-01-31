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

define('SM_PATH', '../../');
require_once(SM_PATH . 'functions/prefs.php');
require_once(SM_PATH . 'functions/i18n.php');
require_once 'latchOperations.php';

global $data_dir, $username;
$latchVariables = array();

if (isset($_POST['pairingToken']) || isset($_POST['unpair'])) {
    $formProcessingOk = processForm();
    if ($formProcessingOk) {
        $latchVariables['notificationMessage'] = _("Operation performed succesfully") . '.';
    } else {
        $latchVariables['errorMessage'] = _("Error performing the operation") . '.';
    }
}

$latchId = getPref($data_dir, $username, 'latchId');
include 'pairingForm.php';

function processForm() {
    sm_validate_security_token($_POST['smtoken'], 3600, TRUE);
    if (isset($_POST['pairingToken'])) {
        return pairAccount();
    } elseif (isset($_POST['unpair'])) {
        return unpairAccount();
    }
}

function pairAccount() {
    global $data_dir, $username;
    $latchId = getPref($data_dir, $username, 'latchId');
    if (empty($latchId)) { // Avoid pairing user twice
        $accountId = pairLatchAccount($_POST['pairingToken']);
        if ($accountId === false) {
            return false;
        } else {
            setPref($data_dir, $username, 'latchId', $accountId);
        }
    }
    return true;
}

function unpairAccount() {
    global $data_dir, $username;
    $latchId = getPref($data_dir, $username, 'latchId');
    unpairLatchAccount($latchId);
    removePref($data_dir, $username, 'latchId');
    return true;
}
