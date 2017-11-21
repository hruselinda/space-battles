<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 30-Aug-17
 * Time: 9:13 PM
 */

namespace Model;

class BrokenShip extends AbstractShip
{
    public function getJediFactor()
    {
        return 0;
    }

    public function getType()
    {
        return 'Broken';
    }
    public function isFunctional()
    {
        return false;
    }
}