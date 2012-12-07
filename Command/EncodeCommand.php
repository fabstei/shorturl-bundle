<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EncodeCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:token:encode')
        ->setDefinition(array(new InputArgument('integer', InputArgument::REQUIRED, 'Integer to be encoded.')))
        ->setDescription('Calculate a token from an integer.')
        ->setHelp('The <info>fabstei:token:encode</info> command creates a token from an integer:
            <info>./symfony fabstei:token:encode</info> integer');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tokenizer = $this->getContainer()->get('fabstei_shorturl.tokenizer');
        $token = $tokenizer->encode($input->getArgument('integer'));

        $output->writeln('<info>Generated token</info>: '.$token);
    }

}
