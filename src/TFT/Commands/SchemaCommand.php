<?php

namespace TFT\Commands;

use Knp\Command\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class SchemaCommand extends Command
{
	protected function configure() 
	{
		$this
		  ->setName('schema')
		  ->setDescription('Create, truncate or drop the schema')
		  ->addArgument(
		     'operation',
		     InputArgument::REQUIRED,
		     'Type of operation (create, truncate or drop)'
		  );
	}

	protected function execute(InputInterface $input, OutputInterface $output)
    {
        $schemaOperation = $input->getArgument('operation');
        $app = $this->getSilexApplication();

        $settings = $app['config']['mysql'];
        $db = $settings['database'];

        if(strtolower($schemaOperation) == 'create')
        {
        	$link = $this->connect($settings);

        	$link->query("CREATE DATABASE IF NOT EXISTS $db");
        	$link->query("USE $db");
        	$link->query("CREATE TABLE IF NOT EXISTS user_details(disqus_user_id VARCHAR(20) PRIMARY KEY, disqus_email VARCHAR(150) NOT NULL UNIQUE)");	

        	$link->close();
        	$output->writeln('<info>Schema created successfully (It does NOT recreate tables that already exists, you can use "schema drop" to drop them first)</info>');
        }
        else if(strtolower($schemaOperation) == 'truncate')
        {
        	$link = $this->connect($settings);

			$link->query("USE $db");
        	$link->query("DELETE FROM user_details");	

        	$link->close();
        	$output->writeln('<info>Schema truncated successfully</info>');
        }
        else if(strtolower($schemaOperation) == 'drop')
        {
			$link = $this->connect($settings);

			$link->query("USE $db");
        	$link->query("DROP TABLE user_details");

        	$link->close();
        	$output->writeln('<info>Schema dropped successfully</info>');
        }
        else
        {
        	$style = new OutputFormatterStyle('white', 'red', array('bold', 'blink'));
		    $output->getFormatter()->setStyle('danger', $style);

		    $output->writeln('<danger>ERROR: The operation argument must be "create", "truncate" or "drop".</danger>');
        }
    }

    protected function connect($settings)
    {
    	return new \mysqli($settings['host'], $settings['username'], $settings['password'], null);
    }
}

