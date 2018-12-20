<?php
declare(strict_types=1);

namespace Domino;

class Tiles implements \Iterator
{
    /**
     * @var array
     */
    private $tiles = [];

    /**
     * @var array
     */
    private $positions = [
        'start',
        'end',
    ];

    public function addTile(Tile $tile, string $position = 'end'): void
    {
        if (!in_array($position, $this->positions)) {
            throw new \Exception('Position not allowed');
        }

        if ($position === 'start') {
            array_unshift($this->tiles, $tile);
        } else {
            array_push($this->tiles, $tile);
        }
    }

    public function removeTile(int $key)
    {
        if (!$this->valid($key)) {
            throw new \Exception('Invalid key');
        }

        unset($this->tiles[$key]);
        $this->tiles = array_values($this->tiles);
        $this->rewind();

    }

    public function showTiles(): string
    {
        $string = '';

        foreach ($this->tiles as $tile) {
            $string .= (string)$tile;
        }

        return $string;
    }

    public function getRandomTile(): Tile
    {
        $offset = array_rand($this->tiles);

        $tile = array_splice($this->tiles, $offset, 1);

        return $tile[0];
    }

    public function getAmountOfTiles(): int
    {
        return count($this->tiles);
    }

    public function current(): Tile
    {
        return current($this->tiles);
    }

    public function next(): Tile
    {
        $keyBefore = $this->key();
        $tile = next($this->tiles);
        $key = $this->key();
        $amount = count($this->tiles);
        if (gettype($tile) === 'boolean') {
            $this->rewind();
            $tile = $this->current();
        }
        if (gettype($tile) === 'boolean') {
            var_dump($keyBefore);
            var_dump($key);
            var_dump($amount);
            var_dump($this->valid($key));
            die();
        }

        return $tile;
    }

    public function key()
    {
        return key($this->tiles);
    }

    public function valid($key = null): bool
    {
        if (is_null($key)) {
            $key = $this->key();
        }

        return array_key_exists($key, $this->tiles);
    }

    public function rewind(): void
    {
        reset($this->tiles);
    }
}
