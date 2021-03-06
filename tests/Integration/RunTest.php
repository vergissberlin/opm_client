<?php
namespace Whm\Opm\Client\Test\Integration;

use Whm\Opm\Client\Command\Run;
use Symfony\Component\Console\Tester\CommandTester;

class RunTest extends CommandTest
{

    public function testRunCommand ()
    {
        $application = $this->getApplication();
        $application->add(new Run());
        $command = $application->find('run');
        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => $command->getName(),'--dryrun' => true));

        $expectedOutput[] = "bin/client.php messure 1id Opm:HttpArchive 'a:1:{s:3:\"url\";s:20:\"http://www.google.de\";}' --config";
        $expectedOutput[] = "bin/client.php messure 2id Opm:HttpArchive 'a:1:{s:3:\"url\";s:20:\"http://www.yahoo.com\";}' --config";

        $result = $commandTester->getDisplay(true);

        foreach ($expectedOutput as $line) {
            $pos = strpos($result, $line);
            if ($pos === false) {
                $this->assertTrue(false, "Command output does not match expected outut.\nExpected: ". $line."\nCurrent: ".$result);
            }
        }
    }
}
