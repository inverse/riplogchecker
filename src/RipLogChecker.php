<?php

namespace RipLogChecker;

use RipLogChecker\Exception\LogIdentifierException;
use RipLogChecker\Result\ResultInterface;

class RipLogChecker
{
    /**
     * @var LogIdentifier
     */
    private $logIdentifier;


    /**
     * @param LogIdentifier $logIdentifier
     */
    public function __construct(LogIdentifier $logIdentifier)
    {
        $this->logIdentifier = $logIdentifier;
    }

    /**
     * @param string $log
     * @return ResultInterface
     * @throws LogIdentifierException
     */
    public function parse(string $log) : ResultInterface
    {
        $parser = $this->logIdentifier->identify($log);

        if ($parser === null) {
            throw new LogIdentifierException('Unable to match given log file');
        }

        return $parser->parse($log);
    }
}