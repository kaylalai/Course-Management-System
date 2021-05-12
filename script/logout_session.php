      <?php
            session_start(); //checks if a session is already started and if none is started then it starts one     
            session_destroy();  //destroy the sessions saved before.
            header('Location: home_page/home.php');  //automatically go back to homepage
        ?>