<?php
/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 22-Aug-17
 * Time: 3:37 PM
 */

namespace Model;

class Ship extends AbstractShip
{

    use SettableJediFactorTrait;

    private $underRepair;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->underRepair = mt_rand(0, 100) < 20;
    }

    public function isFunctional(){
        return !$this->underRepair;
    }

    public function getType()
    {
        return 'Empire';
    }
}