<?php


namespace Domain;


interface ModelInterface
{
    public function getById();
    public function setId(int $id);
    public function populateModel(?array $data);
}