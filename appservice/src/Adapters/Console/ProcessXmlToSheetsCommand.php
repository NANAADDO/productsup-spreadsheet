<?php

namespace App\Adapters\Console;

use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\File\Contract\FileSaverContract;
use App\Application\File\Factory\FileFetcherFactory;
use App\Application\GoogleDocument\Sheet\Service\GoogleSpreadSheetService;
use App\Application\Logger\Contract\LoggerContract;
use App\Application\Parser\Contract\XmlParserContract;
use App\Application\Product\Contract\ProductFactoryContract;
use App\Domain\Entities\Product\Productsup\CoffeeFeed;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'sync:xml-to-sheets',
    description: 'Processes a local or remote XML file and syncs its data to a Google Sheet'
)]
class ProcessXmlToSheetsCommand extends Command
{
    protected static $defaultName = 'sync:xml-to-sheets';
    public function __construct(
        private readonly FileFetcherFactory $fileFetcherFactory,
        private readonly  FileSourceConfigContract                       $fileSourceConfig,
        private readonly  XmlParserContract                              $simpleXmlParser,
        private readonly ProductFactoryContract                          $productFactory,
        private readonly GoogleSpreadSheetService                         $googleSpreadSheetService,
        private readonly LoggerContract                                  $monologger,
        private readonly FileSaverContract                               $fileSaver
    ) {
        parent::__construct();

    }

    protected function configure(): void
    {
        $this
            ->addArgument('fileSource', InputArgument::OPTIONAL, 'The username');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fileSource = $input->getArgument('fileSource') ?? $this->fileSourceConfig->getFileSource();

        try {
            $io->info("Starting file fetch from source: {$fileSource}");
            $fetcher = $this->fileFetcherFactory->create($fileSource);
            $xmlContent = $fetcher->fetch($this->fileSourceConfig);
            if ($this->fileSourceConfig->getFileSource() == 'remote') {
                $io->info('Saving XML content into local storage..');
                $this->fileSaver->save($xmlContent);
            }

            $io->success('File fetched and validated successfully.');

            $io->info('Parsing XML content...');
            $simpleXmlParserContent = $this->simpleXmlParser->parse($xmlContent);

            $io->info('Transforming data into sheet-compatible structure...');
            $data = $this->productFactory->createFromArray($simpleXmlParserContent);
            $sheetData = array_map(fn (CoffeeFeed $product) => $product->toArray(), $data);

            $io->info('Pushing data to Google Sheets...');
            $sheetID = $this->googleSpreadSheetService->processDataAndWriteToSheet($sheetData);
            $io->success('Data successfully pushed to Google Sheets.');
            $io->info("View the sheet here: https://docs.google.com/spreadsheets/d/{$sheetID}");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->monologger->Error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
