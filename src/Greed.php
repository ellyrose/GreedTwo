<?php

declare(strict_types=1);

namespace Lendable\Greed;

class Greed
{
    public function score(array $dice): int
    {
        global $SCORE;
        $SCORE = 0;

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

        $one =0;
        $two = 0;
        $three =0;
        $four =0;
        $five =0;
        $six =0;

        foreach ($dice as $value) {
            if ($value === 1){
                $one++;
            }elseif($value === 2){
                $two++;
            }elseif($value === 3){
                $three++;
            }elseif($value === 4){
                $four++;
            }elseif($value === 5){
                $five++;
            }elseif($value === 6){
                $six++;
            }
        }

        if ($one === 1) {
            $SCORE += 100;
        } elseif ($one === 2) {
            $SCORE += 200;
        } elseif ($one === 3) {
            $SCORE += 1000;
        } elseif ($one === 4) {
            $SCORE += 2000;
        }elseif ($one === 5) {
            $SCORE += 4000;
        }elseif ($one === 6) {
            $SCORE += 8000;
        }

        if($five === 1){
            $SCORE += 50;
        }elseif ($five ===2){
            $SCORE += 100;
        }

        $scores= [$two,$three,$four,$five,$six];
        $index= 0;
        foreach ($scores as $score){
            $number = $index + 2;
            if ($score === 3){
                $SCORE += $number * 100;
            }elseif ($score === 4){
                $SCORE += $number * 200;
            }elseif ($score === 5){
                $SCORE += $number * 400;
            }elseif ($score === 6){
                $SCORE += $number * 800;
            }
            $index++;
        }


            if (sizeof($dice) == 6) {
                if (sizeof(array_unique($dice)) == 3) {
                    if ($dice[0] === $dice[1] && $dice[2] === $dice[3] && $dice[4] === $dice[5]) {
                        $SCORE = 800;
                    }
                }
            }

           if (sizeof(array_unique($dice)) == 6) {
                $SCORE = 1200;
            }
        return $SCORE;
    }
}

//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





