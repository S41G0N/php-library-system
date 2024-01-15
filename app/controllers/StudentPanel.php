<?php
class StudentPanel extends Controller {
    
    public function __construct() {
        $this->studentModel = $this->model('Student');
        $this->generalModel = $this->model('General');
    }

    // Student panel page
    public function student(){
        if($this->generalModel->pass(STUDENT)){
            $data = ['title' => 'Student Panel'];
            $this->view('users/shared/home',$data);
        } else {
            Redirect::to(404);
        }
    }

    // Books page logic + Borrow logic
    public function books(){
        if($this->generalModel->pass(STUDENT)){
            $data = $this->generalModel->bookReturn();
            $data += ['title' => 'Books'];
            $data += ['Error' => ''];

            if (isset($_POST['borrow']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $bookID = trim($_POST['borrow']);
                $userID = $_SESSION['user_id'];

                if(!$this->studentModel->inStockByID($bookID)){
                    $data['Error'] = 'The book is not in stock';
                } else {                    
                    $borrow = ['userID' => $userID, 'bookID' => $bookID];                    
                    if($this->studentModel->borrowBook($borrow)) {
                        Redirect::to('studentpanel/books');
                    }
                }
            }
            $this->view('users/shared/books', $data);
        } else {
            Redirect::to('index');
        }
    }

    // Orders page
    public function orders(){
        if($this->generalModel->pass(STUDENT)){
            $data = $this->generalModel->returnOrders();
            $data += ['title' => 'Your Orders','Error' => ''];
            $this->view('users/shared/orders', $data);
        } else {
            Redirect::to('index');
        }
    }

    public function notifications(){
        if($this->generalModel->pass(STUDENT)){
            $data = $this->generalModel->returnNotifications();
            $data += ['title' => 'Notifications'];
            
            if (isset($_POST['removeNotification']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $notificationID = trim($_POST['removeNotification']);                                 
                if($this->studentModel->removeNotification($notificationID)) {
                    Redirect::to('studentpanel/notifications');
                }
            }
            $this->view('users/shared/notifications', $data);            
        } else {
            Redirect::to('index');
        }
    }

    public function profileUpdate(){
        if($this->generalModel->pass(STUDENT)){
            $data = [
                'title' => 'Profile Update',
                'currentPassword' => '',
                'newUsername' => '',
                'newEmail' => '',
                'newPassword' => '',
                'incorrectPassword' => '',
                'Error' => '',
            ];
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data['currentPassword'] = trim($_POST['currentPassword']);
                if(is_object($this->generalModel->login($_SESSION['email'], $data['currentPassword']))){
                
                    $data['newUsername'] = trim($_POST['username']);
                    $data['newEmail'] = trim($_POST['email']);
                    $data['newPassword'] = trim($_POST['password']);
                
                if((empty($data['newUsername']) && empty($data['newEmail']) && empty($data['newPassword'])) ||   $this->generalModel->findUserByEmail($data['newEmail']) == TRUE){
                    $data['Error'] = 'Some changes must be made.';
                }
                if (empty($data['Error'])){
                    if(!empty($data['newPassword'])){
                        $data['newPassword'] = password_hash($data['newPassword'], PASSWORD_DEFAULT);
                    }
                        $this->studentModel->updateProfile($data);
                        Redirect::to('studentpanel/student');
                }
                } else $data['incorrectPassword'] = 'Incorrect password';
            }
        }
        $this->view('users/student/profileUpdate', $data);
    }

    public function dateExtension(){

        if($this->generalModel->pass(STUDENT)){

            if (isset($_POST['extension']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                'title' => 'Date Extension',
                'newDate' => '',
                'orderID' => trim($_POST['extension']),
                'Error' => ''
                ];
            }
            elseif (!isset($_POST['extension']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                'title' => 'Date Extension',
                'newDate' => trim($_POST['newDate']),
                'orderID' => trim($_POST['orderID']),
                'Error' => ''
                ];

                if(empty($data['newDate'])){
                    $data['Error'] = 'Some changes must be made.';
                }
                if(empty($data['Error'])){
                    if($this->generalModel->sendNotification($data)){
                        Redirect::to('studentpanel/student');
                    }
                }
            }

        } else {
            Redirect::to('index');
        }
            $this->view('users/student/extend', $data);
    }
}

