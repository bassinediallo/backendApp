<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['Id'];
    $name = $data['Name'];
    $price = $data['Price'];
    $categoryId = $data['CategoryId'];

    error_log("Received product for update: Id=$id, Name=$name, Price=$price, CategoryId=$categoryId");

    if (!empty($id) && !empty($name) && !empty($price) && !empty($categoryId)) {
        $stmt = $conn->prepare("UPDATE produits SET name = ?, price = ?, category_id = ? WHERE id = ?");
        
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            echo json_encode(["message" => "Prepare failed: " . $conn->error]);
        } else {
            $stmt->bind_param("sdii", $name, $price, $categoryId, $id);
            if ($stmt->execute()) {
                echo json_encode(["message" => "Product updated successfully"]);
            } else {
                error_log("Error updating product: " . $stmt->error);
                echo json_encode(["message" => "Error updating product: " . $stmt->error]);
            }
            $stmt->close();
        }
    } else {
        error_log("Invalid input: Id=$id, Name=$name, Price=$price, CategoryId=$categoryId");
        echo json_encode(["message" => "Product id, name, price, and category ID cannot be empty"]);
    }
}
?>
