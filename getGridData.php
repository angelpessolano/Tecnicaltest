<?php 

define('DB_HOST', 'localhost');
define('DB_NAME', 'testing_db');
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


//$result = mysqli_query("SELECT COUNT(*) AS count FROM employees");

$result = mysqli_query($con, "SELECT COUNT(*) AS count FROM employees");

$row = mysqli_fetch_array($result);
$count = $row['count'];

if( $count >0 ) { 
$total_pages = ceil($count/$limit);
//$total_pages = ceil($count/1);
} else {
$total_pages = 0; 
} if ($page > $total_pages) 
$page=$total_pages; 
$start = $limit*$page - $limit; // do not put $limit*($page - 1) 

$SQL = "SELECT * from employees ORDER BY $sidx $sord LIMIT $start , $limit"; 

$result = mysqli_query($con, $SQL);

$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count; 
$i=0;
while($row = mysqli_fetch_array($result)) { 

      // echo '<pre style="background:whitesmoke">';
      // var_dump($row);
      // echo '</pre>';

$responce->rows[$i]['id']=$row['id'];
$responce->rows[$i]['cell']=array($row['id'], $row['name']); $i++;
} 
echo json_encode($responce);

exit;
