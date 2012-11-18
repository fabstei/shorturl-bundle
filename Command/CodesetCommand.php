<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CodesetCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:shorturl:codeset')
        ->setDefinition(array())
        ->setDescription('Return the codeset used.')
        ->setHelp('The <info>fabstei:shorturl:codeset</info> command returns the codeset used:
            <info>./symfony fabstei:shorturl:codeset</info>');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tokenizer = $this->getContainer()->get('fabstei_shorturl.tokenizer');
        $codeset = $tokenizer->getCodeset();

        $output->writeln('<info>Codeset used</info>: '.$codeset);
    }

}
