<!DOCTYPE html>
<html>
<head>
    <title>iWork</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>
<body>

    <?php

        $serverName = "DESKTOP-N1RE9II\SQLEXPRESS";

        $connectionOptions = array(
            "Database" => "iWork"
        );

        // Establishes the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if($conn) {
            echo "Connected!";
        } else {
            echo "WAH WAH";
        }


        $sql = "SELECT username FROM Users ";
        $stmt = sqlsrv_query( $conn, $sql );

        $users = array();
        
        if( $stmt === false) {
            echo "stmt false";
        }
        else {

            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                  array_push($users, $row['username']);
            }

        }

        sqlsrv_free_stmt($stmt);

    ?>

    <!-- MARKUP -->

    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user?></li>
        <?php endforeach; ?>
    </ul>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</body>
</html>