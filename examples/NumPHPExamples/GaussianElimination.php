<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples;

use NumPHP\Core\NumArray;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GaussianElimination
 *
 * @package   NumPHPExamples
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class GaussianElimination extends Command
{
    protected function configure()
    {
        $this->setName('gaussian-elimination')
            ->setDescription('Solves a small system of linear equations with gaussian elimination');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $matrixA = new NumArray(
            [
                [11.0, 44.0, 1.0],
                [0.1, 0.4, 3.0],
                [0.0, 1.0, -1.0],
            ]
        );
        $output->writeln('<comment>Matrix A:</comment>');
        $output->writeln($matrixA->__toString());

        $vectorB = new NumArray(
            [1.0, 1.0, 1.0]
        );
        $output->writeln('<comment>Vector b:</comment>');
        $output->writeln($vectorB->__toString());

        $time = microtime(true);
        $gaussianResult = self::gaussianEliminationPivoting($matrixA, $vectorB);
        $xVector = self::backSubstitution($gaussianResult['M'], $gaussianResult['b']);
        $timeDiff = microtime(true) - $time;

        $output->writeln('<info>Solution of A*x=b?</info>');
        $output->writeln('<comment>Vector x:</comment>');
        $output->writeln($xVector->__toString());
        $output->writeln('<info>Time for calculation: '.$timeDiff.' sec</info>');
    }

    /**
     * @param NumArray $matrix
     * @param NumArray $vector
     * @return array
     */
    protected static function gaussianEliminationPivoting(NumArray $matrix, NumArray $vector)
    {
        $shape = $matrix->getShape();

        for ($i = 0; $i < $shape[0]; $i++) {
            // find pivo element
            $max = abs($matrix->get($i, $i)->getData());
            $maxIndex = $i;
            for ($j = $i+1; $j < $shape[0]; $j++) {
                $abs = abs($matrix->get($j, $i)->getData());
                if ($abs > $max) {
                    $max = $abs;
                    $maxIndex = $j;
                }
            }
            // pivoting
            if ($maxIndex !== $i) {
                // change maxIndex row with i row in $matrix
                $temp = $matrix->get($i);
                $matrix->set($i, $matrix->get($maxIndex));
                $matrix->set($maxIndex, $temp);
                // change maxIndex row with i row in $vector
                $temp = $vector->get($i);
                $vector->set($i, $vector->get($maxIndex));
                $vector->set($maxIndex, $temp);
            }
            for ($j = $i+1; $j < $shape[0]; $j++) {
                $fac = -$matrix->get($j, $i)->getData()/$matrix->get($i, $i)->getData();
                $matrix->set($j, $matrix->get($j)->add($matrix->get($i)->dot($fac)));
                $vector->set($j, $vector->get($j)->add($vector->get($i)->dot($fac)));
            }
        }

        return [
            'M' => $matrix,
            'b' => $vector
        ];
    }

    /**
     * @param NumArray $matrix
     * @param NumArray $vector
     * @return NumArray
     */
    protected static function backSubstitution(NumArray $matrix, NumArray $vector)
    {
        $shape = $matrix->getShape();
        $xVector = \NumPHP\Core\NumPHP::zeros($shape[0]);

        for ($i = $shape[0]-1; $i >= 0; $i--) {
            $sum = 0;
            for ($j = $i+1; $j < $shape[0]; $j++) {
                $sum += $matrix->get($i, $j)->dot($xVector->get($j))->getData();
            }
            $xVector->set($i, ($vector->get($i)->getData()-$sum)/$matrix->get($i, $i)->getData());
        }

        return $xVector;
    }
}
