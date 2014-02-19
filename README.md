#LATCH INSTALLATION GUIDE FOR SQUIRRELMAIL


##PREREQUISITES
* SquirrelMail version 1.4.22 or later.

* Curl extensions active in PHP (uncomment **"extension=php_curl.dll"** or"** extension=curl.so"** in Windows or Linux php.ini respectively.

* To get the **"Application ID"** and **"Secret"**, (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in [Latch's website]( https://latch.elevenpaths.com"https://latch.elevenpaths.com") On the upper right side, click on **"Developer area"**.


##DOWNLOADING THE SQUIRRELMAIL PLUGIN
 * When the account is activated, the user will be able to create applications with Latch and access to developer documentation, including existing SDKs and plugins. The user has to access again to [Developer area](https://latch.elevenpaths.com/www/developerArea"https://latch.elevenpaths.com/www/developerArea"), and browse his applications from **"My applications"** section in the side menu.

* When creating an application, two fundamental fields are shown: **"Application ID"** and **"Secret"**, keep these for later use. There are some additional parameters to be chosen, as the application icon (that will be shown in Latch) and whether the application will support OTP  (One Time Password) or not.

* From the side menu in developers area, the user can access the **"Documentation & SDKs"** section. Inside it, there is a **"SDKs and Plugins"** menu. Links to different SDKs in different programming languages and plugins developed so far, are shown.


##INSTALLING THE PLUGIN IN SQUIRRELMAIL
* Once the administrator has downloaded the plugin, it has to be added to the SquirrelMail plugins directory. Extract the 'latch' folder from the ZIP file and copy it to SQUIRRELMAIL_INSTALLATION_DIR/plugins.

* To enable the plugin, the file SQUIRRELMAIL_INSTALLATION_DIR/config/config.php has to be edited, adding the string 'latch' to the $plugins array. If there isn't any plugin enabled, the $plugins array will not be defined. In that case, just add the line $plugins[] = 'latch' to the end of the file.

* Once the plugin is enabled, it is necessary to configure the **"Application ID"** and **"Secret"** to contact with the Latch API. To configure this, edit the file located at SQUIRRELMAIL_INSTALLATION_DIR/plugins/latch/latchConfiguration.php, in the $applicationId and $applicationSecret static attributes of the LatchConfiguration class.


##UNINSTALLING THE PLUGIN IN SQUIRRELMAIL
* To uninstall Latch, just comment out the line added above, this way: **//$plugins[] = 'latch'**