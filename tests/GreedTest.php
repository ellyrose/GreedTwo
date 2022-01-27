<?php

declare(strict_types=1);

namespace Tests\Lendable\Greed;

use Lendable\Greed\Greed;
use PHPUnit\Framework\TestCase;

class GreedTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_score_0_when_there_are_no_die(): void
    {
        $fixture = new Greed();

        $this->assertSame(0, $fixture->score([]));
    }

    /**
     * @test
     */
    public function it_should_score_0_for_a_single_2(): void
    {
        $fixture = new Greed();

        $this->assertSame(0, $fixture->score([2]));
    }

    /**
     * @test
     */
    public function it_should_score_0_for_a_double_2(): void
    {
        $fixture = new Greed();

        $this->assertSame(0, $fixture->score([2, 2]));
    }

    /**
     * @test
     */
    public function it_should_score_100_for_a_single_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(100, $fixture->score([1]));
        $this-> assertSame(100, $fixture->score([2,2,1,4,6]));
        $this->assertSame(100, $fixture->score([2,1]));
        $this->assertSame(100, $fixture->score([2,3,4,3,6,1]));
    }

    /**
     * @test
     */
    public function it_should_score_200_for_double_1(): void
    {
        $fixture = new Greed();
        $this->assertSame(200, $fixture->score([1,1]));
        $this-> assertSame(200, $fixture->score([2,2,1,1,6]));
        $this->assertSame(200, $fixture->score([2,1,4,3,6,1]));
    }


//    /**
//     * @test
//     */
//    public function it_should_score_0_for_double_1(): void
//    {
//        $fixture = new Greed();
//
//        $this->assertSame(0, $fixture->score([1,1]));
//
//
//    }

    /**
     * @test
     */
    public function it_should_score_50_for_a_single_5(): void
    {
        $fixture = new Greed();

        $this->assertSame(50, $fixture->score([5]));
        $this->assertSame(50,$fixture->score([4,5]));
        $this->assertSame(50, $fixture->score([2,3,5,6]));
        $this->assertSame(50, $fixture->score([2,3,6,4,5]));
    }

    /**
     * @test
     */

    public function it_should_score_100_for_double_five(): void
    {
        $fixture = new Greed();

        $this->assertSame(100, $fixture->score([2,5,6,4,5]));
        $this->assertSame(100, $fixture->score([2,5,5,3,6]));
    }

    /**
     * @test
     */
    public function it_should_score_150_for_a_single_5_and_single_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(150, $fixture->score([5,1]));
        $this->assertSame(150, $fixture->score([2,3,5,4,1]));


    }

    /**
     * @test
     */
    public function it_should_score_300_for_double_5_and_double_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(300, $fixture->score([5,1,5,1]));
        $this->assertSame(300, $fixture->score([6,5,1,5,1]));

    }


    /**
     * @test
     */
    public function it_should_score_1000_for_triple_1s(): void
    {
        $fixture = new Greed();

        $this->assertSame(1000, $fixture->score([1,1,1]));
        $this->assertSame(1000, $fixture->score([3,1,1,1,3,4]));
        $this->assertSame(1000, $fixture->score([3,2,4,1,1,1]));
        $this->assertSame(1000, $fixture->score([1,1,1,2,4,3]));
    }

