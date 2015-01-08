<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\CacheException;
use NumPHP\Core\Exception\CacheKeyException;

/**
 * Class Cache
 *
 * @category Core
 * @package  NumPHP\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
abstract class Cache
{
    /**
     * Cache
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Saves `$value` under the key `$key` in the cache
     *
     * @param string $key   the key
     * @param mixed  $value the value
     *
     * @return $this
     * @throws CacheKeyException will be thrown if `$key` is no string
     * @throws CacheException will be thrown, if `$key` is already in use
     */
    public function setCache($key, $value)
    {
        if (!is_string($key)) {
            throw new CacheKeyException('Key has to be a string');
        }
        if ($this->inCache($key)) {
            throw new CacheException('Key "'.$key.'" already exists');
        }
        $this->cache[$key] = $value;

        return $this;
    }

    /**
     * Returns the value of the key `$key`
     *
     * @param string $key the key
     *
     * @return mixed
     * @throws CacheKeyException will be thrown if `$key` is no string
     * @throws CacheException will be thrown `$key` does not exist
     */
    public function getCache($key)
    {
        if (!is_string($key)) {
            throw new CacheKeyException('Key has to be a string');
        }
        if ($this->inCache($key)) {
            return $this->cache[$key];
        }

        throw new CacheException('Key "'.$key.'" does not exist');
    }

    /**
     * Checks if the key `$key` is used in the cache
     *
     * @param string $key the key
     *
     * @return bool
     * @throws CacheKeyException will be thrown if `$key` is no string
     */
    public function inCache($key)
    {
        if (!is_string($key)) {
            throw new CacheKeyException('Key has to be a string');
        }
        return array_key_exists($key, $this->cache);
    }

    /**
     * Flushes the hole cache or just the key `$key`
     *
     * @param string $key the key
     *
     * @return $this
     * @throws CacheKeyException will be thrown if `$key` is no string
     */
    public function flushCache($key = null)
    {
        if (is_null($key)) {
            $this->cache = [];
        } else {
            if (!is_string($key)) {
                throw new CacheKeyException('Key has to be a string');
            }
            unset($this->cache[$key]);
        }

        return $this;
    }
}
