<?php
include 'db.php';

$sql = "SELECT * FROM produits";
$result = $conn->query($sql);

$produits = [];
while ($row = $result->fetch_assoc()) {
    $produits[] = [
        'Id' => $row['id'],
        'Name' => $row['name'],
        'Price' => $row['price'],
        'CategoryId' => $row['category_id']
    ];
}

echo json_encode($produits);
?>
