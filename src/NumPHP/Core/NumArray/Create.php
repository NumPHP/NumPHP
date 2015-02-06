<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Create
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.1.0
 */
abstract class Create
{
    /**
     * @param $data
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public static function reshapeData($data)
    {
        $collectedEntries = [];
        $shape = [];
        self::collectEntries($data, $collectedEntries, $shape);
        if (count($collectedEntries)) {
            return [$collectedEntries, $shape];
        }

        return [$data, $shape];
    }

    /**
     * @param $data
     * @param $collectedEntries
     * @param $shape
     * @param int $level
     *
     * @throws InvalidArgumentException
     */
    protected static function collectEntries($data, &$collectedEntries, &$shape, $level = 0)
    {
        if (is_array($data)) {
            $count = count($data);
            if (isset($shape[$level]) && $shape[$level] !== $count) {
                throw new InvalidArgumentException("Dimensions did not match");
            } else {
                $shape[$level] = $count;
            }
            if ($count && !is_array($data[0])) {
                foreach ($data as $value) {
                    $collectedEntries[] = $value;
                }
            } else {
                foreach ($data as $entry) {
                    self::collectEntries($entry, $collectedEntries, $shape, $level + 1);
                }
            }
        }
    }
}
