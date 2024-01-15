<!-- ADMIN PANEL / ADMIN PAGES -->
<?php
class AdminPanel extends Controller {

    public function __construct() {
        $this->adminModel = $this->model('Admin');
        $this->generalModel = $this->model('General');
    }

    // Overview Page
    public function admin(){
        if($this->generalModel->pass(ADMIN)){
            $data = ['title' => 'Overview'];
            $this->view('users/shared/home', $data);
        } else {
            Redirect::to('index');
        }
    }
    
    // Students page/logic
    public function students(){
        if($this->generalModel->pass(ADMIN)){

            $data = $this->adminModel->returnStudents();
            $data += ['title' => 'Students'];

        } else {
            Redirect::to('index');
        }
        $this->view('users/admin/students',$data);
    }

    // General books overview
    public function books(){
        if($this->generalModel->pass(ADMIN)){

            $data = $this->generalModel->bookReturn();
            $data += ['title' => 'Books'];
            $data += ['Error' => ''];
        }
        $this->view('users/shared/books',$data);
    }

    // Adding books page logic
    public function addBook(){
        if($this->generalModel->pass(ADMIN)){
            $data = [
                'title' => 'Add a book',
                'titleError' => '',
                'authorError' => '',
                'dateError' => '',
                'costError' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                'title' => 'Add a book',
                'bookTitle' => trim($_POST['bookTitle']),
                'bookAuthor' => trim($_POST['bookAuthor']),
                'publishDate' => trim($_POST['publishDate']),
                'bookCost' => trim($_POST['bookCost']),
                'titleError' => '',
                'authorError' => '',
                'dateError' => '',
                'costError' => ''
                ];

            // Swtich?!
                if(empty($data['bookTitle'])){
                    $data['titleError'] = 'The title is empty.';
                }
                if(empty($data['bookAuthor'])){
                    $data['authorError'] = 'The author is empty.';
                }
                if(empty($data['publishDate'])){
                    $data['dateError'] = 'The publish date is empty.';
                } 
                if(empty($data['bookCost'])){
                    $data['costError'] = 'The cost is empty.';
                } 
                if(empty($data['authorError']) && empty($data['titleError']) && empty($data['dateError']) && empty($data['costError'])){
                    if($this->adminModel->bookRegister($data)){
                        Redirect::to('adminpanel/books');
                    } 
                }
            }
            $this->view('users/admin/addBook', $data);
        } else Redirect::to('index');
    }

    // Editing book information 
    public function editBook(){
        if($this->generalModel->pass(ADMIN)) {

            if(isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                'title' => 'Edit a book',
                'bookID' => trim($_POST['edit']),
                'Error' => ''
                ];
                $this->view('users/admin/editBook',$data);

            } elseif (!isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                'title' => 'Edit a book',
                'bookTitle' => trim($_POST['bookTitle']),
                'bookAuthor' => trim($_POST['bookAuthor']),
                'publishDate' => trim($_POST['publishDate']),
                'bookID' => trim($_POST['bookID']),
                'Error' => ''
                ];

                if(empty($data['bookTitle']) && empty($data['bookAuthor']) && empty($data['publishDate'])){
                    $data['Error'] = "Some changes must be made.";
                }
                if(empty($data['Error'])){
                    if($this->adminModel->bookEdit($data)){
                        Redirect::to('adminPanel/books');
                    }
                }
        $this->view('users/admin/editBook',$data);
            }
        }
    }

    // Sending notifications 
    public function sendMessage(){
        if($this->generalModel->pass(ADMIN)) {
            if(isset($_POST['student_id']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'title' => 'Send a message',
                    'student_id' => trim($_POST['student_id']),
                    'Error' => ''
                ];
                $this->view('users/admin/sendMessage',$data);

        } elseif (!isset($_POST['student_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => 'Send a message',
                'text' => trim($_POST['message']),
                'student_id' => trim($_POST['id']),
                'Error' => ''
            ];

            if(empty($data['text']) || empty($data['student_id'])){
                $data['Error'] = "You must type something.";
            }
            if(empty($data['Error'])){
                if($this->generalModel->sendNotification($data)){
                    Redirect::to('adminPanel/orders');
                }
            }
            $this->view('users/admin/sendMessage',$data);
            } 
        } else Redirect::to('index');
    }

    // List of orders
    public function orders(){
        if($this->generalModel->pass(ADMIN)) {
            
            $data = $this->generalModel->returnOrders();
            $data += ['title' => 'Orders','Error' => ''];

                if(isset($_POST['return']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $return = ['orderID' => trim($_POST['return'])];
                    
                    if($this->adminModel->deleteOrder($return)){
                        Redirect::to('adminpanel/orders');
                    }
                }
            $this->view('users/shared/orders', $data);            
        } else Redirect::to('index');
    }

    // General books overview
    public function notifications(){
        if($this->generalModel->pass(ADMIN)){
            $data = $this->generalModel->returnNotifications();
            $data += ['title' => 'Inbox'];
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                Redirect::to('AdminPanel/notifications');
            }
        $this->view('users/shared/notifications',$data);
        } else Redirect::to('index');
    }
    
    public function chart(){
        if($this->generalModel->pass(ADMIN)){
            $chart_data = $this->adminModel->extractChartData();
            $chart_data += ['title' => 'Chart'];
            $this->view('users/admin/chart', $chart_data);
        } else Redirect::to('index');
    }

    public function offers(){
        if($this->generalModel->pass(ADMIN)) {
            if(isset($_POST['confirm']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'newDate' => trim($_POST['confirmOfferDate']),
                    'notificationID' => trim($_POST['confirmOfferID'])
                ];
            
                if($this->adminModel->extendOrder($data)){
                    Redirect::to('adminpanel/notifications');
                }
            }
            if(isset($_POST['removeOffer']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = ['notificationID' => trim($_POST['removeOffer'])];

                if($this->adminModel->extendOrder($data)){
                    Redirect::to('adminpanel/notifications');
                }
            }
        } else Redirect::to('index');
    }

    public function removeUser(){
        if($this->generalModel->pass(ADMIN)){
            if(isset($_POST['delete'])&& $_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $id = trim($_POST['delete']);
                if ($id !== $_SESSION['user_id']) {
                    $this->adminModel->removeUser($id);
                }
                Redirect::to('AdminPanel/students');
            }
        }
        Redirect::to('index');
    }
    
    public function removeBook(){
        if($this->generalModel->pass(ADMIN)){

            if(isset($_POST['delete']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $bookID = trim($_POST['delete']);

                $this->adminModel->bookRemove($bookID);
                Redirect::to('AdminPanel/books');
                }
        }
        Redirect::to('index');
    }
}
