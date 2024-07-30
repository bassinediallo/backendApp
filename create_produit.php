<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['Name'];
    $price = $data['Price'];
    $categoryId = $data['CategoryId'];

    error_log("Received product: Name=$name, Price=$price, CategoryId=$categoryId");

    if (!empty($name) && !empty($price) && !empty($categoryId)) {
        $stmt = $conn->prepare("INSERT INTO produits (name, price, category_id) VALUES (?, ?, ?)");
        
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            echo json_encode(["message" => "Prepare failed: " . $conn->error]);
        } else {
            $stmt->bind_param("sdi", $name, $price, $categoryId);
            if ($stmt->execute()) {
                echo json_encode(["message" => "Product added successfully"]);
            } else {
                error_log("Error adding product: " . $stmt->error);
                echo json_encode(["message" => "Error adding product: " . $stmt->error]);
            }
            $stmt->close();
        }
    } else {
        error_log("Invalid input: Name=$name, Price=$price, CategoryId=$categoryId");
        echo json_encode(["message" => "Product name, price, and category ID cannot be empty"]);
    }
}
?>
