<?php
namespace Blockchain;

use Blockchain\Block;
use DateTime;

class Blockchain
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
        $this->difficulty = 7;
    }

    /**
     * @param \Blockchain\Block $block
     * @return \Blockchain\Block
     */
    public function addBlock(Block $block)
    {
        $this->chain[] = $block;
        return $block;
    }

    /**
     * @return array
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @param $i
     * @return mixed
     */
    public function getBlock($i)
    {
        return $this->chain[$i];
    }

    /**
     * @return \Blockchain\Block
     */
    private function createGenesisBlock()
    {
        return  new \Blockchain\Block(new DateTime(), [], '');
    }

    /**
     * @return bool
     */
    public function validate()
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

    public function getDifficulty()
    {
        return $this->difficulty;
    }
}