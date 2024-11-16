<?php

namespace App\Traits;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

trait TracksProgress
{
    /**
     * Creates and returns a progress bar.
     *
     * @param int $total
     * @return ProgressBar
     */
    public function createProgressBar(int $total): ProgressBar
    {
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $total);

        $progressBar->start();

        return $progressBar;
    }

    /**
     * Advances the progress bar and finishes it when done.
     *
     * @param ProgressBar $progressBar
     */
    public function finishProgressBar(ProgressBar $progressBar): void
    {
        $progressBar->finish();
        (new ConsoleOutput())->writeln("\nSeeding completed successfully!");
    }
}
