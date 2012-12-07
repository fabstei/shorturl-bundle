<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUrlCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:shorturl:list')
        ->setDescription('Retrieves a list of all stored redirections.')
        ->setHelp('The <info>fabstei:shorturl:list</info> retrieves a list of all stored redirections:
            <info>./symfony fabstei:shorturl:list</info>');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('fabstei_shorturl.manager');
        $urls = $manager->findUrls();
        
        if($urls) {
            
            foreach ($urls as $url) {
                $longurl = $url->getUrl();
                $token = $url->getToken();
                $output->writeln('<info>'.$token.'</info>: '.$longurl);
            }
            
        } else {
            $output->writeln('<error>There are no redirections stored.</error>');
        }
    }

}
