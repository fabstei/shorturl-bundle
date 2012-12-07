<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetUrlCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:shorturl:get')
        ->setDefinition(array(new InputArgument('token', InputArgument::REQUIRED, 'Shorturl token')))
        ->setDescription('Displays a stored redirection.')
        ->setHelp('The <info>fabstei:shorturl:get</info> command retrieves a stored redirection:
            <info>./symfony fabstei:shorturl:get</info> token');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('fabstei_shorturl.manager');
        $url = $manager->findUrlByToken($input->getArgument('token'));
        
        if($url) {
            
            $url = $url->getUrl();
            
            $output->writeln('<info>Long Url</info>: '.$url);
        } else {
            $output->writeln('<error>The Url associated with the token "'.$input->getArgument('token').'" could not be found</error>');
        }
    }

}
