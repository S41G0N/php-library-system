<?php require APPROOT . '/views/includes/head.php';?>

<div id="section-landing">
<div class="navbar">
    <?php require APPROOT . '/views/includes/adminNavigation.php';?>
</div>

<div class="container-login">
    <div class="wrapper-login">
        <h2>Edit book</h2>
            <form id="register-form" method="POST" action="<?php echo URLROOT; ?>/adminpanel/editBook">

            <input type="text" placeholder="Book Title *" name="bookTitle">
            <input type="text" placeholder="Book Author *" name="bookAuthor">
            <input type="text" placeholder="Publish Date *" name="publishDate">
            <input type="hidden" name="bookID" value="<?php echo $data['bookID'];?>">
            
            <span class="invalidFeedback">
                <?php echo $data['Error']; ?>
            </span>

            <p class="options">Changed your mind? <a href="<?php echo URLROOT; ?>/adminpanel/books">Go back!</a></p>
            <button id="submit" type="submit" value="submit">Submit</button>
        </form>
    </div>
</div>
</div>
<?php require APPROOT . '/views/includes/footer.php';?>