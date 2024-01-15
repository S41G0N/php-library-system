<!-- ADMIN NAVIGATION MENU -->
<nav class="top-nav">
    <ul>
    
        <li><a href="<?php echo URLROOT; ?>/pages/index">Back</a></li>
        <li><a href="<?php echo URLROOT; ?>/adminpanel/students">Students</a></li>
        <li><a href="<?php echo URLROOT; ?>/adminpanel/orders">Orders</a></li>
        <li><a href="<?php echo URLROOT; ?>/adminpanel/books">Books</a></li>
        <li><a href="<?php echo URLROOT; ?>/adminpanel/addBook">Add a book</a></li>
        <li><a href="<?php echo URLROOT; ?>/adminpanel/chart">Charts</a></li>
        <li><a href="<?php echo URLROOT; ?>/adminpanel/notifications">Inbox</a></li>
        

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