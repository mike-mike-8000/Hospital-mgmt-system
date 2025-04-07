<?php
    session_start();
    if (!isset($_SESSION['patient_id'])) {
        header("Location: index.html");
        exit();
    }

    include 'db.php';

    $patient_id = $_SESSION['patient_id'];
    $sql = "SELECT first_name, last_name, email, phone FROM patients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $stmt->bind_result($fname, $lname, $email, $phone);
    $stmt->fetch();
    $stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Panel - Hospital Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4fef4;
        }

        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar h2 {
            color: white;
            margin: 0;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar ul li {
            margin-left: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .navbar ul li a:hover {
            background-color: #45a049;
        }

        .navbar ul li a#logout-link:hover {
            background-color: red;
            color: white;
        }

        .banner {
            position: relative;
            width: 100%;
            height: 300px;
            overflow: hidden;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.85);
        }

        .banner-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
        }

        .content {
            padding: 30px;
            margin-top: 20px;
        }

        h2 {
            color: #388E3C;
        }

        section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .hidden {
            display: none;
        }

        .toggle-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .toggle-btn:hover {
            background-color: #45a049;
        }

        .notifications, .upcoming-appointments, .recent-activity {
            padding: 15px;
            background-color: #e8f5e9;
            border-left: 5px solid #4CAF50;
            margin-top: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label, select, input, button {
            margin-bottom: 10px;
        }

        select {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        select#time {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            z-index: 10;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar">
        <h2>Patient Panel</h2>
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#book-appointment">Book Appointment</a></li>
            <li><a href="#profile">Profile</a></li>
            <li><a href="#" id="logout-link">Logout</a></li>
        </ul>
    </nav>

    <!-- Image Banner -->
    <div class="banner">
        <img src="images/Hosp_pic2.jpg" alt="Serenity Hospital">
        <div class="banner-text">Welcome to Serenity Hospital</div>
    </div>

    <!-- Main Content -->
    <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="notifications">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="notifications" style="border-left: 5px solid red; background-color: #fce4e4;">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
    ?>

    <main class="content">
        <!-- Dashboard -->
        <section id="dashboard">
            <h2>Serenity Hospital Booking Center</h2>
            <p>Welcome to Serenity Hospital Booking Center! Here you can manage your appointments.</p>

            <!-- Toggle Buttons -->
            <button class="toggle-btn" onclick="toggleVisibility('notifications')">🔔 View Notifications</button>
            <button class="toggle-btn" onclick="toggleVisibility('upcoming-appointments')">📅 View Upcoming Appointments</button>
            <button class="toggle-btn" onclick="toggleVisibility('recent-activity')">📌 View Recent Activity</button>
            
            <!-- Profile Section -->
            <section id="profile">
                <h2>Profile</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($fname . ' ' . $lname); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            </section>
              
        
            <!-- Notifications -->
            <div id="notifications" class="notifications hidden">
                <h3>🔔 Notifications</h3>
                <p>No new notifications.</p>
            </div>

            <!-- Upcoming Appointments -->
            <div id="upcoming-appointments" class="upcoming-appointments hidden">
            <h3>📅 Upcoming Appointments</h3>
            <?php
                $stmt = $conn->prepare("SELECT doctor_name, department, appointment_time, appointment_date FROM appointments WHERE patient_id = ? AND appointment_date >= CURDATE()");
                $stmt->bind_param("i", $patient_id);                
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<p><strong>Doctor:</strong> Dr. " . htmlspecialchars($row['doctor_name']) . "<br>";
                        echo "<strong>Specialty:</strong> " . htmlspecialchars($row['department']) . "<br>";
                        echo "<strong>Date:</strong> " . htmlspecialchars($row['appointment_date']) . "<br>";
                        echo "<strong>Time:</strong> " . htmlspecialchars($row['appointment_time']) . "</p><hr>";
                    }
                } else {
                    echo "<p>No upcoming appointments.</p>";
                }
                $stmt->close();
            ?>
        </div>


            <!-- Recent Activity -->
            <div id="recent-activity" class="recent-activity hidden">
                <h3>📌 Recent Activity</h3>
                <ul>
                    <li>Booked an appointment with Dr. Smith on March 18, 2025.</li>
                    <li>Updated profile information on March 17, 2025.</li>
                    <li>Checked appointment history on March 16, 2025.</li>
                </ul>
            </div>
        </section>

        <!-- Book Appointment Section -->
        <section id="book-appointment">
            <h2>Book an Appointment</h2>
            <form method="POST" action="book_appointment.php">
                <label for="department">Department:</label>
                <select id="department" name="department" onchange="updateDoctors()" required>
                    <option value="" disabled selected>Select a specialty</option>
                    <option value="General Physician">General Physician</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Dentist">Dentist</option>
                    <option value="Neurologist">Neurologist</option>
                </select>

                <label for="doctor">Doctor:</label>
                <select id="doctor" name="doctor" required>
                    <option value="" disabled selected>Select Doctor</option>
                    <!-- Doctors will be populated based on department selection -->
                </select>

                <label for="date">Date:</label>
                <input type="text" id="date" name="date" required>

                <label for="time">Time:</label>
                <select id="time" name="time" required>
                    <option value="07:00">07:00 AM</option>
                    <option value="08:00">08:00 AM</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="13:00">01:00 PM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:00">04:00 PM</option>
                    <option value="17:00">05:00 PM</option>
                    <option value="18:00">06:00 PM</option>
                </select>

                <button type="submit">Book Now</button>
            </form>
        </section>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function toggleVisibility(id) {
            var section = document.getElementById(id);
            section.classList.toggle("hidden");
        }

        function updateDoctors() {
            var department = document.getElementById("department").value;
            var doctorSelect = document.getElementById("doctor");

            fetch("get_doctors.php?specialty=" + encodeURIComponent(department))
                .then(response => response.json())
                .then(data => {
                    doctorSelect.innerHTML = "";
                    data.forEach(doctor => {
                        var option = document.createElement("option");
                        option.value = doctor;
                        option.textContent = doctor;
                        doctorSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Error fetching doctors:", error);
                });
        }

        flatpickr("#date", {
            minDate: "today",
            dateFormat: "Y-m-d",
        });

        document.getElementById("logout-link").addEventListener("click", function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "patient_logout.php";
            }
        });

        document.getElementById("doctor").addEventListener("change", updateAvailableTimes);
        document.getElementById("date").addEventListener("change", updateAvailableTimes);

        function updateAvailableTimes() {
            const doctor = document.getElementById("doctor").value;
            const date = document.getElementById("date").value;

            if (!doctor || !date) return;

            fetch(`get_booked_times.php?doctor=${encodeURIComponent(doctor)}&date=${encodeURIComponent(date)}`)
                .then(response => response.json())
                .then(bookedTimes => {
                    const timeSelect = document.getElementById("time");
                    Array.from(timeSelect.options).forEach(option => {
                        if (bookedTimes.includes(option.value)) {
                            option.disabled = true;
                            option.style.color = "gray";
                        } else {
                            option.disabled = false;
                            option.style.color = "black";
                        }
                    });
                })
                .catch(error => {
                    console.error("Error fetching times:", error);
                });
        }

    </script>

</body>
</html>

