<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 30-Aug-17
 * Time: 2:18 PM
 */


namespace Model;

class RebelShip extends AbstractShip
{
    public function getFavouriteJedi()
    {
        $coolJedi = array('Yoda', 'Ben Kenobi');
        $oneOfThem = array_rand($coolJedi);

        return $coolJedi[$oneOfThem];
    }

    public function getType()
    {
        return 'Rebel';
    }
    public function isFunctional(){
        return true;
    }

    /**
     * @param bool $useShortFormat
     * @return string
     */
    public function getNameAndSpecs($useShortFormat = true)
    {
        $rebelAddition = parent::getNameAndSpecs($useShortFormat);
        $rebelAddition .= ' (Rebel)';

        return $rebelAddition;
    }
    public function getJediFactor()
    {
        return rand(10, 20);
    }

}