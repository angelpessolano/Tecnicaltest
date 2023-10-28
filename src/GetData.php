<?php

require_once __DIR__.'/config.php';

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}

$page = $_GET['page'] ?? 1;
$limit = $_GET['rows'] ?? 5;

$sql = "SELECT  ca.id_category, cal.name, COUNT(*) AS count
FROM ps_category AS ca 
INNER JOIN ps_category_lang AS cal ON ca.id_category=cal.id_category
INNER JOIN ps_category_product AS cp ON ca.id_category=cp.id_category
WHERE ca.active=1 AND ca.id_parent=(
SELECT id_category FROM ps_category WHERE is_root_category=1
)
AND cp.id_product IN (SELECT pp.id_product FROM ps_product AS pp WHERE pp.active=1)
GROUP BY ca.id_category, cal.name
ORDER BY cal.name";

$result = mysqli_query($con, $sql);

$count = mysqli_num_rows($result);

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$total_pages = 0;

if ($count > 0) {
    $total_pages = ceil($count / $limit);
}

if ($page > $total_pages)
    $page = $total_pages;

$start = $limit * $page - $limit;

$slice = array_slice($rows, $start, $limit);

$response = new stdClass();
$response->page = $page;
$response->total = $total_pages;
$response->records = $count;

$i = 0;
foreach ($slice as $k => $row) {
    $response->rows[$i]['id'] = $row['id_category'];
    $response->rows[$i]['cell'] = array($row['id_category'], $row['name'], $row['count']);
    $i++;
}

echo json_encode($response);

exit;
