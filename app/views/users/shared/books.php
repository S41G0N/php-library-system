<!-- STUDENT LIST PAGE -->
<?php

    require APPROOT . '/views/includes/head.php';

    if(isset($_SESSION['class']) && $_SESSION['class'] == STUDENT){
    echo '<div id="section-landing">
    <div class="navbar">';
        require APPROOT . '/views/includes/studentNavigation.php';
    echo '
    </div>
    <div>
        <table class= "list-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publish Date</th>
                    <th>In Stock</th>
                    <th>Borrow</th>
                </tr>
            </thead>
            <tbody>';
                // Loops through the array of objects and prints out their properties on the table
                foreach ($data as $book){
                    if(is_object($book)){
                        echo "<tr>
                                <td>" .$book->book_id. "</td>
                                <td>" .$book->book_title. "</td>
                                <td>" .$book->book_author."</td>
                                <td>" .$book->publish_date."</td>";
                                
                                if($book->in_stock == 1){
                                    echo "<td> Yes </td>";
                                } else {
                                    echo "<td> No </td>";
                                }  
                        echo
                            "<td>".
                                    "<form action = ". URLROOT . "/studentpanel/books method='POST'>".
                                            "<button type='submit' name='borrow' class='btn-link' value=" .$book->book_id. "> BORROW </button>"
                                    ."</form>".
                            "</td></tr>";
                    }
                }
    }

    if(isset($_SESSION['class']) && $_SESSION['class'] == ADMIN){
        echo '<div id="section-landing">
                <div class="navbar">';
            require APPROOT . '/views/includes/adminNavigation.php';

        echo '</div>
            <div>
            <table class= "list-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publish Date</th>
                    <th>In Stock</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>';
                // Loops through the array of objects and prints out their properties on the table
            foreach ($data as $book){
                if(is_object($book)){
                    echo "<tr>
                            <td>" .$book->book_id. "</td>
                            <td>" .$book->book_title. "</td>
                            <td>" .$book->book_author."</td>
                            <td>" .$book->publish_date."</td>";
                                
                            if($book->in_stock == 1){
                                echo "<td> Yes </td>";
                            } else {
                                echo "<td> No </td>";
                            }  
                    echo
                        "<td>".
                            "<form action = ". URLROOT . "/adminpanel/editBook method='POST'>".
                                    "<button type='submit' name='edit' class='btn-link' value=" .$book->book_id. "> EDIT </button>"
                            ."</form>".
                        "</td>
                        <td>".
                            "<form action = ". URLROOT . "/adminpanel/removeBook method='POST'>".
                                    "<button type='submit' name='delete' class='btn-link' value=" .    $book->book_id. "> DELETE </button>".
                            "</form>".
                        "</td>
                        </tr>";
            }
        }
    }
    echo '</tbody>
        </table>
        <p class = "options">' . $data['Error'] .  '</p>
    </div>
</div>';
    require APPROOT . '/views/includes/footer.php';