//    /**
//     * @test
//     */
//    public function it_should_score_1100_for_a_triple_1_and_a_single_1(): void
//    {
//        $fixture = new Greed();
//
//        $this->assertSame(1100, $fixture->score([1,1,1,3,6,1]));
//        $this->assertSame(1100, $fixture->score([1,6,3,1,1,1]));
//    }
//
    /**
     * @test
     */
    public function it_should_score_800_for_3_pairs(): void
    {
        $fixture = new Greed();

        $this->assertSame(800, $fixture->score([2,2,3,3,4,4]));
        $this->assertSame(0, $fixture->score([2,3,3,2,4,4]));
    }

    /**
     * @test
     */
    public function it_should_score_1200_for_a_straight(): void
    {
        $fixture = new Greed();

        $this->assertSame(1200, $fixture->score([1,2,3,4,5,6]));
        $this->assertSame(1200, $fixture->score([2,1,4,3,5,6]));
    }

    /**
     * @test
     */

    public function it_should_throw_an_invalid_argument_exception_if_there_are_too_many_dice(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a maximum of 6 dice, got 7.');

        $fixture = new Greed();
        $fixture->score([1, 2, 3, 4, 5, 6, 6]);
    }

    /**
     * @test
     */
    public function it_should_throw_an_invalid_argument_exception_if_a_die_value_is_too_low(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Die at position 0 is invalid.');

        $fixture = new Greed();
        $fixture->score([0, 2, 3, 4, 5, 6]);
    }

    /**
     * @test
     */

    public function it_should_throw_an_invalid_argument_exception_if_a_die_value_is_too_high(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Die at position 4 is invalid.');

        $fixture = new Greed();
        $fixture->score([1, 2, 3, 4, 7]);
    }

    /**
     * @test
     */
    public function it_should_score_200_for_triple_2s(): void
    {
        $fixture = new Greed();

        $this->assertSame(200, $fixture->score([2,2,2]));
        $this->assertSame(200, $fixture->score([3,3,2,2,2,6]));
        $this->assertSame(200, $fixture->score([6,3,2,3,2,2]));
    }

    /**
     * @test
     */
    public function it_should_score_300_for_triple_2s_and_single_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(300, $fixture->score([2,6,2,2,1]));

    }

    /**
     * @test
     */
    public function it_should_score_300_for_triple_3s(): void
    {
        $fixture = new Greed();

        $this->assertSame(300, $fixture->score([3,4,3,3]));
        $this->assertSame(300, $fixture->score([4,3,2,3,2,3]));
    }

    /**
     * @test
     */
    public function it_should_score_400_for_triple_4s(): void
    {
        $fixture = new Greed();

        $this->assertSame(400, $fixture->score([4,4,4]));
        $this->assertSame(400, $fixture->score([4,2,4,6,4]));
    }

    /**
     * @test
     */
    public function it_should_score_500_for_triple_5s(): void
    {
        $fixture = new Greed();

        $this->assertSame(500, $fixture->score([5,5,5]));
        $this->assertSame(500, $fixture->score([2,6,5,5,5]));
        $this->assertSame(500, $fixture->score([5,5,2,2,5]));
    }

//    /**
//     * @test
//     */
//    public function it_should_score_550_for_triple_5s_and_single_5(): void
//    {
//        $fixture = new Greed();
//
//        $this->assertSame(550, $fixture->score([5,5,5,4,5]));
//        $this->assertSame(550, $fixture->score([5,6,5,5,5]));
//        $this->assertSame(550, $fixture->score([5,5,5,2,5,6]));
//    }


    /**
     * @test
     */
    public function it_should_score_600_for_triple_6s(): void
    {
        $fixture = new Greed();

        $this->assertSame(600, $fixture->score([6,6,6]));
        $this->assertSame(600, $fixture->score([4,6,6,2,6]));
    }

    /**
     * @test
     */
    public function it_should_score_700_for_triple_6s_and_single_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(700, $fixture->score([1,6,6,6,2,3]));
    }

    /**
     * @test
     */
    public function it_should_score_2000_for_four_1s(): void
    {
        $fixture = new Greed();

        $this->assertSame(2000, $fixture->score([1,1,1,1]));
        $this->assertSame(2000, $fixture->score([1,1,1,1,4,2]));
        $this->assertSame(2000, $fixture->score([1,3,6,1,1,1]));
    }

//    /**
//     * @test
//     */
//    public function it_should_score_2100_for_four_1s_and_single_1(): void
//    {
//        $fixture = new Greed();
//
//        $this->assertSame(2100, $fixture->score([6,4,1,1,1,1]));
//        $this->assertSame(2100, $fixture->score([1,1,1,1,4,6]));
//    }

    /**
     * @test
     */
    public function it_should_score_400_for_four_2s(): void
    {
        $fixture = new Greed();

        $this->assertSame(400, $fixture->score([2,2,2,2]));


    }

    /**
     * @test
     */
    public function it_should_score_500_for_four_2s_and_single_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(500, $fixture->score([1,2,2,2,2]));
        $this->assertSame(500, $fixture->score([2,2,2,2,1]));
    }


    /**
     * @test
     */
    public function it_should_score_600_for_four_3s(): void
    {
        $fixture = new Greed();

        $this->assertSame(600, $fixture->score([3,3,3,3]));
        $this->assertSame(600, $fixture->score([2,3,3,3,3,6]));
    }

    /**
     * @test
     */
    public function it_should_score_800_for_four_4s(): void
    {
        $fixture = new Greed();

        $this->assertSame(800, $fixture->score([4,4,4,4]));
        $this->assertSame(800, $fixture->score([6,4,4,4,3,4]));
    }

    /**
     * @test
     */
    public function it_should_score_1000_for_four_5s(): void
    {
        $fixture = new Greed();

        $this->assertSame(1000, $fixture->score([5,5,5,5]));
        $this->assertSame(1000, $fixture->score([5,5,5,5,2,3]));
        $this->assertSame(1000, $fixture->score([2,3,5,5,5,5]));
    }

