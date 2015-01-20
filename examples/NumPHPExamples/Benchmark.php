<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples;

use NumPHPExamples\Benchmark\Core\NumArray\Abs;
use NumPHPExamples\Benchmark\Core\NumArray\Add;
use NumPHPExamples\Benchmark\Core\NumArray\Create;
use NumPHPExamples\Benchmark\Core\NumArray\Dot;
use NumPHPExamples\Benchmark\Core\NumArray\Sum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Benchmark
 *
 * @package   NumPHPExamples
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.5
 */
class Benchmark extends Command
{
    /**
     * @var array
     */
    protected $benchmarks = [];

    protected function configure()
    {
        $this->setName('benchmark')
            ->setDescription('Benchmarks basic function');
        $this->benchmarks = [
            new Create(),
            new Add(),
            new Sum(),
            new Abs(),
            new Dot(),
        ];
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->benchmarks as $benchmark) {
            /** @var Benchmark\BenchmarkInterface $benchmark */
            $output->writeln(sprintf("<comment>%s</comment>", $benchmark->getName()));
            $result = $benchmark->run();
            foreach ($result as $testRun) {
                /** @var Benchmark\TestRun $testRun */
                $output->writeln(sprintf("\t%d: <info>%f</info>", $testRun->getComplexity(), $testRun->getTime()));
            }
        }
    }
}
