<?php
    session_start();

    include "./session_manage.php";

    //Sort folders and files into diferent arrays
    $folders_arr = array();
    $files_arr = array();

    $dir_files = scandir($_SESSION["folder"]);
    
    array_shift($dir_files);
    array_shift($dir_files);

    foreach($dir_files as $x){
        if(strpos($x, ".")){
            array_push($files_arr, $x);
        }else{
            array_push($folders_arr, $x);
        }
    }


    //Delete Account
    if(!empty($_POST["delAccount"])){

        //Get login data
        $data = (array) json_decode(file_get_contents("./data/users.json"), true);

        //Delete the user from the data array
        for ($i=0; $i < count($data); $i++) { 
            if($data[$i]["name"] == $_SESSION["uname"]){
                unset($data[$i]);
                break;
            }
        }

        //Move the folder to the cache
        rename("./folders/".$_SESSION["uname"], "./cache/".$_SESSION["uname"]);

        //Write the new data into the login data file
        $new_data = json_encode($data);
        file_put_contents("./data/users.json", $new_data);

        //Close the session
        session_unset();
        session_destroy();
        header("Location: ./index.php");
    }


    //Log Out
    if(!empty($_POST["logOut"])){
        session_unset();
        session_destroy();
        header("Location: ./index.php");
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
    <link rel="stylesheet" href="./styles/desktop.css">

    <!--JavaScript File-->
    <script src="./js/login.js"></script>

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!--Google Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>
<body>

    <!--Shape Divider
    <div class="custom-shape-divider-bottom-1682882668">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>
    -->

    <!--Header-->
    <header class="main_header">
        
        <img style="border: 4px solid <?php echo $_SESSION['color']?>;" src="<?php echo $_SESSION["image"]?>">
        
        <div>
            <h1 style="margin-left:5%; text-align: left;"><?php echo $_SESSION["uname"]?></h1>
        </div>


        <div style="display: grid; grid-template-columns: 50% 50%; grid-gap:5%; margin-rigth:5%;">

            <form action="" method="POST">
                <button class='btn btn-danger header_buttons' type="submit" name="delAccount" value="delete">Delete Account</button>
            </form>

            <form action="" method="POST">
                <button class="btn btn-primary header_buttons" type="submit" name="logOut" value="logout">Log Out</button>
            </form>

        </div>

    </header>

    <!--Main Section with the forms-->
    <section>

        <div>
            <div class="add_folders">
                <h1 style="color: #fff; margin-bottom: 2%;"><?php echo "/".ltrim($_SESSION["folder"], "./folders")?></h1>
                <form class="create_folder_form" action="./file_manage.php" method="POST">
                    <input class="form-control" type="text" placeholder="New Folder or File Name" name="folderName">
                    
                    <select class="form-select" aria-label="Default select example" name="fileType">
                        <option selected>Type</option>
                        <option value="0">Folder</option>
                        <option value="1">File .txt</option>
                        <option value="2">File .docs</option>
                        <option value="3">File .xlsx</option>
                        <option value="4">File .csv</option>
                        <option value="5">File .html</option>
                        <option value="6">File Other</option>
                    </select>
                    
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>

                <form class="exit_folder_form" action='./file_manage.php' method='POST'>
                    <input type='hidden' name='go_back' value="back"/>
                    <button style='width: 100%;'  type='submit' class='btn btn-primary' name='go_back' value="back">Back</button>
                </form>
            </div>

            <div class="folder_container">

                <?php
                    //Load the previos grabed folders into the DOM

                    foreach($folders_arr as $x){
                        echo "
                        <div class='folder_instance'>
                            <div><a wordwrap style='color:#fff;'>$x</a></div>

                            <form action='./file_manage.php' method='POST'>
                                <input type='hidden' name='go' value='$x'/>
                                <button style='width: 100%;'  type='submit' class='btn btn-primary' name='go_path'value='$x'>Enter</button>
                            </form>

                            <form action='./file_manage.php' method='POST'>
                                <input type='hidden' name='folderDel' value='$x'/>
                                <button style='width: 100%;' type='submit' class='btn btn-danger'>Delete</button>
                            </form>
                        </div>
                        ";
                    }
                ?>

            </div>

        </div>

        <div>
            <div class="add_folders">
                <h1 style="color: #fff; margin-bottom: 2%;">Add Files</h1>

                <form class="create_folder_form" action="./file_manage.php" method="POST" enctype="multipart/form-data">
                    <input class="form-control" id="formFileMultiple"  type="file" name="files[]" multiple>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

            </div>

            <div class="file_container">

                <?php
                    //Load the previos grabed files into the DOM

                    $path = $_SESSION["folder"];

                    foreach($files_arr as $x){

                        $filePath = $path."/".$x;

                        echo "
                            <div class='file_instance'>
                                <div><a wordwrap style='color:#fff;' href='$filePath'>$x</a></div>
                                <form action='./file_manage.php' method='POST'>
                                    <input type='hidden' name='fileDel' value='$x'/>
                                    <button style='width: 100%;' type='submit' class='btn btn-danger' name='del_file'value='$x'>Delete</button>
                                </form>
                            </div>
                        ";
                    }
                ?>

            </div>
        </div>
        
    </section>

    <!--Footer-->
    <footer class="main_footer">

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>