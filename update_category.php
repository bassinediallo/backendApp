<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['Id'];
    $name = $data['Name'];
    
    error_log("Updating category ID: " . $id . " to name: " . $name); // Log for debugging

    if (!empty($id) && !empty($name)) {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Category updated successfully"]);
        } else {
            echo json_encode(["message" => "Error updating category: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Category ID and name cannot be empty"]);
    }
}
?>
