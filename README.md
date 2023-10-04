## Learning Symfony Messenger and Queue

This repository contains code for learning Messenger and Queue concepts in Symfony, developed following the SymfonyCasts course Messenger! Queue work for Later: https://symfonycasts.com/screencast/messenger.

**Setup**

**Prerequisites**

* Composer
* Node
* Yarn

**Instructions**

1. Clone the repository to your local machine.
2. Install the Composer dependencies:

`composer install`


3. Configure the `.env` file.
4. Create the database and tables:

`php bin/console doctrine:database:create`</br>
`php bin/console doctrine:migrations:migrate`


5. Compile the Webpack Encore assets:

`yarn install`</br>
`yarn encore dev`


6. Start the built-in web server:

`symfony serve`</br

Open your browser and navigate to http://localhost:8000 to view the project.