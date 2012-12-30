<?php
require_once __DIR__ . '/Monty.php';
require_once __DIR__ . '/MontySimulator.php';

$simulator = new MontySimulator(MontySimulator::STAY, 5000);
$simulator->run();
echo "Results keeping original door: " . $simulator->getSuccess() . PHP_EOL;

$simulator = new MontySimulator(MontySimulator::CHANGE, 5000);
$simulator->run();
echo "Results changing door: " . $simulator->getSuccess() . PHP_EOL;
