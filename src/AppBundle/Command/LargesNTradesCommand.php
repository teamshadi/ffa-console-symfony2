<?php

namespace AppBundle\Command;

use \FfaPhp\Common\LargestTradesFactory;
use \MfBfDriver\SIC\Marketflow\TradingActivity;
use \MfBfDriver\Common\MarketflowClient;
use \FfaPhp\MfBfExtended\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class LargesNTradesCommand extends Command
{
  protected function configure() {
    $this
        //the name of the command (the part after "bin/console")
       ->setname('risk:largestnTrades')

			 // the short description shown while running "php bin/console list
       ->setDescription('PnL report.')

      //the full command description shown when running the command with
     //the "--help" option

       ->setHelp('This command allows you to get the PnL report...')


       ->addOption(
         'format',
         null,
         InputOption::VALUE_OPTIONAL,
         'console|email    how do you need the format as email or console?',
         'email'
       )
       ->addOption(
         'dd',
         null,
         InputOption::VALUE_OPTIONAL,
         '2017-04-04   the date of the report',
         date("Y-m-d",strtotime('yesterday'))
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
         'base should be lebanon or dubai',
         'Lebanon'
       )
       ->addOption(
         'location',
         null,
         InputOption::VALUE_OPTIONAL,
         'location should be Beirut, Bsalim or Test',
         'Beirut'
         
       )
       ->addOption(
          'N',
          null,
         InputOption::VALUE_OPTIONAL,
         '10    number of largest 10 trades',
         10
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
    $dd=$input->getOption('dd');
    $base=$input->getOption('base');
    $location=$input->getOption('location');
    $N=$input->getOption('N');
    $publishToBlog=$input->getOption('publishToBlog');
    $notifyTracker=$input->getOption('notifyTracker'); 



    if(!is_null($emailTo)) {
      if(!!$emailTo) $emailTo = explode(";",$emailTo);
      $format="email";
    }

    if($format=="email" && !$emailTo) {
      # get from the ffa-jobs-emails server
      # https://github.com/minerva22/ffa-jobs-emails
      if(!getenv("FFA_JOBS_EMAILS_URL")) {
        throw new \Exception("format==email and emailTo not passed and env var FFA_JOBS_EMAILS_URL missing");
      }

      $url = getenv("FFA_JOBS_EMAILS_URL");
      $je = new \FfaJobsSettings\JobsEmails($url);
      $emailTo = $je->getEmails("Largest 10 Trades");
    }


    

    $dd = \DateTime::createFromFormat("!Y-m-d",$dd);

    // retrieval from mf db table
    $mfDb=new \MfBfDriver\Common\MarketflowClient($base,$location,false);
    $ta = new \MfBfDriver\SIC\Marketflow\TradingActivity($mfDb);
    $factory = new \FfaPhp\Common\LargestTradesFactory($ta);
    $report = $factory->get($dd,$N);

    if(!is_null($notifyTracker)) {
      $report->publish();
    }   

    switch($format) {
      case "html":
        echo($report->toHtml());
        break;
      case "json":
         echo $report->toJson();
         break;
      case "email":
        $emailer = new \FfaPhp\Common\Emailer($report,$emailTo);
        $emailer->send();
        break;
      case "quiet":
        break;
      default:
        throw new \Exception("Invalid format");
    }
 
       if(!is_null($notifyTracker)) {
           \FfaPhp\MfBfExtended\Utils::contactTracker("getLargestNTrades.php");
            

  }

 
 }
}
