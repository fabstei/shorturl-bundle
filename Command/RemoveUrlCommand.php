<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveUrlCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:shorturl:remove')
        ->setDefinition(array(new InputArgument('token', InputArgument::REQUIRED, 'Redirection to be removed.')))
        ->setDescription('Removes a stored redirection.')
        ->setHelp('The <info>fabstei:shorturl:remove</info> command removes a stored redirection:
            <info>./symfony fabstei:shorturl:remove</info> token');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('fabstei_shorturl.manager');
        $deleted = $manager->removeUrl($input->getArgument('token'));
        
        if($deleted === true) {
            $output->writeln('<info>Shorturl "'.$input->getArgument('token').'" removed</info>');
        } else {
            $output->writeln('<error>Shorturl "'.$input->getArgument('token').'" could not be found</error>');
        }
    }

}
