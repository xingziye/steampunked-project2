<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/12/16
 * Time: 1:54 PM
 */

namespace Steampunked;


class Steampunked
{
    const CONT = 0;
    const END = 1;
    const SUCCESS = 2;
    const FAILURE = 3;

    /**
     * Constructor
     * @param array $ent
     * @param $seed
     */
    public function __construct($ent, $seed = null)
    {
        $this->id = $ent['id'];
        $this->player1 = $ent['player1'];
        $this->player2 = $ent['player2'];
        $this->turn = $ent['turn'];

        $size = $ent['size'];
        for ($row = 0; $row < $size; $row++) {
            $this->pipes[] = array();
            for ($col = 0; $col < $size; $col++) {
                $this->pipes[$row][] = null;
            }
        }

        for ($row = 0; $row < $size; $row++) {
            if ($row == $size/2 - 3) {
                $this->valves[] = new Tile(Tile::VALVE_CLOSE, $this->player1);
            } elseif ($row == $size/2 + 2) {
                $this->valves[] = new Tile(Tile::VALVE_CLOSE, $this->player2);
            } else {
                $this->valves[] = null;
            }
        }

        for ($row = 0; $row < $size; $row++) {
            if ($row == $size/2 - 3) {
                $this->gauges[] = new Tile(Tile::GAUGE_TOP0, $this->player1);
            } elseif ($row == $size/2) {
                $this->gauges[] = new Tile(Tile::GAUGE_TOP0, $this->player2);
            } elseif ($row == $size/2 - 2) {
                $this->gauges[] = new Tile(Tile::GAUGE0, $this->player1);
            } elseif ($row == $size/2 + 1) {
                $this->gauges[] = new Tile(Tile::GAUGE0, $this->player2);
            } else {
                $this->gauges[] = null;
            }
        }

        if ($seed === null) {
            $seed = time();
        }

        srand($seed);
    }

    public function createGame($all) {
        // pave the tiles
        foreach ($all as $ent) {
            $tile = new Tile($ent['type'], $ent['player']);
            $tile->setOpenArray($ent['orientation']);
            if ($ent['type'] == Tile::PIPE) {
                $this->pipes[$ent['row']][$ent['col']] = $tile;
            } elseif ($ent['type'] == Tile::PIPE_TO_SELECT) {
                if ($ent['player'] == $this->player1) {
                    $this->selection1[$ent['col']] = $tile;
                } else {
                    $this->selection2[$ent['col']] = $tile;
                }
            }
        }

        // initialize selections if not exist
        if ($this->selection1 == array()) {
            for ($col = 0; $col < 5; $col++) {
                $this->selection1[] = new Tile(Tile::PIPE_TO_SELECT, $this->player1);
            }
        }
        if ($this->selection2 == array()) {
            for ($col = 0; $col < 5; $col++) {
                $this->selection2[] = new Tile(Tile::PIPE_TO_SELECT, $this->player2);
            }
        }

        // connect valves
        $size = $this->getSize();
        $start1 = $this->pipes[$size/2 - 3][0];
        $start2 = $this->pipes[$size/2 + 2][0];
        if ($start1 === null) {
            $this->addLeak($size/2 - 3, 0, $this->valves[$size/2 - 3], 'W');
            $this->valves[$size/2 - 3]->setNeighbor($start1, 'E');
        }
        if ($start2 === null) {
            $this->addLeak($size/2 + 2, 0, $this->valves[$size/2 + 2], 'W');
            $this->valves[$size/2 + 2]->setNeighbor($start2, 'E');
        }

        // connect gauge
        $end1 = $this->pipes[$size/2 - 2][$size - 1];
        $end2 = $this->pipes[$size/2 + 1][$size - 1];
        if ($end1 !== null) {
            $end1->setNeighbor($this->gauges[$size/2 - 2], 'E');
            $this->gauges[$size/2 - 2]->setNeighbor($end1, 'W');
        }
        if ($end2 !== null) {
            $end2->setNeighbor($this->gauges[$size/2 + 1], 'E');
            $this->gauges[$size/2 + 1]->setNeighbor($end2, 'W');
        }

        // connect pipes and add leaks
        for ($row = 0; $row < $size; $row++ ) {
            for ($col = 0; $col < $size; $col++) {

                $pipe = $this->pipes[$row][$col];
                if ($pipe === null or $pipe->getType() == Tile::LEAK) {
                    continue;
                }

                $open = $pipe->open();
                foreach ($open as $direction => $isOpen) {
                    if (!$isOpen) {
                        continue;
                    }
                    $leakRow = $row;
                    $leakCol = $col;
                    switch ($direction) {
                        case 'N':
                            if ($row == 0) {
                                continue;
                            }
                            $leakRow--;
                            break;
                        case 'S':
                            if ($row == $size - 1) {
                                continue;
                            }
                            $leakRow++;
                            break;
                        case 'W':
                            if ($col == 0) {
                                continue;
                            }
                            $leakCol--;
                            break;
                        case 'E':
                            if ($col == $size - 1) {
                                continue;
                            }
                            $leakCol++;
                            break;
                    }

                    if ($this->pipes[$leakRow][$leakCol] === null) {
                        $this->addLeak($leakRow, $leakCol, $pipe, $this->opposite($direction));
                    } else {
                        //
                    }
                    $pipe->setNeighbor($this->pipes[$leakRow][$leakCol], $direction);
                }
            }
        }
    }

