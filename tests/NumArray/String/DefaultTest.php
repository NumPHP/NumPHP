<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray\String;

use NumPHP\NumArray\Factory;
use NumPHP\NumArray\String\DefaultFormatter;

class DefaultTest extends \PHPUnit_Framework_TestCase
{
    private $stringFormater;

    private $factory;

    public function setUp()
    {
        $this->stringFormater = new DefaultFormatter();
        $this->factory = new Factory();
    }

    public function testNumArrayToStringEmpty()
    {
        $numArray = $this->factory->createFromData([]);
        $this->assertSame("[]", $this->stringFormater->numArrayToString($numArray));
    }

    public function testNumArrayToString4()
    {
        $numArray = $this->factory->createFromData([5, 2, 6, 0]);
        $this->assertSame("[5,2,6,0]", $this->stringFormater->numArrayToString($numArray));
    }

    public function testNumArrayToString2x3()
    {
        $numArray = $this->factory->createFromData(
            [
                [3, 4, 2],
                [9, 7, 0]
            ]
        );
        $this->assertSame("[\n  [3,4,2],\n  [9,7,0]\n]", $this->stringFormater->numArrayToString($numArray));
    }
}
