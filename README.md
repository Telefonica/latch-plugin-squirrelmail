### LATCH SQUIRRELMAIL PLUGIN -- INSTALLATION GUIDE ###

#### PREREQUISITES ####

* RoundCube version 1.4.22 or later.

* Curl extensions active in PHP (uncomment "extension=php_curl.dll" or" extension=curl.so" in Windows or Linux php.ini respectively.

* To get the "Application ID" and "Secret", (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in Latch's website: https://latch.elevenpaths.com. On the upper right side, click on "Developer area".

#### INSTALLING THE MODULE IN ROUNDCUBE ####

1. Once the administrator has downloaded the plugin, it has to be added to the SquirrelMail plugins directory. Extract the 'latch' folder from the ZIP file and copy it to SQUIRRELMAIL_INSTALLATION_DIR/plugins.

2. To enable the plugin, the file SQUIRRELMAIL_INSTALLATION_DIR/config/config.php has to be edited, adding the string 'latch' to the $plugins array. If there isn't any plugin enabled, the $plugins array will not be defined. In that case, just add the line $plugins[] = 'latch' to the end of the file.

3. Once the plugin is enabled, it is necessary to configure the "Application ID" and "Secret" to connect with the Latch API. To configure this, edit the file located at SQUIRRELMAIL_INSTALLATION_DIR/plugins/latchRC/latchConfiguration.php, and set the $applicationId and $applicationSecret static attributes of the LatchConfiguration class.
