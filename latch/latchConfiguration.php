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

class LatchConfiguration {
    /*
     * Application ID. To get an application ID go to the developer area
     * at https://latch.elevenpaths.com.
     */
    public static $applicationId = "";
    
    /*
     * Application secret. To get the application secret go to the developer area
     * at https://latch.elevenpaths.com.
     */
    public static $applicationSecret = "";
    
    /*
     * Host. Latch remote server location (optional).
     */
    public static $host ="";
}

