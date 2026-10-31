<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include("connection.php");

if (isset($_GET["nim"])) {
    $nim = mysqli_real_escape_string($connection, $_GET["nim"]);

    // Ambil data nama mahasiswa terlebih dahulu
    $check_query = "SELECT name FROM student WHERE nim='$nim'";
    $check_result = mysqli_query($connection, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $student_data = mysqli_fetch_assoc($check_result);
        $name = $student_data["name"];

        // Hapus data mahasiswa
        $delete_query = "DELETE FROM student WHERE nim='$nim'";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $message = "Mahasiswa dengan nama \"<b>$name</b>\" (NIM: $nim) berhasil dihapus.";
            header("Location: student_view.php?message=" . urlencode($message));
            exit();
        } else {
            die("Query gagal dijalankan: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
        }
    } else {
        header("Location: student_view.php");
        exit();
    }
} else {
    header("Location: student_view.php");
    exit();
}
?>
