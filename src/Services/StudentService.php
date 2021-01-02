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
            $student = $this->student->populateModel(null)->getById();
            $student->setPassedFlag($this->evaluateStudentPassed($student));
            return ['success'=>true, 'student' => $student];
        } catch (StudentException $exception) {
            return ['success' => false, 'message' => $exception->getMessage(), 'error_code' => $exception->getCode()];
        }
    }

    private function evaluateStudentPassed(Student $student):bool
    {
        $gradeService = new GradeService();
        $gradeAverage = $gradeService->getAverageOfGrades(array_column($student->grades,'value'));
    }
}