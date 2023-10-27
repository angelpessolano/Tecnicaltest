<?php 
$id_category=$_GET['id_category'];
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

$sql = "SELECT pp.id_product, ppl.name, 
(SELECT COUNT(f.id_feature) FROM ps_feature_product f WHERE f.id_product=pp.id_product) AS count
FROM ps_product_lang AS ppl 
JOIN ps_product AS pp ON ppl.id_product = pp.id_product 
INNER JOIN ps_category_product AS cp ON pp.id_product=cp.id_product
WHERE pp.active=1
AND cp.id_category=$id_category
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

      $response->rows[$i]['id']=$row['id_product'];
      $response->rows[$i]['cell']=array($row['id_product'], $row['name'],$row['count']); 
      $i++;
}


echo json_encode($response);

exit;
