<?php

namespace AppBundle\Command;

use \MfBfDriver\Bankflow\BdlReports;
use \FfaPhp\AccountingBdlReports;
use \FfaPhp\AccountingBdlReports\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class MgapCommand extends Command
{
  protected function configure() {
    $this
        //the name of the command (the part after "bin/console")
       ->setname('accounting:mgap')

			 // the short description shown while running "php bin/console list
       ->setDescription('Mgap report.')

      //the full command description shown when running the command with
     //the "--help" option

       ->setHelp('This command allows you to get the Mgap report...')


       ->addOption(
         'format',
         null,
         InputOption::VALUE_OPTIONAL,
         'console|email    how do you need the format as email or console?',
         'console'
       )
       ->addOption(
         'dd',
         null,
         InputOption::VALUE_OPTIONAL,
         '2017-04-04   the date of the report',
         date("Y-m-d",strtotime('last day of last month'))
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
          'subsetLBP',
          null,
         InputOption::VALUE_OPTIONAL,
         'False by default: NON LBP',
          false
         )

        ;
  }

  protected function execute(InputInterface $input, OutputInterface $output){
    $format=$input->getOption('format');
    $emailTo=$input->getOption('emailTo');
    $dd=$input->getOption('dd');
    $base=$input->getOption('base');
    $location=$input->getOption('location');
    $subsetLBP=$input->getOption('subsetLBP');

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
      $emailTo = $je->getEmails("MGAP");
    }

  

    $dd = \DateTime::createFromFormat("!Y-m-d",$dd);

    assert_options(ASSERT_BAIL,true); // to fail on failed asserts instead of just issuing a warning
    $factory = new Factory();
    $bdl201117 = $factory->bdl201117($dd, $base, $location, true);
    $report = $factory->mgap($bdl201117->detailsFlat, $base, $location, $dd, $subsetLBP);

  

    switch($format) {
      case "console":
        echo($report->toConsole());
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

 
 }
}
