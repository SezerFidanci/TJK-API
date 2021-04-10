<?php

use TJK\TJK;

require_once __DIR__ . '/autoload.php';

$tjkAPI = new TJK();


//echo json_encode($tjkAPI->getTodayRaces());

//echo json_encode($tjkAPI->getRacesByDate('20210415'));

//echo json_encode($tjkAPI->getTodayResult());

echo json_encode($tjkAPI->getResultByDate('20210410'));

return;