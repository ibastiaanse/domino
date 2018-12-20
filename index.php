<?php

use Domino\Player;
use Domino\Table;
use Domino\Tiles;
use Domino\TilesCreator;

require_once __DIR__ . '/vendor/autoload.php';

// Define colors
$yellowWithRedBackground = "\033[41;33;1m";
$red = "\033[31m";
$blue = "\033[34;1m";
$green = "\033[32;1m";

// Create a new tile set to play with
$tilesCreator = new TilesCreator(new Tiles());
$tiles = $tilesCreator->createNewSet();

// 'Create' player A
$playerA = new Player('Sanne', new Tiles(), $blue);
while ($playerA->notEnoughStartTiles()) {
    $playerA->pickTile($tiles->getRandomTile());
}

// 'Create' player B
$playerB = new Player('Jip', new Tiles(), $green);
while ($playerB->notEnoughStartTiles()) {
    $playerB->pickTile($tiles->getRandomTile());
}


// Create table to play the game
$table = new Table(new Tiles());
$startTile = $tiles->getRandomTile();
$table->placeStartTile($startTile);


// Game
echo "First tile in the game is $startTile" . PHP_EOL;
$winner = '';
while ($tiles->getAmountOfTiles() > 0 || ($playerB->hasTilesLeft() || $playerA->hasTilesLeft())) {
    while (!$playerB->hasMatchingTile($table->getAvailableSides())) {
        $playerB->pickTileFromStock($tiles);
        echo "$playerB picks a tile from stock and now has: " . $playerB->showTiles() . PHP_EOL;
    }
    echo "$playerB lays a tile on the table" . PHP_EOL;
    $table->layTile($playerB->getMatchingTile($table->getAvailableSides()));
    echo "Tiles on the table are now " . $table->showTiles() . PHP_EOL;

    if (!$playerB->hasTilesLeft()) {
        $winner = $playerB;
        break;
    }

    while (!$playerA->hasMatchingTile($table->getAvailableSides())) {
        $playerA->pickTileFromStock($tiles);
        echo "$playerA picks a tile from stock and now has: " . $playerA->showTiles() . PHP_EOL;
    }
    echo "$playerA lays a tile on the table" . PHP_EOL;
    $table->layTile($playerA->getMatchingTile($table->getAvailableSides()));
    echo "Tiles on the table are now " . $table->showTiles() . PHP_EOL;

    if (!$playerA->hasTilesLeft()) {
        $winner = $playerA;
        break;
    }
}

echo "The winner is $winner" . PHP_EOL;
