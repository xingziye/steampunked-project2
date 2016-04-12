<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/15/16
 * Time: 6:07 PM
 */

namespace Steampunked;


class Tile
{
    const PIPE = 0;
    const LEAK = 1;
    const VALVE_CLOSE = 2;
    const VALVE_OPEN = 3;
    const GAUGE0 = 4;
    const GAUGE190 = 5;
    const GAUGE_TOP0 = 6;
    const GAUGE_TOP190 = 7;
    const PIPE_TO_SELECT = 8;

    public function __construct($type, $playerID)
    {
        $this->type = $type;
        $this->id = $playerID;

        if ($type == Tile::PIPE or $type == Tile::PIPE_TO_SELECT) {
            $this->randOpen();
        } elseif ($type == Tile::VALVE_CLOSE) {
            $this->open = array("N"=>false, "E"=>true, "S"=>false, "W"=>false);
        } elseif ($type == Tile::GAUGE0) {
            $this->open = array("N"=>false, "E"=>false, "S"=>false, "W"=>true);
        }
    }

    public function rotate() {
        $temp = $this->open["N"];
        $this->open["N"] = $this->open["W"];
        $this->open["W"] = $this->open["S"];
        $this->open["S"] = $this->open["E"];
        $this->open["E"] = $temp;
    }

    public function indicateLeaks() {

        if($this->flag) {
            // Already visited
            return false;
        }

        $this->flag = true;

        $open = $this->open();
        foreach(array("N", "W", "S", "E") as $direction) {
            // Are we open in this direction?
            if($open[$direction]) {
                $n = $this->neighbor($direction);
                if($n === null) {
                    // We have a leak in this direction...
                    return true;
                } else {
                    // Recurse
                    if ($n->indicateLeaks()) {
                        return true;
                    }
                }
            }
        }
        return false;

    }

    /**
     * @return boolean
     */
    public function isFlag()
    {
        return $this->flag;
    }

    /**
     * @param boolean $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @param Tile
     * @param string
     */
    public function setNeighbor(&$neighbor, $direction)
    {
        $this->neighbors[$direction] = $neighbor;
        if ($this->type == Tile::LEAK) {
            $this->open = array("N"=>false, "E"=>false, "S"=>false, "W"=>false);
            $this->setOpenDirection($direction);
        }
    }

    public function neighbor($direction)
    {
        if (array_key_exists($direction, $this->neighbors)) {
            return $this->neighbors[$direction];
        }
    }

    public function getNeighbors()
    {
        return $this->neighbors;
    }

    public function open()
    {
        return $this->open;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setOpenDirection($direction)
    {
        $this->open[$direction] = true;
    }

    public function setOpen($direction, $boolean) {
        $this->open[$direction] = $boolean;
    }

    public function setOpenArray($open) {
        $this->open = $this->orient($open);
    }

    private function randOpen() {
        $this->open["N"] = (bool)rand(0,1);
        $this->open["E"] = (bool)rand(0,1);
        $this->open["S"] = (bool)rand(0,1);
        $this->open["W"] = (bool)rand(0,1);
        if ($this->open() == array("N"=>true, "E"=>true, "S"=>true, "W"=>true)) {
            $this->randOpen();
        } elseif ($this->open() == array("N"=>false, "E"=>false, "S"=>false, "W"=>false)) {
            $this->randOpen();
        }
    }

    public function orient($orient) {
        switch($orient) {
            case 0:
                return array("N"=>true, "E"=>false, "S"=>false, "W"=>false);
            case 1:
                return array("N"=>false, "E"=>true, "S"=>false, "W"=>false);
            case 2:
                return array("N"=>false, "E"=>false, "S"=>true, "W"=>false);
            case 3:
                return array("N"=>false, "E"=>false, "S"=>false, "W"=>true);
            case 4:
                return array("N"=>true, "E"=>false, "S"=>true, "W"=>false);
            case 5:
                return array("N"=>false, "E"=>true, "S"=>false, "W"=>true);
            case 6:
                return array("N"=>true, "E"=>true, "S"=>false, "W"=>false);
            case 7:
                return array("N"=>false, "E"=>true, "S"=>true, "W"=>false);
            case 8:
                return array("N"=>false, "E"=>false, "S"=>true, "W"=>true);
            case 9:
                return array("N"=>true, "E"=>false, "S"=>false, "W"=>true);
            case 10:
                return array("N"=>false, "E"=>true, "S"=>true, "W"=>true);
            case 11:
                return array("N"=>true, "E"=>false, "S"=>true, "W"=>true);
            case 12:
                return array("N"=>true, "E"=>true, "S"=>false, "W"=>true);
            case 13:
                return array("N"=>true, "E"=>true, "S"=>true, "W"=>false);
        }
    }

    private $type;
    private $id;
    private $flag = false;
    private $open = array();
    private $neighbors = array();
}