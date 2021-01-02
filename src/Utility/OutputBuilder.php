<?php


namespace Utility;

use Domain\Student;
use SimpleXMLElement;

/**
 * Class OutputBuilder
 * @package Utility
 *
 * @property Student student;
 */
class OutputBuilder
{
    private Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
        $this->outputData();
    }

    public function outputData(){
        switch ($this->student->board->return_format){
            case "JSON":
                header('Content-Type: application/json');
                try {
                    echo json_encode($this->student, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    echo $e->getMessage();
                }
                break;
            case "XML":
                header('Content-Type: text/xml');
                echo $this->prepareXml(get_object_vars($this->student), new SimpleXMLElement('<student/>'),'grade');
        }
    }

    public function prepareXml($array, SimpleXMLElement $xml, $child_name)
    {
        foreach ($array as $key => $object) {
            $v = $object;
            if(is_object($object)){
                $v = get_object_vars($object);
            }
            if(is_array($v)) {
                (is_int($key)) ? $this->prepareXml($v, $xml->addChild($child_name), $v) : $this->prepareXml($v, $xml->addChild(strtolower($key)), $child_name);
            } else {
                (is_int($key)) ? $xml->addChild($child_name, $v) : $xml->addChild(strtolower($key), $v);
            }
        }

        return $xml->asXML();
    }
}