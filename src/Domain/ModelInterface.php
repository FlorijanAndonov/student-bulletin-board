<?php


namespace Domain;


interface ModelInterface
{
    public function getById();
    public function populateModel(?array $data);
}