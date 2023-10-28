<?php

require_once __DIR__.'/config.php';

$id_product = $_GET['id_product'] ?? 0;

$page = $_GET['page'] ?? 1;
$limit = $_GET['rows'] ?? 5;

$sql = "SELECT fl.id_feature, fl.name, fv.value
        FROM ps_feature_product f 
        INNER JOIN ps_feature_lang fl ON fl.id_feature=f.id_feature
        INNER JOIN ps_feature_value_lang fv ON fv.id_feature_value=f.id_feature_value
        WHERE f.id_product = ? ";

$response = null;

if ($stmt = $mysqli->prepare($sql)) {

    $stmt->bind_param("i", $id_product);

    $stmt->execute();

    $result = $stmt->get_result();

    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $count = count($rows);

    $total_pages = $count > 0 ? ceil($count / $limit) : 0;
    
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
}

echo json_encode($response);

exit;
