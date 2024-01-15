<!-- STUDENT LIST PAGE -->
<?php require APPROOT . '/views/includes/head.php';?>

<div id="section-landing">
    <div class="navbar">
        <?php require APPROOT . '/views/includes/adminNavigation.php';?>
    </div>
    <div class="wrapper-landing">
    </div>
    <div>
        <table class= "list-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Loops through the array of objects and prints out their properties on the table
                foreach ($data as $student){
                    if(is_object($student)){
                        echo "<tr>
                                <td>" .$student->id. "</td>
                                <td>" .$student->username. "</td>
                                <td>" .$student->email."</td>
                                <td>".
                                    "<form action = ". URLROOT . "/adminpanel/removeUser method='POST'>".
                                            "<button type='submit' name='delete' class='btn-link' value=" .$student->id. "> DELETE </button>"
                                    ."</form>"
                                ."</td>
                            </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php';?>