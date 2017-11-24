<?php

namespace AppBundle\Command;

use \FfaPhp\Common\PositionManagerFactory;
use \MfBfDriver\Marketflow\Portfolios;
use \MfBfDriver\Common\MarketflowClient;
use \FfaPhp\MfBfExtended\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class ToptenpositionsCommand extends Command
{
  protected function configure() {
    $this
        //the name of the command (the part after "bin/console")
       ->setname('risk:toptenpositions')

			 // the short description shown while running "php bin/console list
       ->setDescription('Top ten Positions report.')

      //the full command description shown when running the command with
     //the "--help" option

       ->setHelp('This command allows you to get the top ten positions report...')

    //configure an Option
       ->addOption(
         'format',
         null,
         InputOption::VALUE_OPTIONAL,
         'console|email    how do you need the format as email or console?',
         'html'
       )
       ->addOption(
          'd1',
         null,
         InputOption::VALUE_OPTIONAL,
         '2017-04-04   the date of the report',
         date("Y-m-d",strtotime('2 days ago'))
       )
      
      ->addOption(
         'd2',
        null,
        InputOption::VALUE_OPTIONAL,
        '2017-04-04   the date of the report',
        date("Y-m-d",strtotime('yesterday')  )
        )


       ->addOption(
         'emailTo',
         null,
         InputOption::VALUE_OPTIONAL,
         's.akiki@ffaprivatebank.com;shadiakiki1986@gmail.com    If set, the email will be send to the specific emails',
         null
       )
       ->addOption(
         'N',
         null,
         InputOption::VALUE_OPTIONAL,
         '10    number of days back to compute report',
         10
       )
       ->addOption(
          'base',
         null,
         InputOption::VALUE_OPTIONAL,
         'base should be lebanon or dubai',
         'Lebanon'
         )
       ->addOption(
          'location',
         null,
         InputOption::VALUE_OPTIONAL,
         'location should be Beirut,Dubai pr test',
         'Beirut'
          )
        

        ->addOption(
          'publishToBlog',
         null,
         InputOption::VALUE_OPTIONAL,
         'publish to blog',
         null

     )
       ->addOption(
          'notifyTracker',
         null,
         InputOption::VALUE_OPTIONAL,
         'notify tracker',
         null

     )

     ;
    }
 
  protected function execute(InputInterface $input, OutputInterface $output){
    $format=$input->getOption('format');
    $emailTo=$input->getOption('emailTo');
    $d1=$input->getOption('d1');
    $d2=$input->getOption('d2');
    $N = $input->getOption('N');
    $base=$input->getOption('base');
    $location=$input->getOption('location');
    $notifyTracker=$input->getOption('notifyTracker');
    $publishToBlog=$input->getOption('publishToBlog');
    
    if(!is_null($emailTo)) {
      if(!!$emailTo) $emailTo = explode(";",$emailTo);
        $format="email";
    }

    if($format=="email" && !$emailTo) 
       throw new \Exception("Unsupported format.");


    $d1 = \DateTime::createFromFormat("!Y-m-d",$d1);
    $d2 = \DateTime::createFromFormat("!Y-m-d",$d2);

    // nav
    $mfDb=new \MfBfDriver\Common\MarketflowClient($base,$location,false);
    $mfWr=new \MfBfDriver\Marketflow\Portfolios($mfDb);
    $nmf = new \FfaPhp\Common\PositionManagerFactory($d1,$d2,$N,false,$mfWr);
    $nm = $nmf->generate();

     
    if(!is_null($publishToBlog)) {
      $nm->publish();
     }
                 
            
    switch($format) {
      case "html":
        echo($nm->toHtml());
        break;
      case "cionsole":
        echo($nm->toConsole);
      case "email":
        $emailer = new \FfaPhp\Common\Emailer($nm,$emailTo);
        $emailer->send();
        break;
      case "quiet":
        break;
      default:
        throw new \Exception("Invalid format");
    }
  
      if(!is_null($notifyTracker)) {
         \FfaPhp\MfBfExtended\Utils::contactTracker("topTenPositionChanges.php");
      }
  }

}
