<?php
class Student{
    private $db;
    public function __construct() {
        $this->db = new Database;
    }

    // Borrows a book by creating an order and makes the book unavailable
    public function borrowBook($data){

        $this->db->query('INSERT INTO orders (student_id, book_id, due_date) VALUES(:student, :book, :date)');

        $timestamp = strtotime('+1 Month');

        $this->db->bind(':student', $data['userID']);
        $this->db->bind(':book', $data['bookID']);
        $this->db->bind(':date', date('Y-m-d', $timestamp));

        if($this->db->execute()){
            $bookID = $data['bookID'];
            if (self::switchStock($bookID)){
                return true;
            }
        }
        return false;
    }

    // Checks whether a book is in stock by using the book ID
    public function inStockByID($id) {

        $this->db->query('SELECT in_stock FROM book WHERE book_id = :id');
        $this->db->bind(':id', $id);

        $book = $this->db->single()->in_stock;
        
        if($book == 1) {
            return true;
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

    public function removeNotification($data){
            $this->db->query('DELETE FROM notifications WHERE id = :notificationID');
            $this->db->bind(':notificationID', $data);
            if($this->db->execute()){
                return true;
            }
            return false;
    }

    public function updateProfile($data){

            if (!empty($data['newUsername'])){

                $this->db->query('UPDATE students SET username = :newUsername WHERE id = :id');
                $this->db->bind(':newUsername', $data['newUsername']);
                $this->db->bind(':id', $_SESSION['user_id']);
                $this->db->execute();
            }
            
            if(!empty($data['newEmail'])){

                $this->db->query('UPDATE students SET email = :newEmail WHERE id = :id');
                $this->db->bind(':newEmail', $data['newEmail']);
                $this->db->bind(':id', $_SESSION['user_id']);
                $this->db->execute();
            }

            if(!empty($data['newPassword'])){

                $this->db->query('UPDATE students SET password = :newPassword WHERE id = :id');
                $this->db->bind(':newPassword', $data['newPassword']);
                $this->db->bind(':id', $_SESSION['user_id']);
                $this->db->execute();
            }
    }
}