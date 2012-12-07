<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddUrlCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:shorturl:add')
        ->setDefinition(array(new InputArgument('longurl', InputArgument::REQUIRED, 'Long Url to be shortened.')))
        ->setDescription('Shortens a long Url.')
        ->setHelp('The <info>fabstei:shorturl:add</info> command shortens a given long Url:
            <info>./symfony fabstei:shorturl:add</info> http://example.com');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('fabstei_shorturl.manager');
        $token = $manager->addUrl($input->getArgument('longurl'));

        $output->writeln('<info>Shorturl generated</info>: '.$token);
    }

}
