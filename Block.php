<?php
namespace Blockchain;

use DateTime;

/**
 * Class Block
 * @package Blockchain
 */
class Block
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var integer
     */
    protected $nonce;

    /**
     * @var DateTime
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $previousHash;

    /**
     * @var string
     */
    protected $hash;

    /**
     * Block constructor.
     * @param DateTime $timestamp
     * @param array $data
     * @param string $previousHash
     */
    public function __construct(DateTime $timestamp, array $data = [], $previousHash = '')
    {
        $this->data = $data;
        $this->timestamp = $timestamp;
        $this->previousHash = $previousHash;
        $this->hash = $this->generateHash();
    }

    /**
     * @return string
     */
    private function generateHash()
    {
        return hash('gost-crypto', $this->previousHash . json_encode($this->data) . $this->timestamp->format('HH:mm:ss Y-m-d') . $this->nonce);
    }

    /**
     * @param $difficulty
     * @return $this
     */
    public function mine($difficulty)
    {
        while (str_split($this->hash, $difficulty)[0] !== str_repeat('0', $difficulty)) {
            $this->nonce++;
            $this->hash = $this->generateHash();
        }

        return $this;
    }

    /**
     * Validate block against difficulty to avoid adding non-mined
     * blocks to the chain
     *
     * @param $difficulty
     * @return bool
     */
    public function validate($difficulty)
    {
        return $this->hash === $this->generateHash()
            && str_split($this->hash, $difficulty)[0] === str_repeat('0', $difficulty);
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getPreviousHash()
    {
        return $this->previousHash;
    }


    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}