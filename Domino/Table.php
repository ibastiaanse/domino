<?php
declare(strict_types=1);

namespace Domino;

class Table
{
    /**
     * @var string
     */
    private $startTileColor = "\033[31m";

    /**
     * @var Tiles
     */
    private $tiles;

    /**
     * @var array
     */
    private $availableLeft;

    /**
     * @var array
     */
    private $availableRight;

    public function __construct(Tiles $tiles)
    {
        $this->tiles = $tiles;
    }

    public function placeStartTile(Tile $startTile)
    {
        $startTile->addColor($this->startTileColor);

        $this->availableLeft = $startTile->getSideA();
        $this->availableRight = $startTile->getSideB();

        $this->tiles->addTile($startTile);
    }

    public function showTiles(): string
    {
        return $this->tiles->showTiles();
    }

    public function getAvailableSides(): array
    {
        return [
            'left' => $this->availableLeft,
            'right' => $this->availableRight,
        ];
    }

    public function layTile(Tile $tile): void
    {
        if ($tile->getSideA() === $this->availableLeft) {
            $tile->turnTile();
            $this->layTileLeft($tile);
        } elseif ($tile->getSideA() === $this->availableRight) {
            $this->layTileRight($tile);
        } elseif ($tile->getSideB() === $this->availableLeft) {
            $this->layTileLeft($tile);
        } elseif ($tile->getSideB() === $this->availableRight) {
            $tile->turnTile();
            $this->layTileRight($tile);
        }
    }

    public function layTileLeft(Tile $tile): void
    {
        $this->tiles->addTile($tile, 'start');
        $this->availableLeft = $tile->getSideA();
    }

    public function layTileRight(Tile $tile): void
    {
        $this->tiles->addTile($tile, 'end');
        $this->availableRight = $tile->getSideB();
    }
}
