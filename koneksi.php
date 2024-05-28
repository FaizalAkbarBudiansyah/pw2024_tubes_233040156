<?php

$conn = mysqli_connect("localhost", "root", "", "pw2024_tubes_b_233040156");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
