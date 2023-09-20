# Explanation 🖥
The following project consists of a simple web application for uploading, 
downloading and managing files bia web explorer, this application has been 
developed with the following tecnologies (PHP, HTML, CSS and JS)

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)]()
[![HTML](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)]()
[![CSS](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)]()
[![JS](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)]()

# Dependencies
- PHP (tested version = 7.4.33)
- Apache2

# Deployment Instructions
## Windows
```
1. Download XAMPP
2. Download the source Code and move it into the xampp folder
  - path => C://xampp/htdocs

3. Run the XAMPP Server
4. Enjoy the application
```
## Linux
```
1. Download Apache2 and PHP
- sudo apt install apache2 php

2. Download the source code and move it into the "/var/www/html" folder
3. Give the necessary permissions to the following folders
- sudo chmod -R 777 folders/
- sudo chmod -R 777 data/users.json

4. Reload the Apache Server
- sudo systemctl restart apache2

5. Enjoy the application
```

# Application Settings ⚙
The application config file is found in the folder "settings", you can open an edit the file with your desire parameters

Configurable parameters :

- maxUsers => Set the max number of users that the application can create

- maxUploadSizeMB => Set's the max upload size for the application in MB

- session_inactivity_time => Sets the session inactivity time of a logged in User in seconds

