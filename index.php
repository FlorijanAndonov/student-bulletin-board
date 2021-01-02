<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/vendor/autoload.php");

use Services\StudentService;

echo "<pre>";
$studentService = new StudentService();
$studentId = $_GET['student'];

if(filter_var($studentId,FILTER_VALIDATE_INT)){
    print_r($studentService->getStudent($studentId));
} else {
    echo "invalid student id";
}
