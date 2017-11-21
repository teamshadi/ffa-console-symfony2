<?php

namespace AppBundle\Command;
use \FfaPhp\Common\Ffa017Factory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;


class TreasuryFfa017Command extends Command
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
                

                   //configure an Option
                     ->addOption(
                       'format',
                       null,
                       InputOption::VALUE_OPTIONAL,
                       'how do you need the format as email or console?',
                       'console'
                      )       
                     ->addOption(
                       'dd',
                       null,
                       InputOption::VALUE_OPTIONAL,
                      '2017-04-04  the date of the report',
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
           $dd=$input->getOption('dd'); 
           $base=$input->getOption('base');
           $location=$input->getOption('location'); 
           
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
             $emailTo = $je->getEmails("Cash Management");
            }
            //get cash
           $dd = \DateTime::createFromFormat("!Y-m-d",$dd);
           $options=array('dd'=>$dd,'location'=>$location,'base'=>$base);
           $cash = new \FfaPhp\Cash\Cash($options);

           $factory = new \FfaPhp\Common\Ffa017Factory($cash);
           $report = $factory->generate($dd,['FFA017']);
          
            // output
           switch($format) {
             case "html":
               $report->toHtmlExtended();
               break;
 						 case "console":
   						 $report->toConsole();
   						 break;
             case "email":
               $emailer = new \FfaPhp\Common\Emailer($report, $emailTo);
   						 $emailer->send();
   						 break;
					   case "quiet":
   						 break;
 						 default:
   						 throw new Exception(sprintf("Invalid format: %s",$format));
						 }

                    
                                      
                                        
                                            
          }
} 
?>
