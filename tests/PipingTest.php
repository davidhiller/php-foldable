<?php

namespace Eightfold\Foldable\Tests;

use Eightfold\Foldable\Tests\TestCase;
use Eightfold\Foldable\Tests\Bends\ReverseBool;
use Eightfold\Foldable\Tests\Bends\BoolToString;
use Eightfold\Foldable\Tests\Bends\StringToArray;
use Eightfold\Foldable\Tests\Bends\ArrayToString;

use Eightfold\Foldable\Pipe;

class PipingTest extends TestCase
{
    public function test_piping()
    {
        $expected = "f!a!l!s!e";
        $actual = Pipe::fold(true,
            ReverseBool::bend(),
            BoolToString::bend(),
            StringToArray::bend(),
            ArrayToString::bendWith("!")
        )->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1);

        $expected = true;
        $actual = Pipe::fold(true,
            ReverseBool::bend(),
            ReverseBool::bend()
        )->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.2);

        $this->start = hrtime(true);
        $expected = false;
        $actual = Pipe::fold(true, ReverseBool::bend())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = true;
        $actual = Pipe::fold(true)->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}