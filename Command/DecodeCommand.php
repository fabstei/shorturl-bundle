<?php

namespace Fabstei\ShorturlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DecodeCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
        ->setName('fabstei:token:decode')
        ->setDefinition(array(new InputArgument('token', InputArgument::REQUIRED, 'Token to be decoded.')))
        ->setDescription('Calculate an integer from a token.')
        ->setHelp('The <info>fabstei:token:decode</info> command calculates the integer from a token:
            <info>./symfony fabstei:token:decode</info> token');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tokenizer = $this->getContainer()->get('fabstei_shorturl.tokenizer');
        $integer = $tokenizer->decode($input->getArgument('token'));

        $output->writeln('<info>Calculated integer</info>: '.$integer);
    }

}
