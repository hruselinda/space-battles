<?php

/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 31-Aug-17
 * Time: 10:57 AM
 */

namespace Service;

interface ShipStorageInterface
{
    /**
     * @return array
     *
     * Returns an array of ship arrays, with key id, name, weaponpower, defence
     */
    public function fetchAllShipsData();

    /**
     * @param integer $id
     * @return array
     */
    public function fetchSingleShipData($id);
}