<?php
include('crssession.php');
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 2) {
    header('Location: login.php'); 
    exit();
}

include 'headerstudent.php'; 
include 'db_connect.php';

$uic = $_SESSION['funame'];

// Retrieve student profile details
$sql = "SELECT * FROM tb_user WHERE u_sno = '$uic'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

// Check if user exists
if (!$row) {
    $_SESSION['message'] = "Student not found!";
    header('Location: courseview.php'); // Redirect if student is not found
    exit;
}
?>

<div class="container">
    <br><br>
    <h5>Profile</h5>
    <br>
    <!-- Display any message from session -->
    <?php if (isset($_SESSION['message'])): ?>
        <script type="text/javascript">
            alert("<?php echo $_SESSION['message']; ?>");
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form method="POST" action="studenteditprofileupdate.php" onsubmit="return confirmUpdate()">
        <div class="form-group">
            <label>Student Name:</label>
            <input type="text" class="form-control" name="u_name" value="<?php echo $row['u_name']; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Student ID:</label>
            <input type="text" class="form-control" name="u_sno" value="<?php echo $row['u_sno']; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="u_email" value="<?php echo $row['u_email']; ?>" required>
        </div>
        <br>
        <div class="form-group">
            <label>Contact Number:</label>
            <input type="text" class="form-control" name="u_contact" value="<?php echo $row['u_contact']; ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label mt-4">Select your state</label>
            <select class="form-select" name="fstate">
                <option <?php if ($row['u_state'] == 'Johor') echo 'selected'; ?>>Johor</option>
                <option <?php if ($row['u_state'] == 'Kedah') echo 'selected'; ?>>Kedah</option>
                <option <?php if ($row['u_state'] == 'Kelantan') echo 'selected'; ?>>Kelantan</option>
                <option <?php if ($row['u_state'] == 'Melaka') echo 'selected'; ?>>Melaka</option>
                <option <?php if ($row['u_state'] == 'Negeri Sembilan') echo 'selected'; ?>>Negeri Sembilan</option>
                <option <?php if ($row['u_state'] == 'Pahang') echo 'selected'; ?>>Pahang</option>
                <option <?php if ($row['u_state'] == 'Pulau Pinang') echo 'selected'; ?>>Pulau Pinang</option>
                <option <?php if ($row['u_state'] == 'Perak') echo 'selected'; ?>>Perak</option>
                <option <?php if ($row['u_state'] == 'Perlis') echo 'selected'; ?>>Perlis</option>
                <option <?php if ($row['u_state'] == 'Sabah') echo 'selected'; ?>>Sabah</option>
                <option <?php if ($row['u_state'] == 'Sarawak') echo 'selected'; ?>>Sarawak</option>
                <option <?php if ($row['u_state'] == 'Selangor') echo 'selected'; ?>>Selangor</option>
                <option <?php if ($row['u_state'] == 'Terengganu') echo 'selected'; ?>>Terengganu</option>
                <option <?php if ($row['u_state'] == 'W.P. Labuan') echo 'selected'; ?>>W.P. Labuan</option>
                <option <?php if ($row['u_state'] == 'W.P. Kuala Lumpur') echo 'selected'; ?>>W.P. Kuala Lumpur</option>
                <option <?php if ($row['u_state'] == 'W.P. Putrajaya') echo 'selected'; ?>>W.P. Putrajaya</option>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<script>
function confirmUpdate() {
    return confirm("Are you sure you want to update your profile?");
}
</script>

<?php include 'footer.php'; ?>
