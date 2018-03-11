<?php 
        
  $serverName = "DESKTOP-N1RE9II\SQLEXPRESS";

  $connectionOptions = array(
      "Database" => "iWork"
  );

  // Establishes the connection
  $conn = sqlsrv_connect($serverName, $connectionOptions);

  // Sanity check
  if(!$conn) {
      echo "CONNECTION FAILED TO THE DATABASE";
  }

?>