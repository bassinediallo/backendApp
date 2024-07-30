<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['Name'];
    
    error_log("Received category name: " . $name); // Log for debugging

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Category added successfully"]);
        } else {
            echo json_encode(["message" => "Error adding category: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Category name cannot be empty"]);
    }
}
?>
