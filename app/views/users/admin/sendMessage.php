<?php require APPROOT . '/views/includes/head.php';?>

<div id="section-landing">
    <div class="navbar">
        <?php require APPROOT . '/views/includes/adminNavigation.php';?>
    </div>

    <div class="container-login">
        <div class="wrapper-login">
            <h2>Send a message</h2>

            <form action="<?php echo URLROOT; ?>/adminpanel/sendMessage" method ="POST" >
                <!-- <input type="text" placeholder="Message *" name="message" style="width: 500px; height: 100px"> -->
                <textarea name="message" id="" cols="30" rows="10" style="font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif;"></textarea>
                
                <span class="invalidFeedback">
                    <?php echo $data['Error']; ?>
                </span>
                <input type="hidden" name="id" value="<?php echo $data['student_id']; ?>">
                <button id="submit" type="submit" value="submit">Submit</button>

                <p class="options"> <a href="<?php echo URLROOT; ?>/adminpanel/orders"> Go back.</a></p>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php';?>