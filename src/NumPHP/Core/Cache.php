<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\CacheException;
use NumPHP\Core\Exception\CacheKeyException;

/**
 * Class Cache
 *
 * @package   NumPHP\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
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
     *
     * @throws CacheKeyException will be thrown if `$key` is no string
     * @throws CacheException    will be thrown, if `$key` is already in use
     *
     * @since 1.0.0
     */
    public function setCache($key, $value)
    {
        if (!is_string($key)) {
            throw new CacheKeyException('Key has to be a string');
        }
        if ($this->inCache($key)) {
            throw new CacheException(sprintf('Key "%s" already exists', $key));
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
     *
     * @throws CacheKeyException will be thrown if `$key` is no string
     * @throws CacheException    will be thrown `$key` does not exist
     *
     * @since 1.0.0
     */
    public function getCache($key)
    {
        if (!is_string($key)) {
            throw new CacheKeyException('Key has to be a string');
        }
        if ($this->inCache($key)) {
            return self::cloneCacheEntryRecursive($this->cache[$key]);
        }

        throw new CacheException(sprintf('Key "%s" does not exist', $key));
    }

    /**
     * Checks if the key `$key` is used in the cache
     *
     * @param string $key the key
     *
     * @return bool
     *
     * @throws CacheKeyException will be thrown if `$key` is no string
     *
     * @since 1.0.0
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
     *
     * @throws CacheKeyException will be thrown if `$key` is no string
     *
     * @since 1.0.0
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

    /**
     * Clone every cache entry recursive
     *
     * @param mixed $entry given cache entry
     *
     * @return array
     *
     * @since 1.0.0
     */
    protected static function cloneCacheEntryRecursive($entry)
    {
        if (is_object($entry)) {
            return clone $entry;
        } elseif (is_array($entry)) {
            $clone = [];
            foreach ($entry as $key => $value) {
                $clone[$key] = self::cloneCacheEntryRecursive($value);
            }

            return $clone;
        }

        return $entry;
    }
}
