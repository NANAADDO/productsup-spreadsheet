<?php

namespace App\Tests\Unit\Integration\Console;

use App\Adapters\Console\ProcessXmlToSheetsCommand;
use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\File\Contract\FileSaverContract;
use App\Application\File\Factory\FileFetcherFactory;
use App\Application\GoogleDocument\Sheet\Service\GoogleSpreadSheetService;
use App\Application\Logger\Contract\LoggerContract;
use App\Application\Parser\Contract\XmlParserContract;
use App\Application\Product\Contract\ProductFactoryContract;
use App\Domain\Entities\Product\Productsup\CoffeeFeed;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ProcessXmlToSheetsCommandTest extends TestCase
{
    public function testExecuteRunsSuccessfully()
    {
        $fileFetcherFactoryMock = $this->createMock(FileFetcherFactory::class);
        $fileSourceConfigMock = $this->createMock(FileSourceConfigContract::class);
        $xmlParserMock = $this->createMock(XmlParserContract::class);
        $productFactoryMock = $this->createMock(ProductFactoryContract::class);
        $spreadsheetServiceMock = $this->createMock(GoogleSpreadSheetService::class);
        $loggerMock = $this->createMock(LoggerContract::class);
        $fileSaverMock = $this->createMock(FileSaverContract::class);

        $dummyXml = '<root><item><sku>123</sku><name>Test Product</name></item></root>';
        $parsedArray = ['item' => [['sku' => '123', 'name' => 'Test Product']]];
        $coffeeFeed = new CoffeeFeed(
            entityId: '',
            categoryName: '',
            sku: '123',
            name: 'Test Product',
            description: '',
            shortDescription: '',
            price: 0.0,
            link: '',
            image: '',
            brand: '',
            rating: 0,
            caffeineType: '',
            count: 0,
            flavored: false,
            seasonal: false,
            inStock: false
        );

        $fileSourceConfigMock->method('getFileSource')->willReturn('local');
        $fileFetcherMock = $this->getMockBuilder(\App\Application\File\Contract\FileFetcherContract::class)->getMock();
        $fileFetcherMock->method('fetch')->willReturn($dummyXml);

        $fileFetcherFactoryMock->method('create')->willReturn($fileFetcherMock);
        $xmlParserMock->method('parse')->willReturn($parsedArray);
        $productFactoryMock->method('createFromArray')->willReturn([$coffeeFeed]);
        $spreadsheetServiceMock->method('processDataAndWriteToSheet')->willReturn('sheet-id');

        $application = new Application();
        $command = new ProcessXmlToSheetsCommand(
            $fileFetcherFactoryMock,
            $fileSourceConfigMock,
            $xmlParserMock,
            $productFactoryMock,
            $spreadsheetServiceMock,
            $loggerMock,
            $fileSaverMock
        );
        $application->add($command);

        $commandTester = new CommandTester($application->find('sync:xml-to-sheets'));

        $exitCode = $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        $this->assertEquals(0, $exitCode);
        $this->assertStringContainsString('Data successfully pushed to Google Sheets.', $output);
        $this->assertStringContainsString('https://docs.google.com/spreadsheets/d/sheet-id', $output);
    }
}
