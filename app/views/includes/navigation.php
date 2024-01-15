<!-- NAVIGATION MENU -->
<nav class="top-nav">
    <ul>
        <!-- Switches the admin panel/ student panel /register page based on who is logged in -->
        <li> <?php if (isset($_SESSION['class']) && $_SESSION['class'] == ADMIN) : ?>
                <a href="<?php echo URLROOT; ?>/adminpanel/admin">Admin panel</a>

            <?php elseif (isset($_SESSION['class']) && $_SESSION['class'] != ADMIN) : ?>
                <a href="<?php echo URLROOT; ?>/studentpanel/student">Student panel</a>

            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/users/register">Register</a>

            <?php endif; ?>
        </li>

        <li><a href="<?php echo URLROOT; ?>/pages/about">About us</a></li>
        <li><a href="<?php echo URLROOT; ?>/pages/contact">Contact us</a></li>
        <li><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
        

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
