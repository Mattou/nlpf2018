<?php

namespace Hackathon\PlayerIA;
use Hackathon\Game\Result;

/**
 * Class LaplazePlayer
 * @package Hackathon\PlayerIA
 * @author Robin
 *
 */
class LaplazePlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;
    protected $opponent_last_3 = array();
    protected $third_last = 0;
    protected $sec_last = 0;
    protected $last = 0;
    protected $size = 3; //width of the array


    function __construct() {
        for ($i = 0; $i < 27; $i++) {
            $this->opponent_last_3[$i] = 0;
        }
    }
// Rock: 1
//Paper: 2
// Scissors: 3

    public function getChoice()
    {

        if ($this->result->getNbRound() == $this->size) {
            $tmpChoices = $this->result->getChoicesFor($this->opponentSide);
            $this->third_last = $tmpChoices[0];
            $this->sec_last = $tmpChoices[1];
            $this->last = $tmpChoices[2];
        } else if ($this->result->getNbRound() > $this->size) {
            $this->third_last = $this->sec_last;
            $this->sec_last = $this->last;
            $this->last = $this->result->getLastChoiceFor($this->opponentSide);
        } else {
            return parent::rockChoice();
        }

        $index = 0; //index to increment
        switch ($this->third_last) {
            case 'scissors':
                $index = $this->size * $this->size;//9
                break;
            case 'paper':
            $index = $this->size * $this->size * 2;//18
                break;
        }
        switch ($this->sec_last) {
            case 'scissors':
                $index = $index + $this->size;//12 or 21
                break;
            case 'paper':
            $index = $index + ($this->size * 2); // 15 or 24
                break;
        }
        $res = $index; //where we will get the proba. max value = 24
        switch ($this->sec_last) {
            case 'scissors':
                $index = $index + 1;
                break;
            case 'paper':
            $index = $index + 2;
                break;
        }
        $this->opponent_last_3[$index] = $this->opponent_last_3[$index] + 1;
        $max_val = $res;
        if ($this->opponent_last_3[$res] < $this->opponent_last_3[$res + 1]) {
            $max_val = $res + 1;
        }
        if ($this->opponent_last_3[$max_val] < $this->opponent_last_3[$res + 2]) {
            $max_val = $res + 2;
        }

        switch ($max_val % 3) {
            case 0:
            return parent::paperChoice();
                break;
            case 1:
            return parent::rockChoice();
                break;
            default:
            return parent::scissorsChoice();
            break;
        }

        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent Last Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------
    }
};