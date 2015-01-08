<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;

/**
 * Class CacheTest
 *
 * @category Core
 * @package  NumPHPTest\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Cache::setCache
     *
     * @return void
     */
    public function testSetCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 7);

        $this->assertSame(7, $numArray->getCache('key'));
    }

    /**
     * Tests if CacheKeyException will be thrown, when using Cache::setCache and key
     * is not a string
     *
     * @expectedException        \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     *
     * @return void
     */
    public function testSetCacheForbiddenKey()
    {
        $numArray = new NumArray(5);

        $numArray->setCache(5, 6);
    }

    /**
     * Tests if CacheException will be thrown, when using Cache::setCache and key is
     * already used
     *
     * @expectedException        \NumPHP\Core\Exception\CacheException
     * @expectedExceptionMessage Key "key" already exists
     *
     * @return void
     */
    public function testSetCacheDouble()
    {
        $numArray = new NumArray(5);

        $numArray->setCache('key', 5);
        $numArray->setCache('key', 7);
    }

    /**
     * Tests if CacheKeyException will be thrown, when using Cache::getCache and key
     * is not a string
     *
     * @expectedException        \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     *
     * @return void
     */
    public function testGetCacheForbiddenKey()
    {
        $numArray = new NumArray(5);

        $numArray->getCache(5);
    }

    /**
     * Tests if CacheException will be thrown, when using Cache::getCache and the
     * key does not exist
     *
     * @expectedException        \NumPHP\Core\Exception\CacheException
     * @expectedExceptionMessage Key "key" does not exist
     *
     * @return void
     */
    public function testGetMissCache()
    {
        $numArray = new NumArray(5);

        $numArray->getCache('key');
    }

    /**
     * Tests if CacheKeyException will be thrown, when using Cache::inCache and key
     * is not a string
     *
     * @expectedException        \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     *
     * @return void
     */
    public function testInCacheForbiddenKey()
    {
        $numArray = new NumArray(5);

        $numArray->inCache(5);
    }

    /**
     * Tests Cache::inCache
     *
     * @return void
     */
    public function testFlushCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 7);
        $numArray->flushCache();

        $this->assertFalse($numArray->inCache('key'));
    }

    /**
     * Tests Cache::flushCache
     *
     * @return void
     */
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
     * Tests if CacheKeyException will be thrown, when using Cache::flushCache and
     * key is not a string
     *
     * @expectedException        \NumPHP\Core\Exception\CacheKeyException
     * @expectedExceptionMessage Key has to be a string
     *
     * @return void
     */
    public function testFlushCacheForbiddenKey()
    {
        $numArray = new NumArray(6);

        $numArray->flushCache(6);
    }
}
