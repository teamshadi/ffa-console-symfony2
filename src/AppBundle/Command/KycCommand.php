<?php

namespace AppBundle\Command;

use \FfaPhp\Common\KYCFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class KycCommand extends Command
{
  protected function configure() {
    $this
        //the name of the command (the part after "bin/console")
       ->setname('legal:kyc')

       // the short description shown while running "php bin/console list"
       ->setDescription('Kyc report.')

      //the full command description shown when running the command with
     //the "--help" option

       ->setHelp('This command allows you to get the kyc report...')


     //configure an Option
       ->addOption(
         'format',
         null,
         InputOption::VALUE_OPTIONAL,
         'console|email    how do you need the format as email or console?',
         'email'
        )       
       ->addOption(
         'emailTo',
         null,
         InputOption::VALUE_OPTIONAL,
         's.akiki@ffaprivatebank.com;everybody@ffaprivatebank.com    If set, the email will be send to the specific emails',
        'm.moawad@ffaprivatebank.com'
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
       throw new \Exception("format==email and emailTo not passed ");
      }
     
    

     $kycf = new KYCFactory();
     $kyc = $kycf->get();

    switch($format) {

      case "email":
        $emailer = new \FfaPhp\Common\Emailer($kyc,$emailTo);
        $emailer->send();
        break;
      case "quiet":
        break;
      default:
        throw new \Exception("Invalid format");
    }

  }

}
