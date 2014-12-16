<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core;

use NumPHP\Core\Version;

/**
 * Class VersionTest
  * @package NumPHPTest\Core
  */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    public function testREADMEVersion()
    {
        $readmeContent = file_get_contents(realpath(__DIR__.'/../../../README.md'));
        $this->assertNotFalse(
            strpos($readmeContent, '*NumPHP '.Version::VERSION.'*'),
            'Version in README.md is not updated'
        );
    }
}
