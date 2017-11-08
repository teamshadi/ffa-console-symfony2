symfonyproj
===========

A Symfony project created on November 6, 2017, 1:52 pm.

# Create new project symfony

symfony new ffa-console-symphony2

# Create commands
 - Create the necessary commands under src/AppBundle/Commands
 - The file should be finished by Command, for example CashManagementCommand.php - After configuring the commands, we should create the file ffa.php in order to   execute the command from the terminal. 
   for example : php ffa.php treasury:cash-management

# link the project ffa-console-symfony2 to ffa-php-core
 - modify the file composer.json to have link to bitbucket.org/teamshadi/ffa-php-core 


# Installation instructions

```bash
composer install
```

Follow instructions in `mfbf-orm-doctrine2-core`

# useful commands

```bash
php ffa.php --help
php ffa.php list
php ffa.php treasury:cashManagement --help
php ffa.php treasury:cashManagement --format=console
...
```
