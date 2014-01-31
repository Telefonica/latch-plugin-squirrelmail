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
?>

<html>
    <head>
        <?php displayHtmlHeader(_('Latch Settings')); ?>
        <style>
            .message {
                padding: 10px;
                width: 400px;
                margin-top: 10px;
                margin-bottom: 20px;
                border: 1px solid;
            }
            .errorMessage {
                background-color: #ffe3e3;
                border-color: #dd0000;
            }
            .notificationMessage {
                background-color: #dfffdf;
                border-color: #005f00;
            }
        </style>
    </head>
    <body>
        <?php
        if (isset($latchVariables['errorMessage'])) {
            echo '<div class="message errorMessage">'
            . $latchVariables['errorMessage']
            . '</div>';
        }
        ?>
        <?php
        if (isset($latchVariables['notificationMessage'])) {
            echo '<div class="message notificationMessage">'
            . $latchVariables['notificationMessage']
            . '</div>';
        }
        ?>
        <?php if (empty($latchId)) { // The user is not paired ?>
            <h3>
                <?php echo _("Your account is not protected yet"); ?>
            </h3>
            <p>
                <?php echo _("To protect your account with Latch, insert a pairing token."); ?>
            </p>
        <?php } else { ?>
            <h3>
                <?php echo _("Your account is protected with Latch"); ?>
            </h3>
            <p>
                <?php echo _("To stop using Latch and unprotect your account, press the button below."); ?>
            </p>
        <?php } ?>

        <form method="post" atcion="options.php">
            <input type="hidden" name="smtoken" value="<?php echo sm_generate_security_token() ?>">
            <input type="hidden" name="optpage" value="latch">
            <input type="hidden" name="optmode" value="submit">
            <?php if (empty($latchId)) { // The user is not paired ?>
                <label for="pairingToken"><?php echo _("Type your pairing token") ?>:</label>
                <input type="text" name="pairingToken">
                <input type="submit" value="Pair account">
            <?php } else { // The user is paired ?>
                <input type="hidden" name="unpair" value="1">
                <input type="submit" value="Unpair account">
            <?php } ?>
        </form>

    </body>
