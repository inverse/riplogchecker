<?php

namespace Test\RipLogChecker\Parser;

use PHPUnit_Framework_TestCase;
use RipLogChecker\Parser\BaseParser;
use RipLogChecker\Parser\EacParser;

class EacParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EacParser
     */
    private $parser;

    public function setUp()
    {
        parent::setUp();
        $this->parser = new EacParser();
    }

    public function testC2PointersUsedCheck()
    {
        $result = $this->parser->parse(file_get_contents(ROOT_TEST_DIR . '/fixtures/c2_pointers_used_test.log'));

        $this->assertTrue($result->containsError(BaseParser::ERROR_C2_POINTERS_USED));

        $this->assertEquals(90, $result->getScore());
    }
}
