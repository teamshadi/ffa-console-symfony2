<?php

namespace AppBundle\Command;

# require_once  __DIR__.'/../findAutoload.php';

use TreasuryFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class CashManagementCommand extends ContainerAwareCommand
{
protected function configure()
          { $this
                      //the name of the command (the part after "bin/console")
                     ->setname('treasury:cash-management')

                     // the short description shown while running "php bin/console list"
                     ->setDescription('cash managament report.')

                    //the full command description shown when running the command with
                   //the "--help" option
                                                                             
                     ->setHelp('This command allows you to get the cash management report...')
                

                   //configure an argument
                     ->addArgument('format', InputArgument::OPTIONAL, 'how do you need the format as email or console?')           
                     ->addArgument('dd', InputArgument::OPTIONAL, 'the date of the report')
                     ->addArgument('emailTo',InputArgument::OPTIONAL,'If set, the email will be send to the specific emails')
                   ;

                     
           }
protected function execute(InputInterface $input, OutputInterface $output){


###################
$format="console";
                                        
$emailTo=null; # "s.akiki@ffaprivatebank.com";
#$dd=date("Y-m-d");
$dd=date("Y-m-d",strtotime('yesterday')); # default

# If using from CLI
if(isset($argc)) parse_str(implode('&', array_slice($argv, 1)), $_GET);

if(array_key_exists("help",$_GET)) {
  echo("Usage: php ".basename(__FILE__)." format=console\n");
  echo("       php ".basename(__FILE__)." format=console dd=2015-02-03\n");
  echo("       php ".basename(__FILE__)." format=email # This will get email recipients from a ffa-jobs-emails server (https://github.com/minerva22/ffa-jobs-emails)\n");
  echo("       php ".basename(__FILE__)." emailTo='s.akiki@ffaprivatebank.com'\n");
  echo("       php ".basename(__FILE__)." emailTo='s.akiki@ffaprivatebank.com;shadiakiki1986@gmail.com'\n");
  exit;
}

if(array_key_exists("dd",$_GET)) $dd=$_GET["dd"];
if(array_key_exists("format",$_GET)) $format=$_GET["format"];
if(array_key_exists("emailTo",$_GET)) {
  $emailTo=$_GET["emailTo"];
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
  $je = new \FfaJobsEmails\JobsEmails($url);
  $emailTo = $je->getEmails("Cash Management");
}

$dd = \DateTime::createFromFormat("!Y-m-d",$dd);

#####################
assert_options(ASSERT_BAIL,true); // to fail on failed asserts instead of just issuing a warning
$factory = new TreasuryFactory();
$report = $factory->cashManagement($dd);

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
    throw new Exception("Invalid format");
}

          }
} 
?>
