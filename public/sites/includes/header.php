<div class="header">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="../index.php">Login</a>
        <a href="register_page.php">Register</a>
    <?php endif; ?>
    
    <a href="booking_page.php">Booking</a>
    
    <?php if (is_admin()): ?>
        <a href="<?php echo BASE_PATH .  "private/admin/room_admin.php"; ?>">Admin Functions</a>
    <?php endif; ?>
</div>
