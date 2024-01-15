<?php require APPROOT . '/views/includes/head.php';

    echo "<div id='section-landing'>
    <div class='navbar'>";

    if(isset($_SESSION['class']) && $_SESSION['class'] == ADMIN){
        require APPROOT . '/views/includes/adminNavigation.php';
        echo "</div>
            <div class='wrapper-landing'>
                <h1>Admin Panel</h1>
            </div>";
    }
    if(isset($_SESSION['class']) && $_SESSION['class'] == STUDENT){
        require APPROOT . '/views/includes/studentNavigation.php';
        echo "</div>
                <div class='wrapper-landing'>
                    <h1>Student Panel</h1>
                </div>
            </div>";
    }
require APPROOT . '/views/includes/footer.php';