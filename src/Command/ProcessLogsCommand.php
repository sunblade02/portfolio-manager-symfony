<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:process-logs')]
class ProcessLogsCommand extends Command
{
    public function __construct(
        private \Redis $redis,
        private \MongoDB\Client $mongoClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Worker started. Waiting for logs...</info>');

        $collection = $this->mongoClient->selectCollection('portfolio_manager', 'logs');

        /** @phpstan-ignore-next-line */
        while (true) {
            // Get logs from Redis database
            $logs = $this->redis->lRange('logs', 0, -1); 
            if (!empty($logs)) {
                $decodedLogs = array_map(fn($log) => json_decode($log, true), $logs);
                // Remove logs from Redis database
                $this->redis->del('logs');
                // Insert logs into MongoDB database
                $collection->insertMany($decodedLogs);

                $output->writeln('<info>' . date('Y-m-d H:i:s') . ' : ' . count($decodedLogs) . ' log(s) inserted into MongoDB.</info>');
            } else {
                sleep(60);
            }
        }

        /** @phpstan-ignore-next-line */
        return Command::SUCCESS;
    }
}
