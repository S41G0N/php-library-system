<?php require APPROOT . '/views/includes/head.php';?>

<div id="section-landing">
<div class="navbar">
    <?php require APPROOT . '/views/includes/adminNavigation.php';?>
</div>

<div class="container-login">
    <div class="wrapper-login">
        <h2>Add a book</h2>
            <form id="register-form" method="POST" action="<?php echo URLROOT; ?>/adminpanel/addBook">

            <input type="text" placeholder="Book Title *" name="bookTitle">
            <span class="invalidFeedback">
                <?php echo $data['titleError']; ?>
            </span>

            <input type="text" placeholder="Book Author *" name="bookAuthor">
            <span class="invalidFeedback">
                <?php echo $data['authorError']; ?>
            </span>

            <input type="text" placeholder="Publish Date *" name="publishDate">
            <span class="invalidFeedback">
                <?php echo $data['dateError']; ?>
            </span>

            <input type="text" placeholder="Cost *" name="bookCost">
            <span class="invalidFeedback">
                <?php echo $data['costError']; ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>
        </form>
    </div>
</div>
</div>
<?php require APPROOT . '/views/includes/footer.php';?>