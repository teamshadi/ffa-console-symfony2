<?php 

require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Console\Application;


use AppBundle\Command\CashManagementCommand;
use AppBundle\Command\PnLCommand;
use AppBundle\Command\TreasuryFfa017Command;
use AppBundle\Command\SecuritiesCountriesCommand;
use AppBundle\Command\RiskAssetDetailsCommand;
use AppBundle\Command\LargesNTradesCommand;
use AppBundle\Command\AccountWithStrategyBasedMarginCommand;
use AppBundle\Command\ToptenPositionsCommand;
use AppBundle\Command\ToptenNavChangesCommand;
use AppBundle\Command\KycCommand;
use AppBundle\Command\MgapCommand;

// to run the command php ffa.php treasury:cash-management --format=email
// php ffa.php treasury:cash-management



$commandCashManagement = new CashManagementCommand();
$commandPnL = new PnLCommand();
$commandtreasuryffai007 = new TreasuryFfa017Command();
$commandSecuritiesCountries = new SecuritiesCountriesCommand();
$commandAssetDetails = new RiskAssetDetailsCommand();
$commandLargesNTrades = new LargesNTradesCommand();
$commandAccountWithStrategyBasedMargin = new AccountWithStrategyBasedMarginCommand();
$commandToptenPositions = new ToptenPositionsCommand();
$commandToptenNavChanges = new ToptenNavChangesCommand();
$commandKyc = new KycCommand();
$commandMgap = new MgapCommand();

$application = new Application();



$application->add($commandCashManagement);
$application->add($commandPnL);
$application->add($commandtreasuryffai007);
$application->add($commandSecuritiesCountries);
$application->add($commandAssetDetails);
$application->add($commandLargesNTrades);
$application->add($commandAccountWithStrategyBasedMargin);
$application->add($commandToptenPositions);
$application->add($commandToptenNavChanges);
$application->add($commandKyc);
$application->add($commandMgap);

/*
//$application->setDefaultCommand($commandCashManagement->getName());
$application->setDefaultCommand($commandPnL->getName());
$application->setDefaultCommand($commandtreasuryffai007->getName());
$application->setDefaultCommand($commandSecuritiesCountries->getName());
$application->setDefaultCommand($commandAssetDetails->getName());
$application->setDefaultCommand($commandLargesNTrades->getName());
*/

$application->run();



?>
