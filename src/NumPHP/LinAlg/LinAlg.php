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
use NumPHP\LinAlg\LinAlg\Helper;

/**
 * Class LinAlg
  * @package NumPHP\LinAlg
  */
class LinAlg
{
    /**
     * @param $array
     * @return array|int|mixed
     * @throws Exception\InvalidArgumentException
     */
    public static function det($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        }
        Helper::isSquare($array);

        $lud = LUDecomposition::lud($array);
        /** @var NumArray $uMatrix */
        $uMatrix = $lud['U'];
        $shape = $uMatrix->getShape();
        $det = 1;
        for ($i = 0; $i < $shape[0]; $i++) {
            $det *= $uMatrix->get($i, $i)->getData();
        }

        return $det;
    }
}
