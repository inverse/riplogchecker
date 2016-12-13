<?php

namespace RipLogChecker\Parser;

use RipLogChecker\Result\ResultInterface;

interface ParserInterface
{
    /**
     * @param string $log
     * @return ResultInterface
     */
    public function parse(string $log): ResultInterface;
}