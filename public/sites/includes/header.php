
<link rel="stylesheet" href="/IS115Motell/public/sites/css/main.css">

<div class="header">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/IS115Motell/public/sites/logout.php">Logout</a>
    <?php else: ?>
        <a href="/IS115Motell/public/index.php">Login</a>
        <a href="/IS115Motell/public/sites/register_page.php">Register</a>
    <?php endif; ?>
    
    <a href="/IS115Motell/public/sites/booking_page.php">Booking</a>
    
    <?php if (is_admin()): ?>
        <a href="/IS115Motell/private/admin/room_admin.php">Admin Functions</a>
    <?php endif; ?>
</div>
