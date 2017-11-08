<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this
            //the name of the command (the part after "bin/console")
            ->setname('app:create-user')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            //the full command description shown when running the command with
            //the "--help" option
          
            ->setHelp('This command allows you to create a user...')
         //;

            //configure an argument
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
          ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // outputs multiple lines to the console (adding "\n" at the end of each line)
      $output->writeln([
        'User Creator',
        '============',
        '',
    ]);

      $output->writeln('Username: '.$input->getArgument('username'));
      // access the container using getContainer()
      #  $userManager = $this->getContainer()->get('app.user_manager');
        #$userManager->create($input->getArgument('username'));

       # $output->writeln('User successfully generated!');
    
    }
}









?>
