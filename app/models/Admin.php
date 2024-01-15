<?php
class Admin {
    private $db;
    public function __construct() {
        $this->db = new Database;
    }

    // Returns an array of objects of registered students
    public function returnStudents () {
        
        $this->db->query('SELECT id, username, email FROM students');
        $result = $this->db->resultSet();

        return $result;
    }

    // Removes a user based on the ID
    public function removeUser ($userID) {

        $this->db->query('DELETE FROM students WHERE id = :id');
        $this->db->bind(':id', $userID);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        };
    }

    // Inserts a book into the database/ the credentials are passed by the Controller.php
    public function bookRegister($data){

        $this->db->query('INSERT INTO book (book_title, book_author, publish_date) VALUES(:title, :author, :published)');

        //Bind values
        $this->db->bind(':title', $data['bookTitle']);
        $this->db->bind(':author', $data['bookAuthor']);
        $this->db->bind(':published', $data['publishDate']);

        //Executes the query/statement
        if ($this->db->execute()) {
            $this->db->query('SELECT expenses FROM chart WHERE year = :currentYear');
            $this->db->bind(':currentYear', date('Y'));
            $result = $this->db->single();

            $newsum = $result->expenses + $data['bookCost'];

            $this->db->query('UPDATE chart SET expenses = :cost WHERE year = :currentYear');
            $this->db->bind(':cost', $newsum);
            $this->db->bind(':currentYear', date('Y'));
            if($this->db->execute()){
                self::updateProfits();
                return true;
            }
        }
        return false;
    }

    // Edits book credentials
    public function bookEdit($data){
        
        $success = 0;
        
        if (!empty($data['bookAuthor'])){
            $this->db->query('UPDATE book SET book_author = :author WHERE book_id = :id');
            $this->db->bind(':author', $data['bookAuthor']);
            $this->db->bind(':id', $data['bookID']);
            $this->db->execute();
            $success++;
        }

        elseif (!empty($data['bookTitle'])){
            $this->db->query('UPDATE book SET book_title = :title WHERE book_id = :id');
            $this->db->bind(':title', $data['bookTitle']);
            $this->db->bind(':id', $data['bookID']);
            $this->db->execute();
            $success++;
        }
        elseif (!empty($data['publishDate'])){
            $this->db->query('UPDATE book SET publish_date = :published WHERE book_id = :id');
            $this->db->bind(':published', $data['publishDate']);
            $this->db->bind(':id', $data['bookID']);
            $this->db->execute();
            $success++;
        }
        if ($success > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Removes a user based on the ID
    public function bookRemove ($bookID) {

        $this->db->query('DELETE FROM book WHERE book_id = :book_id');
        $this->db->bind(':book_id', $bookID);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        };
    }

    // Deletes the order based on the order ID
    public function deleteOrder($data){
        $this->db->query('SELECT book_id FROM orders WHERE id = :orderID');
        $this->db->bind(':orderID', $data['orderID']);
        $bookID = $this->db->single()->book_id;
        if(isset($bookID)){
            self::switchStock($bookID);
            
            $this->db->query('DELETE FROM orders WHERE id = :orderID');
            $this->db->bind(':orderID', $data['orderID']);
            if($this->db->execute()){

                $this->db->query('SELECT sales FROM chart WHERE year = :currentYear');
                $this->db->bind(':currentYear', date('Y'));
                $result = $this->db->single();

                $newsum = $result->sales + 25;

                $this->db->query('UPDATE chart SET sales = :sales WHERE year = :currentYear');
                $this->db->bind(':sales', $newsum);
                $this->db->bind(':currentYear', date('Y'));
                if($this->db->execute()){
                    self::updateProfits();
                    return true;
                }
            }
        }
        return false;
    }
    // Makes the book avaliable/unavailable
    public function switchStock($bookID){
        
        $this->db->query('SELECT in_stock FROM book WHERE book_id = :id');
        $this->db->bind(':id', $bookID);
        $book_taken = $this->db->single()->in_stock;

        if($book_taken == 1){
            $this->db->query('UPDATE book SET in_stock = 0 WHERE book_id = :id');
            $this->db->bind(':id', $bookID);
            $this->db->execute();
            return true;
        }
        elseif($book_taken == 0){
            $this->db->query('UPDATE book SET in_stock = 1 WHERE book_id = :id');
            $this->db->bind(':id', $bookID);
            $this->db->execute();
            return true;
        }
        return false;
    }

    public function extractChartData(){
        $this->db->query('SELECT * FROM chart');
        $data = $this->db->resultSet();
        return $data;
    }

    public function updateProfits(){

        $this->db->query('SELECT sales FROM chart WHERE year = :currentYear');
        $this->db->bind(':currentYear', date('Y'));
        $sales = $this->db->single();
        $totalSales = $sales->sales;

        $this->db->query('SELECT expenses FROM chart WHERE year = :currentYear');
        $this->db->bind(':currentYear', date('Y'));
        $expenses = $this->db->single();
        $totalExpenses = $expenses->expenses;

        $updatedProfit = $totalSales-$totalExpenses;

        $this->db->query('UPDATE chart SET profit = :profit WHERE year = :currentYear');
        $this->db->bind(':profit', $updatedProfit);
        $this->db->bind(':currentYear', date('Y'));

        if($this->db->execute()){
        return true;
        }
    }

    public function extendOrder($data){
        if(!isset($data['newDate'])){
            $this->db->query('DELETE FROM notifications WHERE id = :id');
            $this->db->bind(':id', $data['notificationID']);
            $this->db->execute();
            return true;
        }
        $this->db->query('SELECT order_id FROM notifications WHERE id = :id');
        $this->db->bind(':id', $data['notificationID']);
        $orderID = $this->db->single()->order_id;

        $this->db->query('DELETE FROM notifications WHERE id = :id');
        $this->db->bind(':id', $data['notificationID']);
        $this->db->execute();

        $this->db->query('UPDATE orders SET due_date = :newDate WHERE id = :id');
        $this->db->bind(':newDate', $data['newDate']);
        $this->db->bind(':id', $orderID);
        
        if($this->db->execute()){
            return true;
        }
        return false;
    }
}