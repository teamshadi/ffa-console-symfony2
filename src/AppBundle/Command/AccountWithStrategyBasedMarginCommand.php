<?php

namespace AppBundle\Command;

use \FfaPhp\Common\AccountsGenerator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class AccountWithStrategyBasedMarginCommand extends Command
{
  protected function configure() {
    $this
        //the name of the command (the part after "bin/console")
       ->setname('risk:account-basedmargin')

       // the short description shown while running "php bin/console list"
       ->setDescription('Account with startegy based margin report.')

      //the full command description shown when running the command with
     //the "--help" option

       ->setHelp('This command allows you to get the accounts with strategy based margin report...')


     //configure an Option
       ->addOption(
         'format',
         null,
         InputOption::VALUE_OPTIONAL,
         'console|email    how do you need the format as email or console?',
         'console'
       )
       
       ->addOption(
         'emailTo',
         null,
         InputOption::VALUE_OPTIONAL,
         's.akiki@ffaprivatebank.com;shadiakiki1986@gmail.com    If set, the email will be send to the specific emails',
         null
       )
     ;
  }

  protected function execute(InputInterface $input, OutputInterface $output){
    $format=$input->getOption('format');
    $emailTo=$input->getOption('emailTo');

    if(!is_null($emailTo)) {
      if(!!$emailTo) $emailTo = explode(";",$emailTo);
      $format="email";
    }

    if($format=="email" && !$emailTo) {
        throw new \Exception("format==email and emailTo not passed"
        );
      }

   
      $factory = new AccountsGenerator();
      $report = $factory->strategyMarginArray($location);

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
