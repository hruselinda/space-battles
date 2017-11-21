<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 30-Aug-17
 * Time: 9:29 PM
 */


namespace Service;

use PDO;

class PDOShipStorage implements ShipStorageInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function fetchAllShipsData()
    {
        $pdo = $this->pdo;
        $statement = $pdo->prepare('SELECT * FROM ship');
        $statement->execute();
        $shipsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $shipsArray;
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function fetchSingleShipData($id)
    {
        $pdo = $this->pdo;
        $statement = $pdo->prepare('SELECT * FROM ship WHERE id =:id');
        $statement->execute(['id' => $id ]);
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$shipArray){
            return null;
        }

        return $shipArray;
    }
}