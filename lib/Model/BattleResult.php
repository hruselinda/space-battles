<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 23-Aug-17
 * Time: 10:44 AM
 */


namespace Model;

use ArrayAccess;

class BattleResult implements ArrayAccess
{
    private $usedJediPowers;

    private $winningShip;

    private $losingShip;

    public function __construct($usedJediPowers, AbstractShip $winningShip = null, AbstractShip $losingShip = null)
    {
        $this->usedJediPowers = $usedJediPowers;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }

    /**
     * @return boolean
     */
    public function wereJediPowersUsed()
    {
        return $this->usedJediPowers;
    }

    /**
     * @return AbstractShip / null
     */
    public function getWinningShip()
    {
        return $this->winningShip;
    }

    /**
     * @return AbstractShip / null
     */
    public function getLosingShip()
    {
        return $this->losingShip;
    }

    public function isThereAWinner(){
        return $this->getWinningShip() !== null;
    }


    /**
     * Making the Obj 'BattleResult' behave like an array using built-in PHP ArrayAcces interface.
     *    battleResult['$winningShip']->getName();    instead of    battleShip->getWinningShip()->getName();
     *
     * @param mixed $offset
     * @return bool
     */

    /* whatever key the user is trying to access  */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    // remove the property
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }


}