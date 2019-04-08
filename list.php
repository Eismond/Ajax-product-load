<?php

require __DIR__ . '/model.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = isset($_GET['per_page']) ? $_GET['per_page'] : 4;
/*if($_GET['page'] == "2")
		echo $_GET['page'];*/

sleep(2);
	
echo json_encode([
// 	getItems($page, $perPage)
    'entities' => getItems($page, $perPage),
    'total' => getTotal(),
]);