<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

/**
 * Class Transpose
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Transpose
{
    const CACHE_KEY_TRANSPOSE = 'transpose';

    /**
     * Creates a transposed value or array
     *
     * @param mixed $data  given data
     * @param array $shape the shape of the data
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public static function getTranspose($data, array $shape)
    {
        if (is_array($data)) {
            $transposeData = [];
            $factors = Helper::getFactorsFromShape(array_reverse($shape));
            foreach ($data as $position => $entry) {
                $newPosition = Helper::getPositionFromIndexes(
                    array_reverse(Helper::getIndexesFromPosition($position, $shape)),
                    $factors
                );
                $transposeData[$newPosition] = $entry;
            }

            return $transposeData;
        }

        return $data;
    }
}
