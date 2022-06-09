<?php

declare(strict_types=1);

namespace App\Service;

use Iterator;
use Countable;
use App\Service\TokenCollection as Jeton;

class JetonList implements Countable, Iterator
{
    /**
     * @var Jetons[]
     */
    private array $Jetons = [];
    private int $currentIndex = 0;

    public function addJeton(Jeton $Jeton)
    {
        $this->Jetons[] = $Jeton->getAll();
    }

    public function removeJeton(Jeton $JetonToRemove)
    {
        foreach ($this->Jetons as $key => $Jeton) {
            if ($Jeton->getName() === $JetonToRemove->getName()) {
                unset($this->Jetons[$key]);
            }
        }

        $this->Jetons = array_values($this->Jetons);
    }

    public function count(): int
    {
        return count($this->Jetons);
    }

    public function current(): Jeton
    {
        return $this->Jetons[$this->currentIndex];
    }

    public function key(): int
    {
        return $this->currentIndex;
    }

    public function next()
    {
        $this->currentIndex++;
    }

    public function rewind()
    {
        $this->currentIndex = 0;
    }

    public function valid(): bool
    {
        return isset($this->Jetons[$this->currentIndex]);
    }
}