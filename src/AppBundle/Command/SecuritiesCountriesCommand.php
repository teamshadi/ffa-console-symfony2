<?php 
namespace AppBundle\Command;
use \FfaPhp\Common\SecuritiesFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SecuritiesCountriesCommand extends Command
{
    protected function configure()
    {
        $this
            //the name of the command (the part after "bin/console")
            ->setname('risk:securities-countries')

            // the short description shown while running "php bin/console list"
            ->setDescription('risk securities countries report.')

            //the full command description shown when running the command with
            //the "--help" option
          
            ->setHelp('This command allows you to get the risk securities countries report...')
         //;

            //configure an argument
            ->addOption(
              'format',
              null,
              InputOption::VALUE_OPTIONAL, 
              'how do you need the format as email or html or json',
              'console'
              )
           
            ->addOption(
              'emailTo',
              null,
              InputOption::VALUE_OPTIONAL,
              's.akiki@ffaprivatebank.com;shadiakiki1986@gmail.com    If set, the email will be send to the specific emails',
              null
              )
             ->addOption(
               'base',
               null,
               InputOption::VALUE_OPTIONAL,
              'client base',
              'Lebanon'
               )
              ->addOption(
                'location',
                null,
                InputOption::VALUE_OPTIONAL,
               'location Lebanon or Dubai',
               'Beirut'
                )

                ;

          
    }

 protected function execute(InputInterface $input, OutputInterface $output){
      $format=$input->getOption('format');
      $emailTo=$input->getOption('emailTo');
      $base=$input->getOption('base');
      $location=$input->getOption('location');

      if(!is_null($emailTo)) {
        if(!!$emailTo) $emailTo = explode(";",$emailTo);
           $format="email";
       }
        
      if($format=="email" && !$emailTo) {
        throw new \Exception("Please specify emailTo with format=email");

      }
       $factory=new \FfaPhp\Common\SecuritiesFactory();
       $report = $factory->countries(['ISRAEL'], $base, $location);
       

       switch($format) {
           case "console":
             echo($report->toConsole());
             break;
         
           case "email":
              $emailer = new \FfaPhp\Common\Emailer($report, $emailTo);
              $emailer->send();
              break;
           case "quiet":
              break;
          
           default:
              throw new \Exception("Invalid format");

                                                                     
          }
      
     
    
    }
}









?>
