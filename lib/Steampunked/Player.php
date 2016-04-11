<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/15/16
 * Time: 6:18 PM
 */

namespace Steampunked;


class Player
{
    public function __construct($name, $userid, $turn)
    {
        $this->name = $name;
        $this->userid = $userid;

        for ($i = 0; $i < 5; $i++) {
            $this->selections[] = new Tile(Tile::PIPE, $turn);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSelection($pipe, $ndx)
    {
        if ($ndx >=0 and $ndx < 5) {
            $this->selections[$ndx] = $pipe;
        }
    }

    public function getSelections()
    {
        return $this->selections;
    }

    public function getUserid() {
        return $this->userid;
    }

    private $name;
    private $selections;
    private $userid;
}