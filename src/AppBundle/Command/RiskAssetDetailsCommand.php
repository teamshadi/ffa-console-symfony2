<?php 
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class RiskAssetDetailsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            //the name of the command (the part after "bin/console")
            ->setname('risk:asset-details')

            // the short description shown while running "php bin/console list"
            ->setDescription('risk asset details report.')

            //the full command description shown when running the command with
            //the "--help" option
          
            ->setHelp('This command allows you to get the risk asset details report...')
        ;

            //configure an argument

          
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // outputs multiple lines to the console (adding "\n" at the end of each line)
      $output->writeln([
        'Risk asset details',
        '============',
        
    ]);

      
     
    
    }
}









?>
