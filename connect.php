<?php

    $serverName = "DESKTOP-N1RE9II\SQLEXPRESS";

    $connectionOptions = array(
        "Database" => "iWork"
    );

    // // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if($conn) {
        echo "Connected!";
        // if( ($result = sqlsrv_query($conn,"SELECT * FROM Users")) !== false ){
        //     while( $obj = sqlsrv_fetch_object( $result )) {
        //       echo $obj->colName.'<br />';
        //     }
        // }

    } else {
    	echo "WAH WAH";
    }


    $sql = "SELECT username FROM Users ";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        echo "stmt false";
        // die( print_r( sqlsrv_errors(), true) );
    }
    else {
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              echo $row['username']. "<br />";
        }
    }
    sqlsrv_free_stmt( $stmt);
?>