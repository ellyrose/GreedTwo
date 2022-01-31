<?php

declare(strict_types=1);

namespace Lendable\Greed;

use phpDocumentor\Reflection\Types\Boolean;

class Greed
{
    public function score(array $dice): int
    {
        $score = 0;

        $this->throwIfDiceOutOfBounds($dice);

        sort($dice);

        $results = array_count_values($dice);

        $score += $this->scoreSingleOrDoubleFive($results);

        $score += $this->scoreOnes($results);

        foreach ($results as $faceValue => $numberOfRolls){
            // why is this not '1'?
            if ($faceValue === 1){
                continue;
            }
            $tripleScore = $faceValue * 100;
            $score += $this->scoreMain($results, $faceValue, $tripleScore);
        }

        if ($this->isThreePairs($dice)) {
            return 800;
        }

        if ($this->isFullHouse($dice)) {
            return 1200;
        }

        return $score;
    }

    private function throwIfDiceOutOfBounds(array $dice): void
    {
        foreach ($dice as $value) {
            if ($value <= 0) {
                $position = array_search($value, $dice);
                throw new \InvalidArgumentException(sprintf('Die at position %d is invalid.', $position));
            }

            if ($value > 6) {
                $position = array_search($value, $dice);
                throw new \InvalidArgumentException(sprintf('Die at position %d is invalid.', $position));
            }
        }

        if (sizeof($dice) > 6) {
            $numberOfDie = sizeof($dice);
            throw new \InvalidArgumentException(sprintf('Expected a maximum of 6 dice, got %d.', $numberOfDie));
        }
    }

    private function isThreePairs(array $dice): bool
    {
        return sizeof($dice) === 6 && sizeof(array_unique($dice)) === 3
            && $dice[0] === $dice[1] && $dice[2] === $dice[3] && $dice[4] === $dice[5];
    }

    private function isFullHouse(array $dice): bool
    {
        return count(array_unique($dice)) === 6;
    }

    private function scoreSingleOrDoubleFive(array $results): int
    {
        $toAdd = 0;

        if (array_key_exists('5', $results)) {
            if ($results['5'] === 1) {
                $toAdd += 50;
            }elseif ($results['5'] === 2){
                $toAdd += 100;
            }
        }
        return $toAdd;

    }

    private function scoreOnes(array $results): int
    {
        $toAdd = 0;

        $tripleScore = 1000;

        if(array_key_exists('1', $results)){
            if ($results['1'] === 1) {
                $toAdd += 100;
            }elseif ($results['1'] === 2){
                $toAdd += 200;
            }
            elseif ($results['1'] === 3){
                $toAdd += $tripleScore;
            }elseif ($results['1'] === 4){
                $toAdd += $tripleScore * 2;
            }elseif ($results['1'] === 5){
                $toAdd += $tripleScore * 4;
            }elseif ($results['1'] === 6){
                return $tripleScore * 8;
            }
        }

        return $toAdd;
    }

    private function scoreMain(array $results,$faceValue,$tripleScore): int 
    {
        $toAdd = 0;

        if ($results[$faceValue] === 3){
            $toAdd += $tripleScore;
        }elseif ($results[$faceValue] === 4){
            $toAdd += $tripleScore * 2;
        }elseif ($results[$faceValue] === 5){
            $toAdd += $tripleScore * 4;
        }elseif ($results[$faceValue] === 6){
            return $tripleScore * 8;
        }

        return $toAdd;
    }
}