    private function addLeak($row, $col, &$pipe, $direction) {
        $leak = new Tile(Tile::LEAK, $pipe->getId());
        $leak->setNeighbor($pipe, $direction);
        $this->pipes[$row][$col] = $leak;
    }
/*
    public function createGame($id, $size, $player0, $player1)
    {
        $this->id = $id;
        $this->continued = true;
        $this->turn = 0;
        $this->pipes = array();
        for ($row = 0; $row < $size; $row++) {
            $this->pipes[] = array();
            for ($col = 0; $col < $size; $col++) {
                $this->pipes[$row][] = null;
            }
        }

        $this->players = array();
        $this->players[] = $player0;
        $this->players[] = $player1;

        $this->valves = array();
        for ($row = 0; $row < $size; $row++) {
            if ($row == $size/2 - 3) {
                $this->valves[] = new Tile(Tile::VALVE_CLOSE, 0);
                $this->pipes[$row][0] = new Tile(Tile::LEAK, 0);
                $this->pipes[$row][0]->setNeighbor($this->valves[$row], "W");
            } elseif ($row == $size/2 + 2) {
                $this->valves[] = new Tile(Tile::VALVE_CLOSE, 1);
                $this->pipes[$row][0] = new Tile(Tile::LEAK, 1);
                $this->pipes[$row][0]->setNeighbor($this->valves[$row], "W");
            } else {
                $this->valves[] = null;
            }
        }

        $this->gauges = array();
        for ($row = 0; $row < $size; $row++) {
            if ($row == $size/2 - 3) {
                $this->gauges[] = new Tile(Tile::GAUGE_TOP0, 0);
            } elseif ($row == $size/2) {
                $this->gauges[] = new Tile(Tile::GAUGE_TOP0, 1);
            } elseif ($row == $size/2 - 2) {
                $this->gauges[] = new Tile(Tile::GAUGE0, 0);
            } elseif ($row == $size/2 + 1) {
                $this->gauges[] = new Tile(Tile::GAUGE0, 1);
            } else {
                $this->gauges[] = null;
            }
        }
    }
*/
    public function openValve($player) {
        $size = $this->getSize();
        $valves= $this->getValves();
        $gauges = $this->getGauges();
        for ($row = 0; $row < $size; $row++) {
            if ($valves[$row] !== null and $valves[$row]->getId() == $player) {
                $valves[$row]->setType(Tile::VALVE_OPEN);
            }
        }
        for ($row = 0; $row < $size; $row++) {
            if ($gauges[$row] !== null) {
                if ($gauges[$row]->getId() == $player and $gauges[$row]->getType() == Tile::GAUGE0) {
                    if ($gauges[$row]->indicateLeaks()) {
                        $this->winner = $this->getOppo($player);
                    } else {
                        $gauges[$row]->setType(Tile::GAUGE190);
                        $gauges[$row-1]->setType(Tile::GAUGE_TOP190);
                        $this->winner = $player;
                    }
                }
            }
        }
    }

    public function check($pipe, $row, $col) {
        // Check the open matches leak's neighbors
        $open = $pipe->open();
        foreach(array("N", "W", "S", "E") as $direction) {
            $n = $this->pipes[$row][$col]->neighbor($direction);
            if (!is_null($n)) {
                // If there is a neighbor, and its id matches this turn, open should be true
                if ($n->getId() == $this->getTurn()) {
                    if($open[$direction] == false) {
                        return false;
                    }
                } else {
                    if ($open[$direction] == true) {
                        return false;
                    }
                }
            }
        }

        // Otherwise, return true;
        return true;
    }

