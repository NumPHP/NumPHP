<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\CacheMissException;

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
     */
    public function setCache($key, $value)
    {
        $this->cache[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return mixed
     * @throws CacheMissException
     */
    public function getCache($key)
    {
        if ($this->inCache($key)) {
            return $this->cache[$key];
        }

        throw new CacheMissException('Key "'.$key.'" does not exist');
    }

    /**
     * @param $key
     * @return bool
     */
    public function inCache($key)
    {
        return array_key_exists($key, $this->cache);
    }

    /**
     * @param $key
     * @return $this
     */
    public function flushCache($key = null)
    {
        if (is_null($key)) {
            $this->cache = [];
        } else {
            unset($this->cache[$key]);
        }

        return $this;
    }
}
