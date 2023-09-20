<?php
    $backendSettings = (array) json_decode(file_get_contents("./settings/backendSettings.json", true));

    $inactive_time = $backendSettings["sessionInactivityTime"];

    if(isset($_SESSION['last_activity']) && (time() - $_SESSION["last_activity"]) > $inactive_time){

        session_unset();
        session_destroy();

        $_GET["err"] = "100";
        header("Location: ./index.php");
        exit();
    }

    $_SESSION['last_activity'] = time();
?>