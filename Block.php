<?php
namespace Blockchain;

use DateTime;

/**
 * Class Block
 * This is a building block of the blockchain itself.
 * Here we store each transaction or each data change,
 * to create unbreakable chain of changes and transactions.
 * Each block should be as small as possible.
 *
 * @package Blockchain
 */
class Block implements BlockInterface
{
    /**
     * Insert as small as possible data to blockchain
     * @var array
     */
    protected $data;

    /**
     * Simply change hash with the nonce,
     * so new hash will differ from previously generated
     * @var integer
     */
    protected $nonce;

    /**
     * Add information about time
     * @var DateTime
     */
    protected $timestamp;

    /**
     * Identification of previous block in
     * blockchain
     * @var string
     */
    protected $previousHash;

    /**
     * Hash generated in mining
     * @var string
     */
    protected $hash;

    /**
     * Block constructor.
     * Add information to the block
     * @param DateTime $timestamp
     * @param array $data
     * @param string $previousHash
     */
    public function __construct(DateTime $timestamp, array $data = [], $previousHash = '')
    {
        /**
         * String it here here, to make it
         * faster while creating block
         */
        $this->data = json_encode($data);
        $this->timestamp = $timestamp;
        $this->previousHash = $previousHash;
        $this->hash = $this->generateHash();
    }

    /**
     * Generate hash of data and nonce
     * data needs to be in string
     * @return string
     */
    private function generateHash(): string
    {
        return hash('gost-crypto', $this->previousHash . $this->data . $this->timestamp->format('HH:mm:ss Y-m-d') . $this->nonce);
    }

    /**
     * Proof of work, show that you need power
     * to create new block and it's not easy
     * due to difficulty in the blockchain,
     * so block are created constantly
     *
     * @param $difficulty
     * @return $this
     */
    public function mine($difficulty): BlockInterface
    {
        while (str_split($this->hash, $difficulty)[0] !== str_repeat('0', $difficulty)) {
            $this->nonce++;
            $this->hash = $this->generateHash();
        }

        return $this;
    }

    /**
     * Validate block against difficulty to avoid adding non-mined
     * blocks to the chain and check the hash with nonce
     *
     * @param $difficulty
     * @return bool
     */
    public function validate($difficulty): bool
    {
        return $this->hash === $this->generateHash()
            && str_split($this->hash, $difficulty)[0] === str_repeat('0', $difficulty);
    }

    /**
     * Return hash of the block
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Get hash of previous block
     * @return string
     */
    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    /**
     * Generate JSON of the block
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}