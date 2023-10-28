<?php

require_once __DIR__.'/config.php';

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

$response = null;

if ($stmt = $mysqli->prepare($sql)) {

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
        $response->rows[$i]['id'] = $row['id_category'];
        $response->rows[$i]['cell'] = array($row['id_category'], $row['name'], $row['count']);
        $i++;
    }
}

echo json_encode($response);

exit;
