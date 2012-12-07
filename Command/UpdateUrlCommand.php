<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUrlCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:shorturl:update')
        ->setDefinition(array(
            new InputArgument('token', InputArgument::REQUIRED, 'Token for which the Url should be updated.'),
            new InputArgument('longurl', InputArgument::OPTIONAL, 'Long Url which should be stored.'),
            new InputOption('token', null, InputOption::VALUE_REQUIRED, 'Customize the token')
        ))
        ->setDescription('Shortens a long Url.')
        ->setHelp('The <info>fabstei:shorturl:update</info> command updates a given token with a new Url:
            <info>./symfony fabstei:shorturl:update</info> token http://example.com');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager  = $this->getContainer()->get('fabstei_shorturl.manager');
        $longurl  = $input->getArgument('longurl');
        $token    = $input->getArgument('token');
        $newToken = $input->getOption('token');
        
        if(isset($longurl)) {
            $updated_longurl = $manager->updateLongUrl($token, $longurl);
        }
        
        if(isset($newToken)) {
            try {
                $updated_token = $manager->updateToken($token, $newToken);
            } catch (\Doctrine\DBAL\DBALException $e) {
                $output->writeln('<error>The token exists already and could not be set</error>');
            }           
        }
        
        if(isset($updated_longurl)) {
            if($updated_longurl == true) {
                $output->writeln('<info>Shorturl "'.$input->getArgument('token').' updated. New Url"</info>: '.$longurl);
            }
        }
        
        if(isset($updated_token)) {        
            if($updated_token == true) {
                $output->writeln('<info>Shorturl "'.$input->getArgument('token').' updated. New Token"</info>: '.$newToken);
            }
        }
        
        if(isset($updated_longurl) && isset($updated_token)) {
            if($updated_longurl && $updated_token == false) {
            $output->writeln('<error>Redirection could not be found.</error>');
            }
        }
            
        if(!isset($updated_longurl) && !isset($updated_token)) {
            $output->writeln('<error>Not enough arguments supplied.</error>');
        }
        
    }

}
