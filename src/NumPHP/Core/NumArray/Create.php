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
    public static function reshapeData($data)
    {
        $collectedVectors = [];
        $shape = [];
        self::collectVectors($data, $collectedVectors, $shape);
        $dataVector = $data;
        if (count($collectedVectors)) {
            $dataVector = call_user_func_array('array_merge', $collectedVectors);
            if (count($dataVector) !== array_product($shape)) {
                throw new InvalidArgumentException("Dimensions did not match");
            }
        }

        return [$dataVector, $shape];
    }

    protected static function collectVectors($data, &$collectedVectors, &$shape, $level = 0)
    {
        if (is_array($data)) {
            $count = count($data);
            if (isset($shape[$level]) && $shape[$level] !== $count) {
                throw new InvalidArgumentException("Dimensions did not match");
            } else {
                $shape[$level] = $count;
            }
            if ($count && !is_array($data[0])) {
                $collectedVectors[] = $data;
            } else {
                foreach ($data as $entry) {
                    self::collectVectors($entry, $collectedVectors, $shape, $level + 1);
                }
            }
        }
    }
}
