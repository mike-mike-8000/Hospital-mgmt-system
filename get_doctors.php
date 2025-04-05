<?php
    include 'db.php';

    if (isset($_GET['specialty'])) {
        $specialty = $_GET['specialty'];
        $stmt = $conn->prepare("SELECT fname, lname FROM doctors WHERE specialty = ?");
        $stmt->bind_param("s", $specialty);
        $stmt->execute();
        $result = $stmt->get_result();

        $doctors = [];
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row['fname'] . ' ' . $row['lname'];
        }

        echo json_encode($doctors);
    } else {
        echo json_encode([]);
    }
?>