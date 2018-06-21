<?php

namespace Blockchain;

interface BlockInterface
{
    /**
     * @param $difficulty
     * @return $this
     */
    public function mine($difficulty): BlockInterface;

    /**
     * Validate block against difficulty to avoid adding non-mined
     * blocks to the chain
     *
     * @param $difficulty
     * @return bool
     */
    public function validate($difficulty): bool;

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @return string
     */
    public function getPreviousHash(): string;

    /**
     * @return string
     */
    public function toJson(): string;
}