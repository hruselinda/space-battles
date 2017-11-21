<?php
/**
 * Created by PhpStorm.
 * User: Hrus
 * Date: 04-Sep-17
 * Time: 3:23 PM
 */

namespace Model;


trait SettableJediFactorTrait
{

    private $jediFactor;

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function setJediFactor($jediFactor)
    {
        $this->jediFactor = $jediFactor;
    }
}