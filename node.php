<?php

require_once __DIR__.'/vendor/autoload.php';

//$blockchain = new \Blockchain\Blockchain();
//$newBlock = new \Blockchain\Block(new DateTime(), ['data' => 'hello'], $blockchain->getBlock(0)->getHash());
//$newBlock->mine($blockchain->getDifficulty());
//
//var_dump($blockchain->getChain());
//var_dump($blockchain->addBlock($newBlock));
//var_dump($blockchain->validate());

$loop = React\EventLoop\Factory::create();
$factory = new React\Datagram\Factory($loop);
$factory->createServer('localhost:1234')->then(function (React\Datagram\Socket $server) {
    $server->on('message', function($message, $address, $server) {
        $server->send('hello ' . $address . '! echo: ' . $message, $address);
        echo 'client ' . $address . ': ' . $message . PHP_EOL;
    });
});
$loop->run();