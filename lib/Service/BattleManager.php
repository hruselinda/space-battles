<?php
/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 23-Aug-17
 * Time: 9:56 AM
 */

namespace Service;

use Model\BattleResult;
use Model\AbstractShip;

class BattleManager{

    // normal battle type
    const BATTLE_TYPE_NORMAL = 'normal';
    // no jedi powers for the battle
    const BATTLE_TYPE_NO_JEDI = 'no_jedi';
    // only jedi powers for the battle
    const BATTLE_TYPE_ONLY_JEDI = 'only_jedi';

    /**
     * @param AbstractShip $ship1
     * @param $ship1Quantity
     * @param AbstractShip $ship2
     * @param $ship2Quantity
     * @param $battleType
     * @return BattleResult
     *
     * Our battle algorythm
     */
    public function battle(AbstractShip $ship1, $ship1Quantity, AbstractShip $ship2, $ship2Quantity, $battleType){

        $ship1Health = $ship1->getStrength() * $ship1Quantity;
        $ship2Health = $ship2->getStrength() * $ship2Quantity;

        $ship1UsedJediPowers = false;
        $ship2UsedJediPowers = false;
        $i = 0;
        while ($ship1Health > 0 && $ship2Health > 0) {
            // first, see if we have a rare Jedi hero event!
            if ($battleType != self::BATTLE_TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship1)) {
                $ship2Health = 0;
                $ship1UsedJediPowers = true;

                break;
            }
            if ($battleType != self::BATTLE_TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship2)) {
                $ship1Health = 0;
                $ship2UsedJediPowers = true;

                break;
            }

            // now battle them normally
            if($battleType != self::BATTLE_TYPE_ONLY_JEDI)
            {
                $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
                $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
            }

            if($i == 100)
            {
                $ship1Health = 0;
                $ship2Health = 0;
            }
            $i++;
        }

        $ship1->setStrength($ship1Health);
        $ship2->setStrength($ship2Health);

        if ($ship1Health <= 0 && $ship2Health <= 0) {
            // they destroyed each other
            $winningShip = null;
            $losingShip = null;
            $usedJediPowers = $ship1UsedJediPowers || $ship2UsedJediPowers;
        } elseif ($ship1Health <= 0) {
            $winningShip = $ship2;
            $losingShip = $ship1;
            $usedJediPowers = $ship2UsedJediPowers;
        } else {
            $winningShip = $ship1;
            $losingShip = $ship2;
            $usedJediPowers = $ship1UsedJediPowers;
        }

        return new BattleResult($usedJediPowers, $winningShip, $losingShip);

    }

    /**
     * @return array battle types and their names
     */
    public static function getAllBattleTypesWithDescription()
    {
        return array(
            self::BATTLE_TYPE_NORMAL => 'Full power',
            self::BATTLE_TYPE_NO_JEDI => 'No Jedi powers',
            self::BATTLE_TYPE_ONLY_JEDI => 'Only Jedi powers'
        );
    }

    private function didJediDestroyShipUsingTheForce(AbstractShip $ship)
    {
        $jediHeroProbability = $ship->getJediFactor() / 100;

        return mt_rand(1, 100) <= ($jediHeroProbability*100);
    }
}