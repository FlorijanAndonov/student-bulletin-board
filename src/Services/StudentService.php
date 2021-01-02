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
        if ($student->board->discard_lowest){
            array_shift($student->grades);
        }
        $gradeAverage = $gradeService->getAverageOfGrades(array_column($student->grades,'value'));
        if ($student->board->minimum_grades > 0){
            $enoughGrades = count($student->grades) > $student->board->minimum_grades;
        } else {
            $enoughGrades = true;
        }
        return $gradeAverage > $student->board->passing_average && $enoughGrades;
    }
}