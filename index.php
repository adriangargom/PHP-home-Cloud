<?php
    // Load Backend Settings data
    $backendSettings = (array) json_decode(file_get_contents("./settings/backendSettings.json", true));

    /*Login*/
    if(!empty($_POST["username"]) && !empty($_POST["password"])){

        $uname = $_POST["username"];
        $passwd = $_POST["password"];

        //Get the login data
        $data = json_decode(file_get_contents("./data/users.json"), true);
        $userFind = false;

        //Destroy previous Sessions if the user havn't log out correctly

        session_start(); // Start Session

    
        //Check if the username and hashed password correspond to some user
        foreach($data as $x){
            if($uname == $x["name"] && md5($passwd) == $x["passwd"]){
                $userFind = true;
                
                //Set the session values
                $_SESSION["uname"] = $uname;
                $_SESSION["image"] = $x["image"];
                $_SESSION["folder"] = $x["folder"];
                $_SESSION["color"] = $x["color"];

                header("Location: ./desktop.php");
            }
        }

        //If user is not found throw an alert
        if(!$userFind){
            echo '<script>
                setTimeout(() => {alert("User or password not valid!")}, 100)
            </script>';
        }
    }

    /*Create Account*/
    if(!empty($_POST["newUserName"]) && !empty($_POST["newUserPassword"])){

        //Get the login data
        $data = json_decode(file_get_contents("./data/users.json"), true);

        if($data == null){
            $data = [];
        }

        $inList = false;

        //Check if the user is in the list and trow an alert if it exists
        foreach($data as $x){
            if($x["name"] == $_POST["newUserName"]){
                $inList = true;
                echo '<script>           
                    setTimeout(() => {alert("User is aleady created!")}, 100)
                </script>';
                break;
            }
        }

        //If the users created is smaller than the maxUsers limit and the user is not in the list 
        if(count($data) < $backendSettings['maxUsers'] && !$inList){
            $username = $_POST["newUserName"];
            $passwd = md5($_POST["newUserPassword"]);
            
            //Set a random user image
            $default_user_images = [
                "https://images.unsplash.com/photo-1568402102990-bc541580b59f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8Mnx8fGVufDB8fHx8&w=1000&q=80",
                "https://photo980x880.mnstatic.com/37f93c7924cb320de906a1f1b9f4e12a/la-gran-via-de-madrid-1072541.jpg",
                "https://d500.epimg.net/cincodias/imagenes/2019/06/04/lifestyle/1559679036_977776_1559679371_noticia_normal.jpg",
                "https://cdn.pixabay.com/photo/2016/11/29/04/19/ocean-1867285_1280.jpg",
                "https://www.blogdelfotografo.com/wp-content/uploads/2022/01/girasol-foto-perfil.webp"
            ];

            $default_image = $default_user_images[rand(0, count($default_user_images)-1)];
            $image = !empty($_POST["newUserImage"])? $_POST["newUserImage"] : $default_image;
    
            //Set and create the folder path
            $folderPath = "./folders/$username";
            mkdir($folderPath);
            
            //Create the new dictionary and push it to the "JSON" decoded array
            $new_user_data = array(
                "name" => $username,
                "passwd" => $passwd,
                "image" => $image,
                "color" => $_POST["color"],
                "folder" => $folderPath,
            );
            
            array_push($data, $new_user_data);
            
            //Encode the "JSON" array into json format and added into the login file
            $new_json_data = json_encode($data);
            file_put_contents("./data/users.json", $new_json_data);

        }else if(!$inList){
            echo '<script>           
                setTimeout(() => {alert("You can\'t create more users")}, 100)
            </script>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--CSS File-->
    <link rel="stylesheet" href="./styles/login.css">

    <!--JavaScript File-->
    <script src="./js/login.js"></script>

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!--Google Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>
<body>

    <!--Shape Divider-->
    <div class="custom-shape-divider-bottom-1682882668">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>

    <!--Header-->
    <header class="main_header">
        <h1>FileManager</h1>
        <hr style="width: 60%; margin-left: 20%; border: 4px solid rgba(22, 22, 22, 0.35);">
    </header>

    <!--Main Section with the forms-->
    <section>
        <div class="form_data" id="form_data_id">

            <div class="left_div_login_form" id="left_div_login_container" onclick="leftContainer()">
    
                <div id="left_div_info" style="display: none">
                    <h1>Login Account</h1>
                    <span class="material-symbols-outlined" id="expand_arrow_icon_left">
                        expand_more
                    </span>
                </div>
    
                <div id="left_div_form" style="display: block">
                    <h1>Login Account</h1>
                    <br>

                    <form class="col d-grid gap-2" action="" method="POST">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username">
            
                        <label class="form-label">Password</label>

                        <div class="passwd_frame_div">
                            <input type="password" class="form-control" id="passwd_container_left" name="password">
                            <div onclick="hideShowPassword()" class="show_hide_button"><img id="passwd_toggle_left" src="./images/Hide.png" width="50px"></div>
                        </div>

                        <br><br>
            
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
    
            <div class="rigth_div_login_form" id="right_div_login_container" onclick="rightContainer()">
    
                <div id="rigth_div_info" style="display: block">
                    <h1>Create Account</h1>
                    <span class="material-symbols-outlined" id="expand_arrow_icon_right">
                        expand_more
                    </span>
                </div>
                
                <div id="rigth_div_form" style="display: none">
                    <h1>Create Account</h1>
                    <br>
                    <form action="" method="POST" class="col d-grid gap-2">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="newUserName" maxlength="10">

                        <div class="image_color_frame">
                            <div>
                                <label class="form-label">Image URL</label>
                                <input type="text" class="form-control" name="newUserImage">
                            </div>
                            <div>
                                <label for="exampleColorInput" class="form-label">Color Theme</label>
                                <input type="color" class="form-control form-control-color" value="#563d7c" title="Choose your color" name="color">
                            </div>
                        </div>

                        <label class="form-label">Password</label>

                        <div class="passwd_frame_div">
                            <input type="password" class="form-control" id="passwd_container_rigth" name="newUserPassword">
                            <div onclick="hideShowPassword()" class="show_hide_button"><img id="passwd_toggle_right" src="./images/Hide.png" width="50px"></div>
                        </div>
                        
                        <br><br>
            
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
    
        </div>
    </section>

    <!--Footer-->
    <footer class="main_footer">

        <span class="material-symbols-outlined">sports_handball</span>
        <span class="material-symbols-outlined">emoji_people</span>

        <h1>Coded by AdrianGarGom</h1>

        <span class="material-symbols-outlined">accessibility</span>
        <span class="material-symbols-outlined">sports_martial_arts</span>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>