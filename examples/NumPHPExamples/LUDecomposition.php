<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\LinAlg;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LUDecomposition
 *
 * @package   NumPHPExamples
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class LUDecomposition extends Command
{
    protected function configure()
    {
        $this->setName('lu-decomposition')
            ->setDescription('Factors a matrix into a permutation matrix, a lower and a upper triangular matrix');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $matrixA = new NumArray(
            [
                [1, 6, 1],
                [2, 3, 2],
                [4, 2, 1],
            ]
        );
        $output->writeln('<comment>Matrix A:</comment>');
        $output->writeln($matrixA->__toString());

        $output->writeln('<info>LU decomposition</info>');
        $time = microtime(true);
        list($matrixP, $matrixL, $matrixU) = LinAlg::lud($matrixA);
        $timeDiff = microtime(true) - $time;

        $output->writeln('<comment>Matrix P:</comment>');
        $output->writeln($matrixP->__toString());

        $output->writeln('<comment>Matrix L:</comment>');
        $output->writeln($matrixL->__toString());

        $output->writeln('<comment>Matrix U:</comment>');
        $output->writeln($matrixU->__toString());

        $output->writeln('<info>Time for calculation: '.$timeDiff.' sec</info>');
    }
}
