<?php
require_once 'db.config.php';
header('Content-Type: application/json');
$res = $_GET['res'];
$sql = 'SELECT title, link, date, description FROM item WHERE MATCH(title, link, description) AGAINST("' . $res . '" IN NATURAL LANGUAGE MODE);';
$result = $conn->query($sql);
$data = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $item = [
            'title' => $row['title'],
            'link' => $row['link'],
            'date' => $row['date'],
            'description' => $row['description']
        ];
        array_push($data, $item);
    }
    echo json_encode($data);
} else {
    echo json_encode('0 results');
}
$conn->close();