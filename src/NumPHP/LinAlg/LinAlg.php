<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\Exception\InvalidArgumentException;

/**
 * Class LinAlg
  * @package NumPHP\LinAlg
  */
class LinAlg
{
    /**
     * @param $array
     * @return int
     * @throws InvalidArgumentException
     */
    public static function det($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        }
        if ($array->getNDim() !== 2) {
            throw new InvalidArgumentException(
                'NumArray with dimension '.$array->getNDim().' given, NumArray should have 2 dimensions'
            );
        }
        $shape = $array->getShape();
        if ($shape[0] !== $shape[1]) {
            throw new InvalidArgumentException(
                'NumArray with shape ('.implode(', ', $shape).') given, NumArray has to be square'
            );
        }

        $lud = LUDecomposition::lud($array);
        /** @var NumArray $uMatrix */
        $uMatrix = $lud['U'];
        $det = 1;
        for ($i = 0; $i < $shape[0]; $i++) {
            $det *= $uMatrix->get($i, $i)->getData();
        }

        return $det;
    }
}
