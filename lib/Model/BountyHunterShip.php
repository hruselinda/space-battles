<?php
/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 04-Sep-17
 * Time: 3:13 PM
 */

namespace Model;
//to use, uncomment it in ShipLoader/getShips();

class BountyHunterShip extends AbstractShip
{
    use SettableJediFactorTrait;

    public function getType()
    {
        return 'Bounty Hunter';
    }

    public function isFunctional()
    {
        return true;
    }

}