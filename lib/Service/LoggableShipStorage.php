<?php
/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 04-Sep-17
 * Time: 3:55 PM
 */

namespace Service;


class LoggableShipStorage implements ShipStorageInterface
{

    private $shipStorage;

    private function log($message)
    {
        echo $message;
    }


    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

    public function fetchAllShipsData()
    {
        $ships = $this->shipStorage->fetchAllShipsData();

       // $this->log(sprintf('We have %s ships', count($ships)));

        return $ships;
    }

    public function fetchSingleShipData($id)
    {
        return $this->shipStorage->fetchSingleShipData($id);
    }
}