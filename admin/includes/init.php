<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROUTE') ? null : define('SITE_ROUTE', DS. 'Users' . DS . 'claytondarlington' .DS . 'Sites'. DS . 'photo');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROUTE . DS . 'admin' .DS. 'includes');



require_once("functions.php");
require_once("newConfig.php");
require_once("database.php");
require_once("dbObject.php");
require_once("user.php");
require_once("session.php");
require_once("photo.php");
require_once("comment.php");
require_once("paginate.php");
?>