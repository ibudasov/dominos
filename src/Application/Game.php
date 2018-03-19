<?php

declare(strict_types=1);

namespace Dominos\Application;

use Dominos\Domain\GameDomainService;
use Dominos\Domain\PlayerIsOutOfTilesException;
use Dominos\Domain\StockIsEmptyException;

class Game
{
    /**
     * @var Output
     */
    private $output;
    /**
     * @var GameDomainService
     */
    private $theGame;

    /**
     * @param GameDomainService $gameDomainService
     * @param Output            $output
     */
    public function __construct(GameDomainService $gameDomainService, Output $output)
    {
        $this->output = $output;

        $this->theGame = $gameDomainService;
    }

    public function run(): void
    {
        $this->theGame->init();

        $this->output->println('Game starting with first tile: '.$this->theGame->getBoard());

        try {
            for ($turn = 0; $turn < 28; ++$turn) {

                $activePlayer = $this->theGame->determineActivePlayer($turn);

                $tileToPlay = $this->theGame->playerMakesTurn($activePlayer);

                $this->theGame->addTile($tileToPlay);

                $this->output->println($activePlayer.' plays '.$tileToPlay);
                $this->output->println('Board is now: '.$this->theGame->getBoard());
            }
        } catch (PlayerIsOutOfTilesException $exception) {
            $this->output->println($activePlayer.' has won!');
            return;
        } catch (StockIsEmptyException $exception) {
            $this->output->println('Game over. Nobody wins.');
            return;
        }
    }
}
