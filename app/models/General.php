<?php

class General{
    private $db;
    public function __construct() {
    $this->db = new Database;
    }

    //Returns a list of notifications
    public function returnNotifications(){
        $this->db->query('SELECT * FROM notifications WHERE student_id = :student_id');
        $this->db->bind(':student_id',$_SESSION['user_id']);
        $result = $this->db->resultSet();
        return $result;
    }

    // Returns a list of registered books
    public function bookReturn () {
        $this->db->query('SELECT book_id, book_title, book_author, publish_date, in_stock FROM book');
        // Add if statement later
        $result = $this->db->resultSet();
        return $result;
    }

    // Returns the orders specific for the users -> admin can see ALL orders
    public function returnOrders(){
        if($_SESSION['class'] == ADMIN){
            $this->db->query('SELECT * FROM orders');
            $result = $this->db->resultSet();

            foreach($result as $order){
                // Selects a book title and inserts it into book_id key
                $this->db->query('SELECT book_title FROM book WHERE book_id = :id');
                $this->db->bind(':id', $order->book_id);
                $book = $this->db->single();

                // Selects a username and inserts it into student_id key
                $this->db->query('SELECT username,email FROM students WHERE id = :id');
                $this->db->bind(':id', $order->student_id);
                $studentObject = $this->db->single();

                $order->title = $book->book_title;
                $order->username = $studentObject->username;
                $order->email = $studentObject->email;
            }
            return $result;
        }

        if($_SESSION['class'] != ADMIN){

            $this->db->query('SELECT * FROM orders WHERE student_id = :student_id');
            $this->db->bind(':student_id',$_SESSION['user_id']);
            $result = $this->db->resultSet();
        
            foreach($result as $order){
                $this->db->query('SELECT book_title FROM book WHERE book_id = :id');
                $this->db->bind(':id', $order->book_id);
                $book = $this->db->single();
                $order->title = $book->book_title;
            }
            return $result;
        }
    }

    public function sendNotification($data){
        if($_SESSION['class'] == ADMIN){
        $this->db->query('INSERT INTO notifications (student_id, text, date) VALUES(:student_id, :text, :date)');
        //Bind values
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':text', $data['text']);
        $this->db->bind(':date', date('Y-m-d'));

        //Executes the query/statement
            if ($this->db->execute()) {
                return true;
            }
        } elseif ($_SESSION['class'] != ADMIN) {

            $this->db->query('SELECT book_id FROM orders WHERE id = :id');
            $this->db->bind(':id', $data['orderID']); // Misleading
            $bookID = $this->db->single()->book_id;

            //return $bookID;

            $this->db->query('SELECT book_title FROM book WHERE book_id = :id');
            $this->db->bind(':id', $bookID);
            $bookTitle = $this->db->single()->book_title;

            $orgDate = $data['newDate'];
            $formatedDate = date('Y-m-d', strtotime($orgDate));

            $this->db->query('INSERT INTO notifications (order_id, student_id, text, date) VALUES(:order_id, :student_id, :text, :date)');

            $text = 'The student "' . $_SESSION['username'] . '" would like to extend the due date of "'
            . $bookTitle . '" to ' . $data['newDate'];

            $this->db->bind(':order_id', $data['orderID']);
            $this->db->bind(':student_id', 10);
            $this->db->bind(':text', $text);
            $this->db->bind(':date', $formatedDate);

            if($this->db->execute()){
                return true;
            }
        }
        return false;
    }

    // Checks whether a user is an admin
    public function pass($validClass){
        if(isset($_SESSION['class']) && ($_SESSION['class']) == $validClass){
            return true;
        } else
        return false;
    }

        // Prepares the statement for the user to be registered into the database
    public function register($data) {
        $this->db->query('INSERT INTO students (username, email, password) VALUES(:username, :email, :password)');

        //Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //Executes the query/statement
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Returns a student from the database if the credentials are correct -> Login
    public function login($email, $password) {
        $this->db->query('SELECT * FROM students WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if (is_object($row)){
        $hashedPassword = $row->password;

            if (password_verify($password, $hashedPassword)) {
                return $row;
            }
        }
        return false;
    }

    //Find user by email. Email is passed in by the Controller.
    public function findUserByEmail($email) {

        $this->db->query('SELECT * FROM students WHERE email = :mail');
        $this->db->bind(':mail', $email);
        
        if(is_object($this->db->single())) {
            return true;
        } 
        return false;
    }
}