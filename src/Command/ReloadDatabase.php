<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ReloadDatabase extends Command
{
    public const LINE="===================================================";

    /**
     * Cmd : php bin/console app:ReloadDB
     */
    protected function configure():void
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:ReloadDB')

            // the short description shown while running "php bin/console list"
            ->setDescription('Drop/Create Database and load Fixtures ....')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to load dummy data by recreating database and loading fixtures...');
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $application = $this->getApplication();

        $application->setAutoExit(false);

        $output->writeln([
            self::LINE,
            '*********        Dropping DataBase        *********',
            self::LINE,
            '',
        ]);

//        $options = array('command' => 'doctrine:database:drop',"--force" => true);
//        $application->run(new ArrayInput($options));

        $this->RunCmd($application,array('command' => 'doctrine:database:drop',"--force" => true));

        $output->writeln([
            self::LINE,
            '*********        Creating DataBase        *********',
            self::LINE,
            '',
        ]);

//        $options = array('command' => 'doctrine:database:create',"--if-not-exists" => true);
//        $application->run(new ArrayInput($options));

        $this->RunCmd($application,array('command' => 'doctrine:database:create',"--if-not-exists" => true));


        $output->writeln([
            self::LINE,
            '*********         Updating Schema         *********',
            self::LINE,
            '',
        ]);


        $this->RunCmd($application,array('command' => 'doctrine:schema:update',"--force" => true));


        $output->writeln([
            self::LINE,
            '*********          Load Fixtures          *********',
            self::LINE,
            '',
        ]);


        $this->RunCmd($application,array('command' => 'doctrine:fixtures:load',"--no-interaction" => true));


        return 0;
    }

    public function RunCmd($application,array $options): void
    {
        $application->run(new ArrayInput($options));
    }
}