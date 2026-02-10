<?php
$conn = mysqli_connect("localhost", "root", "", "college");

if (!$conn) {
    die("Database connection failed");
}
