<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'midcenturywareho_psdb2');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

/* comprobar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}

$id_product = $_GET['id_product'] ?? 0;

$page = $_GET['page'] ?? 1;
$limit = $_GET['rows'] ?? 5;

$sql = "SELECT fl.id_feature, fl.name, fv.value
FROM ps_feature_product f 
INNER JOIN ps_feature_lang fl ON fl.id_feature=f.id_feature
INNER JOIN ps_feature_value_lang fv ON fv.id_feature_value=f.id_feature_value
WHERE f.id_product=$id_product";

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
    $response->rows[$i]['id'] = $row['id_feature'];
    $response->rows[$i]['cell'] = array($row['id_feature'], $row['name'], $row['value']);
    $i++;
}

echo json_encode($response);

exit;
