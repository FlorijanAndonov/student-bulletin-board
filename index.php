<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__."/vendor/autoload.php");

use Domain\Board;
use Utility\DB;

$db = new DB();

$sql = file_get_contents('src/migrations/db.sql');

var_dump($sql);