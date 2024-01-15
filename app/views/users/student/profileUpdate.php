<?php require APPROOT . '/views/includes/head.php';?>

<div id="section-landing">
<div class="navbar">
    <?php require APPROOT . '/views/includes/studentNavigation.php';?>
</div>

<div class="container-login">
    <div class="wrapper-login">
        <h2>Update Profile</h2>

        <form action="<?php echo URLROOT; ?>/studentpanel/profileUpdate" method ="POST">
        
            <input type="password" placeholder="Current Password *" name="currentPassword">
            <span class="invalidFeedback">
                <?php echo $data['incorrectPassword']; ?>
            </span>
            <input type="text" placeholder="New Username (optional)" name="username">
            <input type="email" placeholder="New E-mail (optional)" name="email">
            <input type="password" placeholder="New Password (optional)" name="password">
            <span class="invalidFeedback">
                <?php echo $data['Error']; ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>

            <p class="options"><a href="<?php echo URLROOT; ?>/studentpanel/student">Back.</a></p>
        </form>
    </div>
</div>
</div>
