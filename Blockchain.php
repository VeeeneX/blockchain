<?php
namespace Blockchain;

use Blockchain\BlockInterface;
use DateTime;

class Blockchain implements BlockchainInterface
{
    /**
     * @var array
     */
    private $chain = [];

    /**
     * @var int
     */
    private $difficulty;

    /**
     * Blockchain constructor.
     */
    public function __construct()
    {
        $this->chain = [$this->createGenesisBlock()];
        $this->difficulty = 4;
    }

    /**
     * @param BlockInterface $block
     * @return BlockInterface
     */
    public function addBlock(BlockInterface $block)
    {
        $this->chain[] = $block;
        return $block;
    }

    /**
     * @return array
     */
    public function getChain(): array
    {
        return $this->chain;
    }

    /**
     * @param $i
     * @return mixed
     */
    public function getBlock($i): BlockInterface
    {
        return $this->chain[$i];
    }

    /**
     * @return \Blockchain\Block
     */
    private function createGenesisBlock()
    {
        return new Block(new DateTime(), [], '');
    }

    /**
     * @todo 1. Check for longest chain
     * 2. Check work
     * @return bool
     */
    public function validate(): bool
    {
        for ($i = 1; $i < count($this->getChain()); $i++) {
            $currentBlock = $this->getBlock($i);
            $previousBlock = $this->getBlock($i - 1);

            /**
             * Validate current block hash against its generated hash
             */
            if (!$currentBlock->validate($this->difficulty)) {
               return false;
            }

            if ($currentBlock->getPreviousHash() !== $previousBlock->getHash()) {
                return false;
            }

        }

        return true;
    }

    /**
     * @return int
     */
    public function getDifficulty(): int
    {
        return $this->difficulty;
    }
}