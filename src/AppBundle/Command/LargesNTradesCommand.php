<?php 
namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class LargesNTradesCommand extends Command
{
    protected function configure()
    {
        $this
            //the name of the command (the part after "bin/console")
            ->setname('risk:larges-trades')

            // the short description shown while running "php bin/console list"
            ->setDescription('larges trades report.')

            //the full command description shown when running the command with
            //the "--help" option
          
            ->setHelp('This command allows you to get the cash management report...')
         //;

            //configure an argument
            ->addArgument('format', InputArgument::OPTIONAL, 'how do you need the format as email or console?')
           
            ->addArgument('dd', InputArgument::OPTIONAL, 'the date of the report')
            ->addArgument('emailTo',InputArgument::OPTIONAL,'If set, the email will be send to the specific emails')
            ->addArgument('base', InputArgument::OPTIONAL, 'the base of the report')
            ->addArgument('location', InputArgument::OPTIONAL, 'the locaion of the report')
            ->addArgument('N', InputArgument::OPTIONAL, 'the numbers of trades of the report')






 ;

          
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // outputs multiple lines to the console (adding "\n" at the end of each line)
      $output->writeln([
        'Larges Trades',
        '============',
        
    ]);

      
     
    
    }
}









?>
