<?php

namespace Services;

use Domain\Student;
use Utility\Exceptions\Student\StudentException;

class StudentService
{
    private $student;

    public function __construct()
    {
        $this->student = new Student();
    }

    public function getStudent(?int $id)
    {
        $this->student->setId($id);
        try {

            return ['success'=>true, 'student' => $this->student->populateModel(null)->getById()];
        } catch (StudentException $exception) {
            return ['success' => false, 'message' => $exception->getMessage(), 'error_code' => $exception->getCode()];
        }
    }
}