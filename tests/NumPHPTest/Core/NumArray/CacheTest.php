<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;

/**
 * Class CacheTest
  * @package NumPHPTest\Core\NumArray
  */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function testSetCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 7);

        $this->assertSame(7, $numArray->getCache('key'));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\CacheMissException
     * @expectedExceptionMessage Key "key" does not exist
     */
    public function testGetMissCache()
    {
        $numArray = new NumArray(5);

        $numArray->getCache('key');
    }

    public function testFlushCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 7);
        $numArray->flushCache();

        $this->assertFalse($numArray->inCache('key'));
    }

    public function testFlushCacheKey()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key1', 7);
        $numArray->setCache('key2', 8);
        $numArray->flushCache('key2');

        $this->assertSame(7, $numArray->getCache('key1'));
        $this->assertFalse($numArray->inCache('key2'));
    }
}
