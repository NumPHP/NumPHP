<?php
declare(strict_types=1);

namespace NumPHPTest;

use NumPHP\ComplexNum;
use PHPUnit\Framework\TestCase;

class ComplexNumTest extends TestCase
{
    public function testToString()
    {
        $com1 = new ComplexNum(6, -1);
        $this->assertSame("6-1i", $com1->__toString());
        $com2 = new ComplexNum(-2, 6);
        $this->assertSame("-2+6i", $com2->__toString());
    }

    public function testIsEqual()
    {
        $com = new ComplexNum(-6, 5);
        $this->assertFalse($com->isEqual(new ComplexNum(-6, -1)));
        $this->assertFalse($com->isEqual(new ComplexNum(2, 5)));
        $this->assertFalse($com->isEqual(new ComplexNum(-5, -7)));
        $this->assertTrue($com->isEqual(new ComplexNum(-6, 5)));
    }

    public function testGetReal()
    {
        $com = new ComplexNum(-8, 9);
        $this->assertSame(-8.0, $com->getReal());
    }

    public function testGetImag()
    {
        $com = new ComplexNum(-7, 2);
        $this->assertSame(2.0, $com->getImag());
    }

    public function testAdd()
    {
        $com1 = new ComplexNum(-4, -2);
        $com2 = new ComplexNum(9, -7);
        $expectedResult = new ComplexNum(5, -9);
        $this->assertTrue($expectedResult->isEqual($com1->add($com2)));
    }

    public function testSub()
    {
        $com1 = new ComplexNum(4, -3);
        $com2 = new ComplexNum(-9, 5);
        $expectedResult = new ComplexNum(13, -8);
        $this->assertTrue($expectedResult->isEqual($com1->sub($com2)));
    }

    public function testMult()
    {
        $com1 = new ComplexNum(4, -1);
        $com2 = new ComplexNum(-2, 3);
        $expectedResult = new ComplexNum(-5, 14);
        $this->assertTrue($expectedResult->isEqual($com1->mult($com2)));
    }

    public function testDiv()
    {
        $com1 = new ComplexNum(5, 3);
        $com2 = new ComplexNum(1, -7);
        $expectedResult = new ComplexNum((5 - 21) / 58, (3 + 35) / 58);
        $this->assertTrue($expectedResult->isEqual($com1->div($com2)));
    }

    public function testAbs()
    {
        $com = new ComplexNum(-6, 5);
        $this->assertSame(sqrt(61), $com->abs());
    }
}
