<?php

use Domino\Game;
use Domino\Player;
use Domino\Table;
use Domino\Tiles;
use Domino\TilesCreator;

require_once __DIR__ . '/vendor/autoload.php';

// Create a new tile set to play with
$tilesCreator = new TilesCreator(new Tiles());
$tileStock = $tilesCreator->createNewSet();

// Create player A
$player1 = new Player('Sanne', new Tiles(), "\033[34;1m", $tileStock);
$player1->pickStartTiles();

// Create player B
$player2 = new Player('Jip', new Tiles(), "\033[32;1m", $tileStock);
$player2->pickStartTiles();

// Create table to play the game
$table = new Table(new Tiles());
$table->placeStartTile($tileStock->getRandomTile());

$game = new Game($table, $tileStock, $player1, $player2);
$game->playGame();
