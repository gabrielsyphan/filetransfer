<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Files extends DataLayer
{
    public function __construct()
    {
        parent::__construct("files", [], 'id', false);
    }
}
