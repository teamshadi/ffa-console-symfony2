<?php 
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class SecuritiesCountryCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            //the name of the command (the part after "bin/console")
            ->setname('scripts:risk-securitiescountries')

            // the short description shown while running "php bin/console list"
            ->setDescription('risk securities countries report.')

            //the full command description shown when running the command with
            //the "--help" option
          
            ->setHelp('This command allows you to get the risk securities countries report...')
         //;

            //configure an argument
            ->addArgument('format', InputArgument::OPTIONAL, 'how do you need the format as email or console?')
           
            ->addArgument('emailTo',InputArgument::OPTIONAL,'If set, the email will be send to the specific emails')
    ;

          
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // outputs multiple lines to the console (adding "\n" at the end of each line)
      $output->writeln([
        'Risk securities countries',
        '============',
        
    ]);

      
     
    
    }
}









?>
