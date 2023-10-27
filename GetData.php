<?php 

define('DB_HOST', 'localhost');
define('DB_NAME', 'midcenturywareho_psdb2');
define('DB_USER','root');
define('DB_PASSWORD','');

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) ;

/* comprobar la conexión */
if (mysqli_connect_errno()) {
      printf("Falló la conexión: %s\n", mysqli_connect_error());
      exit();
}

$page = $_GET['page'] ?? 1; // get the requested page
$limit = $_GET['rows']??5; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']??''; // get index row - i.e. user click to sort
$sord = $_GET['sord']??''; // get the direction
if(!$sidx) $sidx =1; // connect to the database

$sql = "SELECT  ca.id_category, cal.name, COUNT(*) AS count
FROM ps_category AS ca 
INNER JOIN ps_category_lang AS cal ON ca.id_category=cal.id_category
INNER JOIN ps_category_product AS cp ON ca.id_category=cp.id_category
WHERE ca.active=1 AND ca.id_parent=(
SELECT id_category FROM ps_category WHERE is_root_category=1
)
AND cp.id_product IN (SELECT pp.id_product FROM ps_product AS pp WHERE pp.active=1)
GROUP BY ca.id_category, cal.name
ORDER BY 2";


//$result = mysqli_query("SELECT COUNT(*) AS count FROM employees");

$result = mysqli_query($con, $sql);

    // Return the number of rows in result set 
$count = mysqli_num_rows( $result ); 
      
    // Display result 
// printf("Total rows in this table : %d\n", $count); 

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// echo '<pre style="background:whitesmoke">';
// var_dump($rows);
// echo '</pre>';


if( $count > 0 ) { 
$total_pages = ceil($count/$limit);

} else {
$total_pages = 0; 
} 

if ($page > $total_pages) 
      $page = $total_pages; 

$start = $limit*$page - $limit; // do not put $limit*($page - 1) 




$slice = array_slice($rows, $start, $limit);










$response = new stdClass();
$response->page = $page;
$response->total = $total_pages;
$response->records = $count; 
$i=0;

foreach ($slice as $k => $row) {
      
      // echo '<pre>' .var_dump($k) . '</pre>';
      // echo '<pre>' .var_dump($row) . '</pre><hr>';

      $response->rows[$i]['id']=$row['id_category'];
      $response->rows[$i]['cell']=array($row['id_category'], $row['name'],$row['count']); 
      $i++;
}


echo json_encode($response);

exit;
