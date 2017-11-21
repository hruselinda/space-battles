<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 30-Aug-17
 * Time: 6:41 PM
 */

namespace Model;

use Exception;

abstract class AbstractShip
{

    private $id;
    private $name;
    private $weaponPower = 2;
    private $strength = 3;

    abstract public function getJediFactor();
    abstract public function getType();
    abstract public function isFunctional();

    /**
     * Ship constructor.
     */
    public function __construct($name){
        $this->name = $name;
    }


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return int
     */
    public function getWeaponPower()
    {
        return $this->weaponPower;
    }

    /**
     * @param int $weaponPower
     */
    public function setWeaponPower($weaponPower)
    {
        $this->weaponPower = $weaponPower;
    }


    /**
     * @param $strength
     * @throws Exception
     */
    public function setStrength($strength){
        if(!is_numeric($strength)){
            throw new Exception('Invalid strength ' . $strength);
        }
        $this->strength = $strength;
    }

    /**
     * @return int
     */
    public function getStrength()
    {
        return $this->strength;
    }


    /**
     * @param bool $useShortFormat
     * @return string
     */
    public function getNameAndSpecs($useShortFormat = true){
        if ($useShortFormat){
            return sprintf(
                '%s %s/%s/%s',
                $this -> name,
                $this -> weaponPower,
                $this -> getJediFactor(),
                $this -> strength
            );
        } else {
            return sprintf(
                '%s w:%s j:%s s:%s',
                $this -> name,
                $this -> weaponPower,
                $this -> getJediFactor(),
                $this -> strength
            );
        }
    }

    public function isThisShipStronger($givenShip){
        return $this -> strength > $givenShip -> strength;
    }


    public function __get($name)
    {
        $file = dirname(dirname(__DIR__)) . DS . 'log.txt';
        $message = date(DATE_ATOM ) . " Non-existing or non-accessable property '$name' has been called" . PHP_EOL;

        file_put_contents($file, $message, FILE_APPEND);

        throw new Exception($name.' could not be accessed!');
    }

}