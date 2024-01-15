<?php require APPROOT . '/views/includes/head.php';?>

<div id="section-landing">
<div class="navbar">
    <?php require APPROOT . '/views/includes/studentNavigation.php';?>
</div>

<div class="container-login">
    <div class="wrapper-login">
        <h2>Extend Date</h2>

        <form action="<?php echo URLROOT; ?>/studentpanel/dateExtension" method ="POST">
        
            <input type="date" placeholder="New Date *" name="newDate">
            <input type="hidden" name = "orderID" value="<?php echo $data['orderID'] ?>">
            <input type="hidden" name = "bookID" value="<?php echo $data['bookID'] ?>">
            <span class="invalidFeedback">
                <?php echo $data['Error']; ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>

            <p class="options"><a href="<?php echo URLROOT; ?>/studentpanel/student">Back.</a></p>
        </form>
    </div>
</div>
</div>