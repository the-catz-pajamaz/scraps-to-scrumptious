<?php
require_once dirname(__DIR__, 3) . "/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use TheCatzPajamaz\ScrapsToScrumptious\{User, Recipe, Cookbook};

/**
 * api for handing sign-in
 */

