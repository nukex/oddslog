<?php


require_once ('libs/sqlite.php');


$db = new SQLite(
    ['driver' => 'sqlite',
                 'url' => 'matchs.db'
    ]);



    $insert = $db->insertArray('matchs', 
        [
         
            [   'id' => NULL,
                'eventID' => 'KKDLDLKDL:DKD',
                'date' =>  $db->func('date', 'Y-m-d H:i:s'),
            ],
               
       
            [   'id' => NULL,
                'eventID' => '2KKDLDLKDL:DKD',
                'date' =>  $db->func('date', 'Y-m-d H:i:s'),
            ],
               
       
            [   'id' => NULL,
                'eventID' => '2KKDLDLKDL:DKD',
                'date' =>  $db->func('date', 'Y-m-d H:i:s'),
            ],
               
       
        ]
        ) ->run();

