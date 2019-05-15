# BurgerCode
Burger sales website on symfony4

# Installation

Start by cloning the project.


    git clone https://github.com/DubMan21/BurgerCode.git
    

Create an .env file at the root of the project. Paste there the contents of the .env.dist file and modified DATABASE_URL according to your database management system.

  
    DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
    
  
Install dependencies with composer.


    composer install
    

Create the database through doctrine.

Create migrations, and then migrate them.


    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    

Load the fixtures.


    php bin/console doctrine:fixtures:load
    
    
Install yarn, then build the asssets.


    yarn install
    yarn encore dev --watch
    
    
You can now launch the server and browse the site!


    php bin/console server:run
