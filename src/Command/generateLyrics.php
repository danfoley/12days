<?php
namespace TwelveDays\Command;

use NumberFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class generateLyrics extends Command
{
    protected static $defaultName = 'generate-lyrics';

    private const PRESENTS = [
        'a partridge in a pear tree',
        'turtle doves',
        'French hens',
        'calling birds',
        'golden rings',
        'geese a laying',
        'swans a swimming',
        'maids a milking',
        'ladies dancing',
        'lords a leaping',
        'pipers piping',
        'drummers drumming'
    ];

    private const FIRST_LYRIC = 'On the %s day of Christmas my true love gave to me:';

    protected function configure(): void
    {
        $this->setDescription('Output the lyrics of the 12 days of Christmas');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->generateLyrics($output);
        return Command::SUCCESS;
    }

    private function generateLyrics(OutputInterface $output) {
        $presents_given = [];
        $lyric_line = [];

        $formatter = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
        $ordinal_formatter = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
        $ordinal_formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, '%spellout-ordinal');

        for ($i = 0; $i < 12; $i++) {
            
            $number = $formatter->format($i+1);
            $number_ordinal = $ordinal_formatter->format($i+1);
            $first_lyric = sprintf(self::FIRST_LYRIC, $number_ordinal);

            if ($i === 0) {
                $lyric_lines[] = sprintf('%s %s', $first_lyric, self::PRESENTS[$i]);
                $presents_given[] = sprintf('and %s', self::PRESENTS[$i]);
                continue;
            }
            
            array_unshift($presents_given, sprintf('%s %s', $number, self::PRESENTS[$i]));
            $lyric_lines[] = sprintf('%s %s',$first_lyric, implode(', ', $presents_given));
        }
        
        foreach ($lyric_lines as $line) {
            $output->writeln($line);
        }
    }
}