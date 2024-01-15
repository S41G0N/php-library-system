<!-- ORDER LIST STUDENT PAGE -->
<?php require APPROOT . '/views/includes/head.php';

    echo '<div id="section-landing">
    <div class="navbar">';
    if(isset($_SESSION['class']) && $_SESSION['class'] == STUDENT){
        require APPROOT . '/views/includes/studentNavigation.php';
        echo '</div>
    <div class="wrapper-landing">
    </div>
    <div>
        <table class= "list-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Book title</th>
                    <th>Due Date</th>
                    <th>Extend due date</th>
                </tr>
            </thead>
            <tbody>';
                // Loops through the array of objects and prints out their properties on the table
                foreach ($data as $order){
                    if(is_object($order)){
                        echo "<tr>
                                <td>" .$order->id. "</td>
                                <td>" .$order->title. "</td>";
                        if(!isset($order->due_date)){
                            echo "<td> No Due Date </td>";
                        } else {
                            echo "<td>" .$order->due_date. "</td>";
                        }
                        echo
                            "<td>
                                <form action = ".URLROOT."/studentpanel/dateExtension method='POST'>
                                    <button type='submit' name='extension' class='btn-link' value=".$order->id."> Extend </button>
                                </form>
                            </td>
                        </tr>";
                    }
                }
            }
    if(isset($_SESSION['class']) && $_SESSION['class'] == ADMIN){
        require APPROOT . '/views/includes/adminNavigation.php';
    echo '</div>
    <div class="wrapper-landing">
    </div>
    <div>
        <table class= "list-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Book title</th>
                    <th>Student</th>
                    <th>E-mail</th>
                    <th>Return</th>
                    <th>Return date</th>
                    <th>Send a message</th>
                </tr>
            </thead>
            <tbody>';
                // Loops through the array of objects and prints out their properties on the table
                foreach ($data as $order){
                    if(is_object($order)){
                        echo "<tr>
                                <td>" .$order->id. "</td>
                                <td>" .$order->title. "</td>
                                <td>" .$order->username. "</td>
                                <td>" .$order->email. "</td>
                                <td>
                                    <form action = " . URLROOT . "/adminpanel/orders method='POST'>
                                            <button type='submit' name='return' class='btn-link' value=" . $order->id . "> Returned </button>
                                    </form>
                                </td>
                                <td>" . $order->due_date . "</td>
                                <td>
                                    <form action = " . URLROOT . "/adminpanel/sendMessage method='POST'>
                                            <button type='submit' name='student_id' class='btn-link' value=" . $order->student_id . "> Notify </button>
                                    </form>
                                </td>
                            </tr>";
                    }
                }
            }
             echo'   
            </tbody>
        </table>
        <p class = "options">' . $data['Error'] . '</p>
    </div>
</div>';
require APPROOT . '/views/includes/footer.php';