<?php
declare(strict_types=1);

namespace Domino;

class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $color;

    /**
     * @var Tiles
     */
    private $tiles;

    /**
     * @var int
     */
    private $startAmount = 7;

    /**
     * @var string
     */
    private $defaultColor = "\e[39;0m";

    /**
     * @var Tiles
     */
    private $tileStock;

    public function __construct(string $name, Tiles $tiles, string $color, Tiles $tileStock)
    {
        $this->name = $name;
        $this->tiles = $tiles;
        $this->color = $color;
        $this->tileStock = $tileStock;
    }

    public function pickStartTiles()
    {
        while ($this->notEnoughStartTiles()) {
            $this->pickTileFromStock();
        }
    }

    public function hasTilesLeft(): bool
    {
        return $this->tiles->hasTilesLeft();
    }

    public function getMatchingTile(array $availableSides): ?Tile
    {
        foreach ($this->tiles as $key => $availableTile) {
            /* @var Tile $availableTile */
            if (in_array($availableTile->getSideA(), $availableSides)) {
                $this->tiles->removeTile($key);
                return $availableTile;
            } elseif (in_array($availableTile->getSideB(), $availableSides)) {
                $this->tiles->removeTile($key);
                return $availableTile;
            }
        }

        return null;
    }

    public function hasMatchingTile(array $availableSides): bool
    {
        foreach ($this->tiles as $key => $availableTile) {
            /* @var Tile $availableTile */
            if (in_array($availableTile->getSideA(), $availableSides)) {
                $this->tiles->rewind();
                return true;
            } elseif (in_array($availableTile->getSideB(), $availableSides)) {
                $this->tiles->rewind();
                return true;
            }
        }

        return false;
    }

    public function pickTileFromStock(): void
    {
        $tile = $this->tileStock->getRandomTile();

        $tile->addColor($this->color);

        $this->tiles->addTile($tile);
    }

    public function __toString(): string
    {
        return $this->color . $this->name . $this->defaultColor;
    }

    private function notEnoughStartTiles(): bool
    {
        return $this->tiles->getAmountOfTiles() < $this->startAmount;
    }
}
