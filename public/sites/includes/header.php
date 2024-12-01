<div class="header">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login_page.php">Login</a>
        <a href="register_page.php">Register</a>
    <?php endif; ?>
    
    <a href="booking_page.php">Booking</a>
    
    <?php if (is_admin()): ?>
        <a href="room_admin.php">Admin Functions</a>
    <?php endif; ?>
</div>
