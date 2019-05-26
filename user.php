<?php
    include 'crud.php';
    include_once 'DBConnector.php';
    include "authenticator.php";

    class User implements crud{

        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;

        private $username;
        private $password;
		private $utc_timestamp;
		private $offset;

        /*We can use this class constructor to initializ our values
        members variables cannot be instantiated from elsewhere; They private */

        function __construct($first_name = "",$last_name ="",$city_name="", $username="",$password="", $utc_timestamp="", $offset=""){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;

            $this->username = $username;
            $this->password = $password;
			//$this->utc_timestamp = $utc_timestamp;
			//$this->offset = $offset;
        }

        public static function create(){
            $instance = new self();
            return $instance;
        }
        //username setter
        public function setUsername($username){
            $this->username = $username;
        }

        //username getter
        public function getUsername(){
            return $this->username;
        }

        //password setter
        public function setPassword($password){
            $this->password = $password;
        }

        //password getter
        public function getPassword(){
            return $this->password;
        }
        //user_id setter
        public function setUserId($user_id){
            $this->user_id = $user_id;
        }

        //user_id Getter
        public function getUserId(){
            return $this->user_id;
        }
		
	/*	public function getUtcTime(){
			return $this->utc_timestamp;
			}
		public function setUTCTime($utc_timestamp){
			return $this->utc_timestamp = $utc_timestamp;
			}
		public function getOffset(){
			return $this->offset;
			}
		public function setOffset($offset){
			return $this->offset = $offset;
			} */
        /*Because we implemented the 'Crud' interface, we have
        to define all the methods, otherwise we will run into an error */

        public function save(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $uname = $this->username;
            $this->hashPassword();
            $pass = $this->password;
			//$utc = $this->utc_timestamp;
			//$offset = $this->offset;
            $con = new DBConnector;//Database connection is made

            $check = "SELECT * FROM user WHERE username='$uname'";
             $res = mysqli_query($con->conn, $check);

              if (mysqli_num_rows($res) > 0) {
             echo "username exists "; 

         }else{
            $res = mysqli_query($con->conn,"INSERT INTO user (first_name,last_name,user_city,username,password) VALUES('$fn','$ln','$city','$uname', '$pass')") or die("Error!". mysqli_error());

            return $res;
        }}
        public function hashPassword(){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        public function isPasswordCorrect(){
            $con = new DBConnector;
            $found = false;
            $username = $this->getUsername();
            $res = mysqli_query($con->conn,"SELECT * FROM user WHERE username = '$username'") or die ("Error" . mysqli_error());
            while($row = mysqli_fetch_array($res)){
                if (password_verify($this->getPassword(),$row['password']) && $this->getUsername() == $row['username'] )
                 {
                    $found = true;
                }
            }
            $con->closeDatabase();
            return $found;
        }

        public function login(){
            if ($this->isPasswordCorrect()) {
                header("location:private_page.php");
                # code...
            }  
        }
        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
        }
        public function logout(){
            session_start();
            unset($_SESSION['username']);
            session_destroy();
            header("location: lab1.php");
        }

        public function readAll(){
            $con = new DBConnector;//Database connection is made
            $read =  mysqli_query($con->conn, "SELECT * FROM user") or die("Error:".mysqli_error());
            if($read)
            {
               // echo "Success";
                //echo mysqli_error($con->conn);
            }
            return $read;

        }
        public function readUnique(){
            return null;
        }
        public function search(){
            return null;
        }
        public function update(){
            return null;
        }
        public function removeOne(){
            return null;
        }
        public function removeAll(){
            return null;
        }

        public function valiteForm(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $uname = $this->username;
            $pass = $this->password;

            if($fn == "" || $ln == "" || $city == "" || $uname=="" || $pass==""){
                return false;
            }
            return true;

        }

        public function createFormErrorSessions(){
            session_start();
            $_SESSION['form_errors'] = "All fields are required";
        }
    }

?>