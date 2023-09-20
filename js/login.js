
// Left and Rigth container code
function leftContainer(){

    let formData = document.getElementById("form_data_id");
    formData.style.gridTemplateColumns = "70% 30%";

    //Left
    {
        let leftDataDiv = document.getElementById("left_div_form");
        leftDataDiv.style.display = "block";
    
        let leftInfoDiv = document.getElementById("left_div_info");
        leftInfoDiv.style.display = "none";

        let leftContainer = document.getElementById("left_div_login_container");
        leftContainer.style.cursor = "default";
    }

    //Right
    {
        let rigthDataDiv = document.getElementById("rigth_div_form");
        rigthDataDiv.style.display = "none";
    
        let rigthInfoDiv = document.getElementById("rigth_div_info");
        rigthInfoDiv.style.display = "block";

        let rightContainer = document.getElementById("right_div_login_container");
        rightContainer.style.cursor = "pointer";
    }
}

function rightContainer(){

    let formData = document.getElementById("form_data_id");
    formData.style.gridTemplateColumns = "30% 70%";

    //Left
    {
        let leftDataDiv = document.getElementById("left_div_form");
        leftDataDiv.style.display = "none";
    
        let leftInfoDiv = document.getElementById("left_div_info");
        leftInfoDiv.style.display = "block";

        let leftContainer = document.getElementById("left_div_login_container");
        leftContainer.style.cursor = "pointer";
    }

    //Right
    {
        let rigthDataDiv = document.getElementById("rigth_div_form");
        rigthDataDiv.style.display = "block";
    
        let rigthInfoDiv = document.getElementById("rigth_div_info");
        rigthInfoDiv.style.display = "none";

        let rightContainer = document.getElementById("right_div_login_container");
        rightContainer.style.cursor = "default";
    }

}

//Show or Hide the password
let showPasswd = false;

function hideShowPassword(){

    let passwToggleLeft = document.getElementById("passwd_toggle_left")
    let passwToggleRigth = document.getElementById("passwd_toggle_right")

    let passwdContainerLeft = document.getElementById("passwd_container_left")
    let passwdContainerRigth = document.getElementById("passwd_container_rigth")

    if(!showPasswd){
        passwToggleLeft.src = "./images/Show.png"
        passwToggleRigth.src = "./images/Show.png"
        passwdContainerLeft.type = "text";
        passwdContainerRigth.type = "text";
        showPasswd = true

    }else if(showPasswd){
        passwToggleLeft.src = "./images/Hide.png"
        passwToggleRigth.src = "./images/Hide.png"
        passwdContainerLeft.type = "password";
        passwdContainerRigth.type = "password";
        showPasswd = false
    }
}