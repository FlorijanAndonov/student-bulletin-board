<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/vendor/autoload.php");

use Services\StudentService;
use Utility\OutputBuilder;

$studentService = new StudentService();
$studentId = $_GET['student'];

if(filter_var($studentId,FILTER_VALIDATE_INT)){
    $studentData = $studentService->getStudent($studentId);
    if ($studentData['success'] === false){
        echo $studentData['message'];
        die();
    }

    $output = new OutputBuilder($studentData['student']);
} else {
    echo "invalid student id";
}
