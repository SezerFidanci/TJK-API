<?php

use TJK\TJK;

require_once __DIR__ . '/autoload.php';

$tjkAPI = new TJK();


//$data = $tjkAPI->getTodayRaces();

//$data = $tjkAPI->getRacesByDate('20210411');

$data = $tjkAPI->getTodayResult();

//$data = $tjkAPI->getResultByDate('20210410');

echo json_encode($data);
die();