<?php
/* 
 * php delete function that deals with directories recursively
 */
// function delete_files($target) {
//     if(is_dir($target)){
//         $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
        
//         foreach( $files as $file )
//         {
//             delete_files( $file );      
//         }
      
//         rmdir( $target );
//     } elseif(is_file($target)) {
//         unlink( $target );  
//     }
// }

// //mysql_query("DROP DATABASE atomstore");
// $dbhost = 'localhost';
// $dbuser = 'demoicod_ico';
// $dbpass = 'P145DeDevelopers';
// $conn = mysql_connect($dbhost, $dbuser, $dbpass);
// if(! $conn )
// {
//   echo('Could not connect: ' . mysql_error());
// }
// echo 'Connected successfully<br />';
// $sql = 'DROP DATABASE `demoicod_ico`';
// //$sql = 'DROP DATABASE `sourceve_wp2`';
// $retval = mysql_query( $sql, $conn );
// if(! $retval )
// {
//   echo('Could not delete database: ' . mysql_error());
// }
// echo "Database deleted successfully\n";
// mysql_close($conn);


// delete_files("application");
// delete_files("fblogin");
// delete_files("resources");
// delete_files("system");
// delete_files("twitteroauth");
// delete_files("oauth.php");
// delete_files("twitterlogin.php");
// delete_files("index.php");
?>
