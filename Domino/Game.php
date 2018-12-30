<?php
declare(strict_types=1);

namespace Domino;

class Game
{
	/**
     * @var Table
     */
    private $table;

	/**
     * @var Tiles
     */
    private $tileStock;

    /**
     * @var Player
     */
    private $winner;

    /**
     * @var Player
     */
    private $loser;

    /**
     * @var Player[]
     */
    private $players;

    public function __construct(Table $table, Tiles $tileStock, Player $player1, Player $player2)
    {
        $this->table = $table;
        $this->tileStock = $tileStock;

        $this->players = [
            $player1,
            $player2
        ];

        shuffle($this->players);
    }

    public function playGame(): void
    {
        echo "First tile in the game is " . $this->table->showTiles() . PHP_EOL;

        try {
            while ($this->tileStock->hasTilesLeft() && !$this->winner) {
                $this->takeTurns();
            }
        } catch (\Exception $exception) {
            $this->showWinner();
        }
    }

    private function takeTurns(): void
    {
        while (true) {
            foreach ($this->players as $player) {
                $this->playerTurn($player);
            }
        }
    }

    private function playerTurn(Player $player): void
    {
        $availableSides = $this->table->getAvailableSides();
    	while (!$player->hasMatchingTile($availableSides) && $this->tileStock->hasTilesLeft()) {
        	$player->pickTileFromStock();
        	echo "$player picks a tile from stock." . PHP_EOL;
    	}

    	if (!$this->tileStock->hasTilesLeft() && !$player->hasMatchingTile($availableSides)) {
    	    $this->loser = $player;
    	    throw new \Exception('We have a winner');
        }

        echo "$player lays a tile on the table." . PHP_EOL;
        $this->table->layTile($player->getMatchingTile($availableSides));
        echo "Tiles on the table are now " . $this->table->showTiles() . PHP_EOL;

        if (!$player->hasTilesLeft()) {
            $this->winner = $player;
            throw new \Exception('We have a winner');
        }
    }

    private function showWinner(): void
    {
        if ($this->winner) {
            echo "The winner is $this->winner because this player has no more tiles left" . PHP_EOL;
            return;
        }

        foreach ($this->players as $player) {
            if ((string)$player === (string)$this->loser) {
                continue;
            }
            $this->winner = $player;
        }

        echo "The winner is $this->winner because $this->loser can't pick anymore tiles from stock" . PHP_EOL;
    }
}
