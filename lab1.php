<?php
        include_once 'user.php';
        $con = new DBConnector;//Database connection is made
        // data isert code starts here
        if(isset($_POST['btn-save'])){
            echo $_FILES['file']['name'];
            echo $_POST['first_name'];

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $city = $_POST['city_name'];

            $username = $_POST['username'];
            $password = $_POST['password'];

            $utc_timestamp = $_POST['utc_timestamp'];
            $offset = $_POST['time_zone_offset'];

            //Creating a users object
            /*Note the way we create our object using constructor that will be used to initializa your variables */
            $user = new User($first_name,$last_name,$city,$username,$password);
            
            if (!$user->valiteForm()) {
                $user->createFormErrorSessions();
                header("Refresh:0");
                die();
                # code...
            }

            require 'fileUploader.php';

            $fileUpload=new FileUploader();
            if(isset($_FILES['file'])){
                $fileUpload->uploadFile($_FILES['file']);
            }
            else{
                die('File was not submitted');
            }

            $res = $user->save();
//            $file_upload_response = $uploader->uploadFile();

            if($res){
                echo "Save successful";
            }
            else{
                echo "an error occured";
            }

        }

    ?>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Title goes here</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="timezone.js"></script>
        <script type="text/javascript">
            function validateForm() {
                var fn = document.forms["user_details"]["first_name"].value;
                var ln = document.forms["user_details"]["last_name"].value;
                var city = document.forms["user_details"]["city_name"].value;

                if (fn == null || ln == "" || city == "") {
                    alert("All details are required");
                    return false
                }
                return true;
            }
        </script>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    </a>
                    <br>
                    <br>
                    <div class="col-sm-6">
                        <tr>
                            <td>
                                <div id="form_errors">
                                    <?php
                    session_start();
                    if (!empty($_SESSION['form_errors'])) {
                        echo "" . $_SESSION['form_errors'];
                        unset($_SESSION['form_errors']);
                        # code...
                    }
                    ?>
                            </td>
                        </tr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                        </div>

                        <div class="col-sm-6">
            

                            <form method="post" enctype="multipart/form-data" id="user_details" name="user_details" onsubmit="return validateForm()" action="<?=$_SERVER['PHP_SELF']?>">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="first_name" required placeholder="First Name">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="city_name" placeholder="City">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>

                                <button name="btn-save" class="btn btn-primary"><strong>SAVE</strong></button>

                                <input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""/>

                                <input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""/>

                                <td><a href="login.php"><strong>LOGIN</strong></a></td>

                            </form>

                        </div>

                        <div class="col-sm-6">
                            <table id="mydatatable" class="table table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>City</th>
                                    <th>Username</th>

                                </thead>
                                <tbody>

                                    <?php
    include_once 'user.php';
    $user1 = new User();
    $result = $user1->readAll();
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc()) {
            echo 
            "

                        <tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["first_name"]. "</td>
                            <td>" . $row["last_name"]. "</td>
                            <td>" . $row["user_city"]. "</td>
                            <td>" . $row["username"]. "</td>

                        </tr>

            ";

        }
    } else {
        echo "0 results";
    }
    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

                <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#mydatatable').DataTable({
                            "autoWidth": false,

                            "pageLength": 5
                        });
                    });
                </script>

    </body>

    </html>