<?php
$host = 'localhost';
$dbname = 'Scinema';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tables = array(); // เก็บชื่อตารางทั้งหมด
    $stmt = $conn->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tables[] = $row['Tables_in_' . $dbname];
    }

    $all_data = array(); // เก็บข้อมูลทั้งหมด
    foreach ($tables as $table) {
        $stmt = $conn->query("SELECT * FROM $table");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $all_data[$table] = $data; // บันทึกข้อมูลของแต่ละตารางในอาร์เรย์
    }

    header('Content-Type: application/json');
    echo json_encode($all_data);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
