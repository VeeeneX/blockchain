<?php

include 'Block.php';
include 'Blockchain.php';

$blockchain = new \Blockchain\Blockchain();
$newBlock = new \Blockchain\Block(new DateTime(), ['data' => 'hello'], $blockchain->getBlock(0)->getHash());
$newBlock->mine($blockchain->getDifficulty());

var_dump($blockchain->getChain());
var_dump($blockchain->addBlock($newBlock));
var_dump($blockchain->validate());