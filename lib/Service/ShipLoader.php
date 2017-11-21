<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 23-Aug-17
 * Time: 10:17 AM
 */

namespace Service;

use Model\BountyHunterShip;
use PDOException;
use Model\ShipCollection;
use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;

class ShipLoader
{

    private $shipStorage;

    /**
     * ShipLoader constructor.
     * @param \Service\ShipStorageInterface $shipStorage
     */
    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

    /**
     * @return ShipCollection ( a Model class wrapper for the ships )
     */
    public function getShips()
    {
        try {
            $shipsData = $this->shipStorage->fetchAllShipsData();
        } catch (PDOException $e) {
            trigger_error('Database Exception! '.$e->getMessage());
            $shipsData = [];
        }


        $ships = array();
        foreach($shipsData as $shipData){
            $ships[] = $this->createShipFromData($shipData);
        }

        //$ships[] = new BountyHunterShip('Bounty Coco');

        return new ShipCollection($ships);
    }

    /**
     * @param $id
     * @return null|AbstractShip
     */
    public function findOneById($id)
    {
        $shipArray = $this->shipStorage->fetchSingleShipData($id);
        return $this->createShipFromData($shipArray);
    }

    private function createShipFromData(array $shipData)
    {
        if($shipData['team'] == 'rebel'){
            $ship = new RebelShip($shipData['name']);
        } else {
        $ship = new Ship($shipData['name']);
        $ship->setJediFactor($shipData['jedi_factor']);
        }

        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }
}