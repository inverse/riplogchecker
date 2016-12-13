<?php

namespace RipLogChecker\Result;

use RipLogChecker\Parser\ParserInterface;


class LogResult implements ResultInterface
{

    /**
     * @var int
     */
    private $score;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param int $baseScore
     * @param ParserInterface $parser
     */
    public function __construct(int $baseScore, ParserInterface $parser)
    {
        $this->score = $baseScore;
        $this->parser = $parser;
        $this->errors = [];
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) !== 0;
    }

    /**
     * @param int $errorId
     * @return bool
     */
    public function containsError(int $errorId): bool
    {
        return array_key_exists($errorId, $this->errors);
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $errorId
     * @param int $point
     * @param string $message
     * @return void
     */
    public function setError(int $errorId, int $point, string $message)
    {
        $this->errors[$errorId] = $message;
        $this->score -= $point;
    }

    /**
     * @return int
     */
    public function getNumErrors(): int
    {
        return count($this->errors);
    }
}