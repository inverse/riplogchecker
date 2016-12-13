<?php

namespace RipLogChecker\Result;



interface ResultInterface
{
    /**
     * @param int $errorId
     * @param int $point
     * @param string $message
     * @return void
     */
    public function setError(int $errorId, int $point, string $message);

    /**
     * @return array
     */
    public function getErrorMessages(): array;

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @param int $errorId
     * @return bool
     */
    public function containsError(int $errorId) : bool;

    /**
     * @return int
     */
    public function getNumErrors(): int;

    /**
     * @return int
     */
    public function getScore(): int;
}