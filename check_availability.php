<?php
require_once("includes/config.php");

if (!empty($_POST["emailid"])) {
    $email = $_POST["emailid"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span style='color:red'>Invalid email format.</span>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    } else {
        // Check email availability
        $sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo "<span style='color:red'>Email already exists.</span>";
            echo "<script>$('#submit').prop('disabled', true);</script>";
        } else {
            echo "<span style='color:green'>Email available for registration.</span>";
            echo "<script>$('#submit').prop('disabled', false);</script>";
        }
    }
}
?>
