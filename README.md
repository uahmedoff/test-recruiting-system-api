<h1>Test recruiting system</h1>

### Installation

##### Clone project

    https://github.com/uahmedoff/test-recruiting-system-api.git

##### Go to the folder application using cd command on your cmd or terminal

    cd test-recruiting-system-api

##### Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu

    cp .env.example .env

##### Run your cmd or terminal

    composer install

##### Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration. By default, the username is root and you can leave the password field empty. (This is for Xampp) By default, the username is root and password is also root. (This is for Lamp)

##### Run

    php artisan key:generate

##### Make symbolic link to storage

    php artisan storage:link

    