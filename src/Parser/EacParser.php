<?php

namespace RipLogChecker\Parser;

use RipLogChecker\Exception\ParserException;
use RipLogChecker\Result\ResultInterface;

class EacParser extends BaseParser
{
    public function parse(string $log): ResultInterface
    {
        $this->log = $log;
        $this->checkReadMode();
        $this->checkDefeatAudioCache();
        $this->checkC2PointersUsed();
        $this->checkFillUpOffsetSamples();
        $this->checkSilentBlockDeletion();
        $this->checkNullSamplesUsed();
        $this->checkGapHandling();
        $this->checkID3TagsAdded();
        $this->checkCRCMismatch();
        $this->checkTestCopyUsed();

        return $this->result;
    }

    protected function checkReadMode()
    {
        $pattern = "/Read mode               : Secure/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check read mode');
        }

        if ($result === 0) {
            $this->setError(self::ERROR_INSECURE_MODE_USED);
        }
    }

    protected function checkDefeatAudioCache()
    {
        $pattern = "/Defeat audio cache      : Yes/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check defeat audio cache');
        }

        if ($result === 0) {
            $this->setError(self::ERROR_DEFEAT_AUDIO_CACHE_DISABLED);
        }
    }


    protected function checkC2PointersUsed()
    {
        $pattern = "/Make use of C2 pointers : No/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check use of C2 pointer');
        }

        if ($result === 1) {
            $this->setError(self::ERROR_C2_POINTERS_USED);
        }
    }


    protected function checkFillUpOffsetSamples()
    {
        $pattern = "/Fill up missing offset samples with silence : Yes/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check fill up offset samples');
        }

        if ($result === 0) {
            $this->setError(self::ERROR_DOES_NOT_FILL_MISSING_SAMPLES);
        }
    }

    protected function checkSilentBlockDeletion()
    {
        $pattern = "/Delete leading and trailing silent blocks   : No/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check silent block detection');
        }

        if ($result === 0) {
            $this->setError(self::ERROR_DELETES_SILENT_BLOCKS);
        }
    }

    protected function checkNullSamplesUsed()
    {
        $pattern = "/Null samples used in CRC calculations       : Yes/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check null samples used');
        }

        if ($result === 0) {
            $this->setError(self::ERROR_NULL_SAMPLES_NOT_USED);
        }
    }


    protected function checkGapHandling()
    {
        $pattern = "/Gap handling                                : Appended to previous track/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check gap handling');
        }

        if ($result === 0) {
            $this->setError(self::ERROR_GAP_HANDLING_NOT_DETECTED);
        }
    }

    protected function checkID3TagsAdded()
    {
        $pattern = "/Add ID3 tag                     : No/";
        $result = preg_match($pattern, $this->log, $matches);

        if ($result === false) {
            throw new ParserException('Failed to check ID3 tags added');
        }

        if ($result === 1) {
            $this->setError(self::ERROR_ID3_TAGS_ADDED);
        }
    }

    protected function checkCRCMismatch()
    {
        /* Find all matches of Test CRC and Copy CRC */
        preg_match_all('/Test CRC/', $this->log, $test_matches, PREG_OFFSET_CAPTURE);
        preg_match_all('/Copy CRC/', $this->log, $copy_matches, PREG_OFFSET_CAPTURE);

        /* Initialize arrays */
        $testCRCs = array();
        $copyCRCs = array();

        /* Save Test CRCs into array */
        foreach ($test_matches[0] as $match) {
            $crc = substr($this->log, $match[1] + 9, 8);
            array_push($testCRCs, $crc);
        }

        /* Save Copy CRCs into array*/
        foreach ($copy_matches[0] as $match) {
            $crc = substr($this->log, $match[1] + 9, 8);
            array_push($copyCRCs, $crc);
        }

        /* Compare the arrays */

        $result = array_diff($testCRCs, $copyCRCs);

        /* If the array diff is empty, there are no mismatching CRCs*/
        /* TODO: Save a list of mismatching CRCs for error reporting */

//        if ($result == null) {
//            return true;
//        } else if ($result != null) {
//            /* TODO: Report error for every CRC mismatch */
//            $this->errors[self::ERROR_CRC_MISMATCH] = true;
//            /* TODO: Deduct points for every mismatch */
//            $this->score += parent::$pointDeductions[self::ERROR_CRC_MISMATCH];
//
//            return true;
//        }
//
//        /* Something went wrong! */
//        return false;
    }

    /**
     * Check if Test & Copy is used, and deduct points if not.
     * Return false on failure.
     *
     * @return bool
     */
    protected function checkTestCopyUsed(): bool
    {
        // TODO: Implement checkTestCopyUsed() method.
        return true;
    }
}