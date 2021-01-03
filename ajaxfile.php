<?php
include 'config.php';

## Read value
$draw = $_GET['draw'];
$row = $_GET['start'];
$rowperpage = $_GET['length']; // Rows display per page
$columnIndex = $_GET['order'][0]['column']; // Column index
$columnName = $_GET['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_GET['order'][0]['dir']; // asc or desc
$searchValue = $_GET['search']['value']; // Search value

$param = [
  "draw"  =>$draw,
  "row" =>$row,
  "rowperpage" => $rowperpage,
  "columnIndex" => $columnIndex,
  "columnName" => $columnName,
  "columnSortOrder" => $columnSortOrder,
  "searchValue" => $searchValue
];

//WRITE A MESSAGE TO A FILE IN THE SAME DIRECTORY
$file = __DIR__ . '/Params.txt';
$info = 'Script was executed at ' . date('d-M-y H:i:s') . "\n" . json_encode($param) . "\n" ;
file_put_contents($file, $info, FILE_APPEND);
//END OF WRITING TO FILE

$searchArray = array();

## Search 
$searchQuery = " ";
if($searchValue != ''){

	$searchQuery = " AND (
        emp_name LIKE :emp_name OR 
        email LIKE :email OR 
        city LIKE :city ) ";
        
    $searchArray = [ 
        'emp_name'=>"%$searchValue%", 
        'email'=>"%$searchValue%",
        'city'=>"%$searchValue%"
    ];
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM employee ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM employee WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];



## Fetch records
$stmt = $conn->prepare("SELECT * FROM employee WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

// Bind values
foreach($searchArray as $key=>$search){
    $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}
$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
//End of Bind values
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach($empRecords as $row){
    $data[] = array(
            "emp_name"=>$row['emp_name'],
            "email"=>$row['email'],
            "gender"=>$row['gender'],
            "salary"=>$row['salary'],
            "city"=>$row['city']
        );
}

## Response
$response = array(
    "draw" => intval($draw),// for every request/draw by client side , they send a number as a parameter, when they receive a response/data they first check the draw number, so we are sending same number in draw.
    "iTotalRecords" => $totalRecords,// total number of records
    "iTotalDisplayRecords" => $totalRecordwithFilter,// total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $data // total data array
);

echo json_encode($response);
//WRITE A MESSAGE TO A FILE IN THE SAME DIRECTORY
$file = __DIR__ . '/Response.txt';
$info = 'Script was executed at ' . date('d-M-y H:i:s') . "\n" . json_encode($response) . "\n" ;
file_put_contents($file, $info, FILE_APPEND);
//END OF WRITING TO FILE