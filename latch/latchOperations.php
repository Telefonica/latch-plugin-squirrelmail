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

require_once 'sdk/Error.php';
require_once 'sdk/LatchResponse.php';
require_once 'sdk/Latch.php';
require_once 'latchConfiguration.php';

function pairLatchAccount($pairingToken) {
    $api = getLatchAPIConnection();
    if ($api != NULL) {
        $pairingResponse = $api->pair($pairingToken);
        if (containsAccountId($pairingResponse)) {
            return $pairingResponse->getData()->{"accountId"};
        }
    }
    return false;
}

function containsAccountId($pairingResponse) {
    return $pairingResponse->getData() != NULL &&
            $pairingResponse->getData()->{"accountId"} != NULL;
}

function unpairLatchAccount($accountId) {
    $api = getLatchAPIConnection();
    if ($api != NULL) {
        $api->unpair($accountId);
    }
}

function getLatchStatus($accountId) {
    $appId = LatchConfiguration::$applicationId;
    $api = getLatchAPIConnection();
    if ($api != NULL) {
        $statusResponse = $api->status($accountId);
        if (validateResponseStructure($statusResponse, $appId)) {
            $status = $statusResponse->getData()->{"operations"}->{$appId}->{"status"};
            $returnStatus = array('accountBlocked' => ($status == 'off'));
            if (property_exists($statusResponse->getData()->{"operations"}->{$appId}, "two_factor")) {
                $returnStatus['twoFactor'] = $statusResponse->getData()->{"operations"}->{$appId}->{"two_factor"}->{"token"};
            }
            return $returnStatus;
        }
    }
    return array('accountBlocked' => false);
}

function validateResponseStructure($response, $applicationId) {
    $data = $response->getData();
    return $data != NULL &&
            property_exists($data, "operations") &&
            property_exists($data->{"operations"}, $applicationId) &&
            $response->getError() == NULL;
}

function getLatchAPIConnection() {
    if (checkLatchConfiguration()) {
        setLatchHost();
        return new Latch(LatchConfiguration::$applicationId, LatchConfiguration::$applicationSecret);
    }
    return NULL;
}

function checkLatchConfiguration() {
    return !empty(LatchConfiguration::$applicationId) && !empty(LatchConfiguration::$applicationSecret);
}

function setLatchHost() {
    if (!empty(LatchConfiguration::$host)) {
        Latch::setHost(LatchConfiguration::$host);
    }
}
