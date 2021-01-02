<?php


namespace Services;


use Domain\Grade;

/**
 * Class GradeService
 * @package Services
 *
 * @property Grade $grade
 */
class GradeService
{
    private $grade;

    public function __construct()
    {
        $this->grade = new Grade();
    }

    public function getStudentGrades(int $studentId)
    {
        return $this->grade->getStudentsGrades($studentId)['list'];
    }

    public function getAverageOfGrades(array $grades)
    {
        return array_sum($grades) / count($grades);
    }
}