//    /**
//     * @test
//     */
//    public function it_should_score_1050_for_four_5s_and_single_5(): void
//    {
//        $fixture = new Greed();
//
//        $this->assertSame(1050, $fixture->score([5,5,5,5,6,5]));
//        $this->assertSame(1050, $fixture->score([5,6,5,5,5,5]));
//
//    }

    /**
     * @test
     */
    public function it_should_score_1200_for_four_6s(): void
    {
        $fixture = new Greed();

        $this->assertSame(1200, $fixture->score([6,6,6,6]));
        $this->assertSame(1200, $fixture->score([6,4,6,6,3,6]));
    }

    /**
     * @test
     */
    public function it_should_score_4000_for_five_1s(): void
    {
        $fixture = new Greed();

        $this->assertSame(4000, $fixture->score([1,1,1,1,1]));
        $this->assertSame(4000, $fixture->score([1,6,1,1,1,1]));
    }

    /**
     * @test
     */
    public function it_should_score_800_for_five_2s(): void
    {
        $fixture = new Greed();

        $this->assertSame(800, $fixture->score([2,2,2,2,2]));

    }


    /**
     * @test
     */
    public function it_should_score_900_for_five_2s_and_single_1(): void
    {
        $fixture = new Greed();

        $this->assertSame(900, $fixture->score([1,2,2,2,2,2]));

    }

    /**
     * @test
     */
    public function it_should_score_1200_for_five_3s(): void
    {
        $fixture = new Greed();

        $this->assertSame(1200, $fixture->score([3,3,3,3,3]));
        $this->assertSame(1200, $fixture->score([2,3,3,3,3,3]));
    }

    /**
     * @test
     */
    public function it_should_score_1600_for_five_4s(): void
    {
        $fixture = new Greed();

        $this->assertSame(1600, $fixture->score([4,4,4,4,4]));
        $this->assertSame(1600, $fixture->score([4,4,4,4,4,3]));
    }

    /**
     * @test
     */
    public function it_should_score_2000_for_five_5s(): void
    {
        $fixture = new Greed();

        $this->assertSame(2000, $fixture->score([5,5,5,5,5]));
    }

    /**
     * @test
     */
    public function it_should_score_2400_for_five_6s(): void
    {
        $fixture = new Greed();

        $this->assertSame(2400, $fixture->score([6,6,6,6,6,3]));
    }

    /**
     * @test
     */
    public function it_should_score_8000_for_six_1s(): void
    {
        $fixture = new Greed();

        $this->assertSame(8000, $fixture->score([1,1,1,1,1,1]));
    }


    /**
     * @test
     */
    public function it_should_score_1600_for_six_2s(): void
    {
        $fixture = new Greed();

        $this->assertSame(1600, $fixture->score([2,2,2,2,2,2]));
    }


    /**
     * @test
     */
    public function it_should_score_2400_for_six_3s(): void
    {
        $fixture = new Greed();

        $this->assertSame(2400, $fixture->score([3,3,3,3,3,3]));
    }

    /**
     * @test
     */
    public function it_should_score_3200_for_six_4s(): void
    {
        $fixture = new Greed();

        $this->assertSame(3200, $fixture->score([4,4,4,4,4,4]));
    }

    /**
     * @test
     */
    public function it_should_score_4000_for_six_5s(): void
    {
        $fixture = new Greed();

        $this->assertSame(4000, $fixture->score([5,5,5,5,5,5]));
    }

    /**
     * @test
     */
    public function it_should_score_4800_for_six_6s(): void
    {
        $fixture = new Greed();

        $this->assertSame(4800, $fixture->score([6,6,6,6,6,6]));
    }
}
