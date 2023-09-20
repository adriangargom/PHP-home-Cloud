<?php
    session_start();

    include "./session_manage.php";

    // Load Backend Settings data
    $backendSettings = (array) json_decode(file_get_contents("./settings/backendSettings.json", true));

    //Delete Folders
    if(isset($_POST["folderDel"])){
        $path = $_SESSION["folder"];
        $folderName = $_POST['folderDel'];
        rmdir("./$path/$folderName");

        header("Location: ./desktop.php");
    }

    //Delete Files
    if(isset($_POST["fileDel"])){
        $path = $_SESSION["folder"];
        $folderName = $_POST['fileDel'];
        unlink("./$path/$folderName");

        header("Location: ./desktop.php");
    }

    //Create Folders/Files
    if(isset($_POST["folderName"])){

        $path = $_SESSION["folder"];
        $name = $_POST['folderName'];
        $type = $_POST['fileType'];

        $filePath = $path."/".$name;

        switch ($type) {
            case '0': //Folder
                mkdir("./$path/$name");
                break;
            case '1': //File
                $file = fopen($filePath.".txt", "w");
                fclose($file);
                break;
            case '2': //File
                $file = fopen($filePath.".docs", "w");
                fclose($file);
                break;
            case '3': //File
                $file = fopen($filePath.".xlsx", "w");
                fclose($file);
                break;
            case '4': //File
                $file = fopen($filePath.".csv", "w");
                fclose($file);
                break;
            case '5': //File
                $file = fopen($filePath.".html", "w");
                fclose($file);
                break;
            case '6': //File
                $file = fopen($filePath, "w");
                fclose($file);
                break;
            default: //Other
                echo '<script>           
                    setTimeout(() => {alert("You have to set a File Type")}, 100)
                </script>';
                break;
        }

        header("Location: ./desktop.php");
    }

    //Upload Files
    if(isset($_FILES["files"])){

        $files = $_FILES['files'];

        for ($i=0; $i < count($files['name']); $i++) { 
            $file_name = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];
            $file_size = $files['size'][$i];
            $file_error = $files['error'][$i];

            if($file_error === UPLOAD_ERR_OK){
                if($file_size < $backendSettings['maxUploadSizeMB'] * pow(1024, 2)){
                    move_uploaded_file($file_tmp, $_SESSION['folder']."/".$file_name);
                    header("Location: ./desktop.php");

                }else{ 
                    header("Location: ./desktop.php"); 
                }

            }else{
                header("Location: ./desktop.php");
            }
        }
    }


    //Move Directories IN
    if(isset($_POST["go"])){

        $path = $_SESSION["folder"];
        $open_folder = $_POST["go"];
        $_SESSION["folder"] = $path."/$open_folder";

        header("Location: ./desktop.php");
    }

    //Move Directories OUT
    if(isset($_POST["go_back"])){

        $path = $_SESSION["folder"];
        
        if($path != "./folders/".$_SESSION["uname"]){

            $paths = explode("/", $path);
            array_pop($paths);
    
            $new_path = "";
    
            foreach($paths as $x){
                $new_path .= "/".$x;
            }
            $_SESSION["folder"] = ltrim($new_path, "/");

            header("Location: ./desktop.php");
        }else{
            
            header("Location: ./desktop.php");
        }
    }
?>