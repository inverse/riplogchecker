<?php

namespace RipLogChecker;

use RipLogChecker\Parser\EacParser;
use RipLogChecker\Parser\ParserInterface;

class LogIdentifier
{
    public function identify(string $log) : ParserInterface
    {
        return new EacParser();
    }
}