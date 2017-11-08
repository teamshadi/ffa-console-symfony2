<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class TreasuryFfa017Command extends ContainerAwareCommand
{
      protected function configure()
          { $this
                      //the name of the command (the part after "bin/console")
                     ->setname('scripts:treasuryffai007')

                     // the short description shown while running "php bin/console list"
                     ->setDescription('Treasury FFAI007 aggregated by currencies report.')

                    //the full command description shown when running the command with
                   //the "--help" option
                                                                             
                     ->setHelp('This command allows you to get the Treasury FFAI007 aggregated by currencies report...')
                

                   //configure an argument
                     ->addArgument('format', InputArgument::OPTIONAL, 'how do you need the format as email or console?')           
                     ->addArgument('dd', InputArgument::OPTIONAL, 'the date of the report')
                     ->addArgument('emailTo',InputArgument::OPTIONAL,'If set, the email will be send to the specific emails')
                     ->addArgument('base', InputArgument::OPTIONAL, 'client base')
                     ->addArgument('location',InputArgument::OPTIONAL,'location Lebanon or Dubai')
                   
                   ;

                     
           }
        protected function execute(InputInterface $input, OutputInterface $output)
           {
                   // outputs multiple lines to the console (adding "\n" at the end of each line)
                     $output->writeln([
                     'Treasury FFAI007 aggregated by currencies',
                      '============',
                                               
                       ]) ;                          
                                        
                                            
          }
} 
?>
