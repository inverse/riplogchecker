<?php

namespace RipLogChecker\Parser;

use RipLogChecker\Result\LogResult;

abstract class BaseParser implements ParserInterface
{
    const BASE_SCORE = 100;

    /**
     * The point deduction constants
     */
    const ERROR_INSECURE_MODE_USED = 0;
    const ERROR_DEFEAT_AUDIO_CACHE_DISABLED = 1;
    const ERROR_C2_POINTERS_USED = 2;
    const ERROR_DOES_NOT_FILL_MISSING_SAMPLES = 3;
    const ERROR_GAP_HANDLING_NOT_DETECTED = 4;
    const ERROR_DELETES_SILENT_BLOCKS = 5;
    const ERROR_NULL_SAMPLES_NOT_USED = 6;
    const ERROR_ID3_TAGS_ADDED = 7;
    const ERROR_CRC_MISMATCH = 8;
    const ERROR_TEST_COPY_NOT_USED = 9;

    /**
     * Explanatory messages for the deductions
     *
     * @var array
     */
    public static $errorMessages = [
        self::ERROR_INSECURE_MODE_USED => 'Insecure mode was used (-2 points)',
        self::ERROR_DEFEAT_AUDIO_CACHE_DISABLED => 'Defeat audio cache should be yes (-5 points)',
        self::ERROR_C2_POINTERS_USED => 'C2 pointers were used (-10 points)',
        self::ERROR_DOES_NOT_FILL_MISSING_SAMPLES => 'Does not fill up missing offset samples with silence (-5 points)',
        self::ERROR_GAP_HANDLING_NOT_DETECTED => 'Gap handling was not detected (-5 points)',
        self::ERROR_DELETES_SILENT_BLOCKS => 'Deletes leading and trailing silent blocks (-5 points)',
        self::ERROR_NULL_SAMPLES_NOT_USED => 'Null samples should be used in CRC calculations (-5 points)',
        self::ERROR_ID3_TAGS_ADDED => 'ID3 tags should not be added to FLAC files. FLAC files should have Vorbis comments for tags instead.',
        self::ERROR_CRC_MISMATCH => 'CRC mismatch (-30 points)',
        self::ERROR_TEST_COPY_NOT_USED => 'Test and Copy was not used (-10 points)',
    ];

    /**
     * @var array
     */
    protected static $pointDeductions = [
        self::ERROR_INSECURE_MODE_USED => 2,
        self::ERROR_DEFEAT_AUDIO_CACHE_DISABLED => 5,
        self::ERROR_C2_POINTERS_USED => 10,
        self::ERROR_DOES_NOT_FILL_MISSING_SAMPLES => 5,
        self::ERROR_GAP_HANDLING_NOT_DETECTED => 5,
        self::ERROR_DELETES_SILENT_BLOCKS => 5,
        self::ERROR_NULL_SAMPLES_NOT_USED => 5,
        self::ERROR_ID3_TAGS_ADDED => 0,
        self::ERROR_CRC_MISMATCH => 30,
        self::ERROR_TEST_COPY_NOT_USED => 10,
    ];

    /**
     * The full text of the log file
     *
     * @var string
     */
    protected $log;

    /**
     * @var LogResult
     */
    protected $result;

    public function __construct()
    {
        $this->result = new LogResult(self::BASE_SCORE, $this);
    }

    /**
     * @param int $errorId
     */
    protected function setError(int $errorId)
    {
        $this->result->setError($errorId, self::$pointDeductions[$errorId], self::$errorMessages[$errorId]);
    }
}