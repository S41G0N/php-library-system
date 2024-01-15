<!-- STUDENT NAVIGATION MENU -->
<nav class="top-nav">
    <ul>
    
        <li><a href="<?php echo URLROOT; ?>/pages/index">Back</a></li>
        <li><a href="<?php echo URLROOT; ?>/studentpanel/books">Books</a></li>
        <li><a href="<?php echo URLROOT; ?>/studentpanel/orders">Your orders</a></li>
        <li><a href="<?php echo URLROOT; ?>/studentpanel/profileUpdate">Update Profile</a></li>
        <li><a href="<?php echo URLROOT; ?>/studentpanel/notifications">Inbox</a></li>
        

        <!-- Switches the logged in/out button depending on the session existence -->
        <li class="btn-login"><?php if(isset($_SESSION['user_id'])) : ?>
                <a href="<?php echo URLROOT; ?>/users/logout">Log out</a>
            <?php else : ?>
                <!-- users = Users.php, login = login() -->
                <a href="<?php echo URLROOT; ?>/users/login">Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>