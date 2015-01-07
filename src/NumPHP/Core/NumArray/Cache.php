<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\CacheException;
use NumPHP\Core\Exception\CacheKeyException;

/**
 * Class Cache
  * @package NumPHP\Core\NumArray
  */
abstract class Cache
{
    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws CacheException
     * @throws CacheKeyException
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
     * @param $key
     * @return mixed
     * @throws CacheKeyException
     * @throws CacheException
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
     * @param $key
     * @return bool
     * @throws CacheKeyException
     */
    public function inCache($key)
    {
        if (!is_string($key)) {
            throw new CacheKeyException('Key has to be a string');
        }
        return array_key_exists($key, $this->cache);
    }

    /**
     * @param null $key
     * @return $this
     * @throws CacheKeyException
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
