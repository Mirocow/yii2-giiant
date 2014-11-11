<?php

namespace pafnow\giiant\base;


use yii\base\Object;

class Provider extends Object
{
    /**
     * @var \pafnow\giiant\crud\Generator
     */
    public $generator;
    public $columnNames = [''];
} 