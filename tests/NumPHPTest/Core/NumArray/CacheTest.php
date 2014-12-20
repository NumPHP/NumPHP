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
     * @expectedException \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     */
    public function testSetCacheForbiddenKey()
    {
        $numArray = new NumArray(5);

        $numArray->setCache(5, 6);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\CacheException
     * @expectedExceptionMessage Key "key" already exists
     */
    public function testSetCacheDouble()
    {
        $numArray = new NumArray(5);

        $numArray->setCache('key', 5);
        $numArray->setCache('key', 7);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     */
    public function testGetCacheForbiddenKey()
    {
        $numArray = new NumArray(5);

        $numArray->getCache(5);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\CacheException
     * @expectedExceptionMessage Key "key" does not exist
     */
    public function testGetMissCache()
    {
        $numArray = new NumArray(5);

        $numArray->getCache('key');
    }

    /**
     * @expectedException \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     */
    public function testInCacheForbiddenKey()
    {
        $numArray = new NumArray(5);

        $numArray->inCache(5);
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

    /**
     * @expectedException \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     */
    public function testFlushCacheForbiddenKey()
    {
        $numArray = new NumArray(6);

        $numArray->flushCache(6);
    }
}
