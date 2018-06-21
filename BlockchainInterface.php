<?php
namespace Blockchain;


interface BlockchainInterface
{
    /**
     * @param BlockInterface $block
     * @return \Blockchain\Block
     */
    public function addBlock(BlockInterface $block);

    /**
     * @return array
     */
    public function getChain(): array;

    /**
     * @param $i
     * @return mixed
     */
    public function getBlock($i): BlockInterface;

    /**
     * @return bool
     */
    public function validate(): bool;

    /**
     * @return int
     */
    public function getDifficulty(): int;
}