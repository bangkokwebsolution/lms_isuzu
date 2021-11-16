<?php

// if($_SERVER['HTTP_HOST'] == 'localhost'){
// 	return 	array(
// 		'class' => 'CDbConnection',
//         'connectionString' => 'mysql:host=localhost;dbname=db_dbd',
//         'emulatePrepare' => true,
//         'username' => 'root',
//         'password' => '',
//         'tablePrefix' => 'tbl_',
// 		'charset'=>'utf8',
// 	);
// }else{



// return array(
//     'class' => 'CDbConnection',
//     'connectionString' => 'mysql:host=203.154.140.77;dbname=db_cp',
//     'emulatePrepare' => true,
//     'username' => 'ice@Bws2019',
//     'password' => 'bws@!icekp!',
//     'tablePrefix' => 'tbl_',
//     'charset' => 'utf8',
//     'initSQLs'=>array(
//         "SET time_zone = '+07:00'"
//     )
// );



// return     array(
// 'class' => 'CDbConnection',
//     'connectionString' => 'mysql:host=taaelearning.cuh6uuk8ensz.ap-southeast-1.rds.amazonaws.com;dbname=taaelearning',
//         'emulatePrepare' => true,
//         'username' => 'lmsairasia',
//         'password' => 'z14ef4cE',
//     'tablePrefix' => 'tbl_',
//     'charset' => 'utf8',
//     'initSQLs'=>array(
// 		"SET time_zone = '+07:00'"
// 	)
// 	);



      return  array(
    'class' => 'CDbConnection',
    'connectionString' => 'mysql:host=203.154.39.185;dbname=db_isuzu',
    'emulatePrepare' => true,
    'username' => 'Db_Lms',
    'password' => 'Admin@123#',
    'tablePrefix' => 'tbl_',
    'charset' => 'utf8',
    'initSQLs'=>array(
        "SET time_zone = '+07:00'"
    )
);



// }