    /**
     * @param Tile $pipe
     * @param int $row
     * @param int $col
     * @return const int
     */
    public function addPipe($pipe, $row, $col) {
        if ($this->check($pipe, $row, $col)) {
            $leak = $this->pipes[$row][$col];
            $this->setPipe($pipe, $row, $col);
            $open = $pipe->open();
            $size = $this->getSize();
            foreach(array("N", "W", "S", "E") as $direction) {
                // connect valve to pipe
                if ($col == 0 and ($row == $size/2 - 3 or $row == $size/2 + 2)) {
                    $this->valves[$row]->setNeighbor($this->pipes[$row][$col], "E");
                }
                if ($leak->neighbor($direction)) {
                    $pipe->setNeighbor($leak->neighbor($direction), $direction);
                    $leak->neighbor($direction)->setNeighbor($pipe, $this->opposite($direction));
                } elseif ($open[$direction]) {
                    // check pipe which connects to gauge
                    if ($direction == "E" and $col == $size - 1) {
                        if ($row == $size/2 - 2) {
                            $pipe->setNeighbor($this->gauges[$size/2 - 2], "E");
                            $this->gauges[$size/2 - 2]->setNeighbor($this->pipes[$row][$col], "W");
                        } elseif($row == $size/2 + 1) {
                            $pipe->setNeighbor($this->gauges[$size/2 + 1], "E");
                            $this->gauges[$size/2 + 1]->setNeighbor($this->pipes[$row][$col], "W");
                        }
                        else {
                            continue;
                        }
                    }
                    // check edge condition
                    if (($direction == "N" and $row == 0)
                    or ($direction == "W" and $col ==0)
                    or ($direction == "S" and $row == $size - 1)) {
                        continue;
                    }
                    // add leak tile
                    //$this->addLeak($row, $col, $direction);
                }
            }
            return Steampunked::SUCCESS;
        }
        return Steampunked::FAILURE;
    }
/*
    private function addLeak($row, $col, $direction) {
        $leakRow = $row;
        $leakCol = $col;
        switch($direction) {
            case "N":
                $leakRow--;
                break;
            case "E":
                $leakCol++;
                break;
            case "S":
                $leakRow++;
                break;
            case "W":
                $leakCol--;
                break;
            default:
                return;
        }
        if ($this->pipes[$leakRow][$leakCol] === null) {
            $newLeak = new Tile(Tile::LEAK, $this->getTurn());
            $newLeak->setNeighbor($this->pipes[$row][$col], $this->opposite($direction));
            $this->pipes[$leakRow][$leakCol] = $newLeak;
        } else {
            if ($this->pipes[$leakRow][$leakCol]->getType() == Tile::LEAK) {
                $this->pipes[$leakRow][$leakCol]->setNeighbor($this->pipes[$row][$col], $this->opposite($direction));
            }
        }
    }*/

    private function setPipe($pipe, $row, $col) {
        $this->pipes[$row][$col] = $pipe;
    }

    public function getPipe($row, $col) {
        return $this->pipes[$row][$col];
    }

    public function getPipes() {
        return $this->pipes;
    }

    public function getValves()
    {
        return $this->valves;
    }

    public function getGauges()
    {
        return $this->gauges;
    }

    /**
     * @param int
     * @return Player
     */
    public function getPlayer($num)
    {
        if ($num == 1) {
            return $this->player1;
        } elseif ($num == 2) {
            return $this->player2;
        } else {
            return null;
        }
    }

    public function getOppo($id) {
        if ($this->player1 == $id) {
            return $this->player2;
        } else {
            return $this->player1;
        }
    }

    public function nextTurn()
    {
        if ($this->turn == $this->player1) {
            return $this->player2;
        } else {
            return $this->player1;
        }
    }

    /**
     * @return int
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return count($this->pipes);
    }

    public function isContinued()
    {
        return $this->continued;
    }

    public function setContinued($bool){
        $this->continued = $bool;
    }

    public function getId() {
        return $this->id;
    }

    public function opposite($direction) {
        switch($direction) {
            case "N":
                return "S";
                break;
            case "E":
                return "W";
                break;
            case "S":
                return "N";
                break;
            case "W":
                return "E";
                break;
            default:
                return null;
        }
    }

    public function giveup($player) {
        if ($player == $this->player1) {
            $this->winner = $this->player2;
        } else {
            $this->winner = $player;
        }
    }

    public function getWinner() {
        return $this->winner;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getSelection($id) {
        if ($this->player1 == $id) {
            return $this->selection1;
        } else {
            return $this->selection2;
        }
    }

    private $pipes = array();
    private $valves = array();
    private $gauges = array();
    private $selection1 = array();
    private $selection2 = array();
    private $turn = 0;
    private $continued = true;
    private $id = null;
    private $player1;
    private $player2;
    private $winner = null;
}