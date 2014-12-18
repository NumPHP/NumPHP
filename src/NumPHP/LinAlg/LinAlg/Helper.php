<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\Exception\InvalidArgumentException;

/**
 * Class Helper
  * @package NumPHP\LinAlg\LinAlg
  */
class Helper
{
    /**
     * @param NumArray $numArray
     * @throws InvalidArgumentException
     */
    public static function isSquare(NumArray $numArray)
    {
        if ($numArray->getNDim() !== 2) {
            throw new InvalidArgumentException(
                'NumArray with dimension '.$numArray->getNDim().' given, NumArray should have 2 dimensions'
            );
        }
        $shape = $numArray->getShape();
        if ($shape[0] !== $shape[1]) {
            throw new InvalidArgumentException(
                'NumArray with shape ('.implode(', ', $shape).') given, NumArray has to be square'
            );
        }
    }
}
