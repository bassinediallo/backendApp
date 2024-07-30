<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$sql = "DELETE FROM produits WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Product deleted successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}
?>
