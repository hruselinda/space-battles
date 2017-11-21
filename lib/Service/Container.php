<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 30-Aug-17
 * Time: 12:05 PM
 */

namespace Service;

use PDO;


class Container
{


    private $configuration;

    private $pdo;

    private $shipLoader;

    private $shipStorage;

    private $battleManager;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return PDO make sure it is only one PDO connection
     */
    public function getPDO(){

     if($this->pdo === null){
         $this->pdo = new PDO(
             $this->configuration['db_dsn'],
             $this->configuration['db_user'],
             $this->configuration['db_pass']
         );
         $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     }
     return $this->pdo;
 }

    /**
     * @return ShipStorageInterface
     */
    public function getShipStorage()
    {

        if($this->shipStorage === null){
          $this->shipStorage = new PDOShipStorage($this->getPDO());      // get the list of the ships from developer's SQL DataBase
          //$this->shipStorage = new JsonFileShipStorage(__DIR__.'/../../resources/ships.json');     // get the list os the ships from teacher's JSON file

            $this->shipStorage = new LoggableShipStorage($this->shipStorage);
        }
        return $this->shipStorage;
    }

    /**
     * @return ShipLoader
     */
    public function getShipLoader()
    {
        if($this->shipLoader === null){
            $this->shipLoader = new ShipLoader($this->getShipStorage());
        }
        return $this->shipLoader;
    }

    /**
     * @return BattleManager
     */
    public function getBattleManager()
    {
        if($this->battleManager === null){
            $this->battleManager = new BattleManager();
        }
        return $this->battleManager;
    }
}