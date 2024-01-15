<!-- ORDER LIST ADMIN PAGE -->
<?php require APPROOT . '/views/includes/head.php';

echo "<div id='section-landing'>
    <div class='navbar'>";

    if(isset($_SESSION['class']) && $_SESSION['class'] == STUDENT)
    {
        require APPROOT . '/views/includes/studentNavigation.php';
    echo "</div>
    <div class='wrapper-landing'>
    </div>
    <div>
        <table class= 'list-table'>
            <thead>
                <tr>
                    <th>From</th>
                    <th>Text</th>
                    <th>When</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>";
                // Loops through the array of objects and prints out their properties on the table
                foreach ($data as $notification){
                    if(is_object($notification)){
                        echo "<tr>
                                <td> Admin </td>
                                <td>" .$notification->text. "</td>
                                <td>" .$notification->date. "</td>
                                <td>
                                    <form action = " . URLROOT . "/studentpanel/notifications method='POST'>
                                            <button type='submit' name='removeNotification' class='btn-link' value=" . $notification->id . "> Remove </button>
                                    </form>
                                </td>
                            </tr>";
            }
        }
    }
    if(isset($_SESSION['class']) && $_SESSION['class'] == ADMIN){
        require APPROOT . '/views/includes/adminNavigation.php';
    echo "</div>
    <div class='wrapper-landing'>
    </div>
    <div>
        <table class= 'list-table'>
            <thead>
                <tr>
                    <th>Notification</th>
                    <th>Extended Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";
                // Loops through the array of objects and prints out their properties on the table
                foreach ($data as $notification){
                    if(is_object($notification)){
                        echo "<tr>
                                <td>" .$notification->text. "</td>
                                <td>" .$notification->date. "</td>
                                <td>
                                    <form action = " . URLROOT . "/adminpanel/offers method='POST'>
                                            <input type= 'hidden' name = 'confirmOfferDate' value= ".$notification->date.">
                                            <input type= 'hidden' name = 'confirmOfferID' value= ".$notification->id.">
                                            <button type='submit' name='confirm' value='submit' class='btn-link'> Confirm </button>
                                    </form>
                                    <form action = " . URLROOT . "/adminpanel/offers method='POST'>
                                            <button type='submit' name='removeOffer' class='btn-link' value=" . $notification->id . "> Refuse </button>
                                    </form>
                                </td>
                            </tr>";
                    }
        }
    }
            echo"
            </tbody>
        </table>
    </div>
</div>";
require APPROOT . '/views/includes/footer.php';

