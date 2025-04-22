<?php

namespace App\Tests\Unit\Service\GoogleDocument\SpreadSheet;

use App\Application\Cache\Contract\CacheContract;
use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\Config\Contract\GoogleSheetConfigContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetCreatorContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetWriterContract;
use App\Infrastructure\GoogleDocument\Sheet\GoogleSpreadSheet;
use App\Shared\Util\SheetNameHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GoogleSpreadSheetTest extends TestCase
{
    private MockObject $redisCacheMock;
    private MockObject $googleSheetEnvConfigMock;
    private MockObject $fileSourceEnvConfigMock;
    private MockObject $sheetWriterMock;
    private MockObject $sheetCreatorMock;
    private GoogleSpreadSheet $googleSpreadSheet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->redisCacheMock = $this->createMock(CacheContract::class);
        $this->googleSheetEnvConfigMock = $this->createMock(GoogleSheetConfigContract::class);
        $this->fileSourceEnvConfigMock = $this->createMock(FileSourceConfigContract::class);
        $this->sheetWriterMock = $this->createMock(SheetWriterContract::class);
        $this->sheetCreatorMock = $this->createMock(SheetCreatorContract::class);

        $this->googleSpreadSheet = new GoogleSpreadSheet(
            $this->redisCacheMock,
            $this->googleSheetEnvConfigMock,
            $this->fileSourceEnvConfigMock,
            $this->sheetWriterMock,
            $this->sheetCreatorMock
        );
    }

    public function testProcessUsesProvidedSheetId(): void
    {
        $sheetId = 'existing-sheet-id';
        $data = [['name' => 'Product A', 'price' => 100]];

        $this->googleSheetEnvConfigMock
            ->method('getSheetID')
            ->willReturn($sheetId);

        $this->sheetWriterMock
            ->expects($this->once())
            ->method('write')
            ->with($sheetId, 'Sheet1!A1', $data);

        $result = $this->googleSpreadSheet->process($data);

        $this->assertEquals($sheetId, $result);
    }

    public function testProcessCreatesNewSheetIfNotSheetIdProvided(): void
    {
        $newSheetId = 'new-sheet-id';
        $data = [['name' => 'Product A', 'price' => 100]];

        $this->googleSheetEnvConfigMock
            ->method('getSheetID')
            ->willReturn('');

        $this->fileSourceEnvConfigMock
            ->method('getClientName')
            ->willReturn('Client');

        $this->fileSourceEnvConfigMock
            ->method('getFileName')
            ->willReturn('feed.xml');

        $expectedSheetName = SheetNameHelper::getSheetName(
            $this->fileSourceEnvConfigMock->getClientName(),
            $this->fileSourceEnvConfigMock->getFileName()
        );

        $this->redisCacheMock
            ->method('verifyCacheHasData')
            ->willReturn(false);

        $this->sheetCreatorMock
            ->expects($this->once())
            ->method('create')
            ->with($expectedSheetName)
            ->willReturn($newSheetId);

        $this->redisCacheMock
            ->expects($this->once())
            ->method('setCacheData')
            ->with($expectedSheetName, $newSheetId, 15000);

        $this->sheetWriterMock
            ->expects($this->once())
            ->method('write')
            ->with($newSheetId, 'Sheet1!A1', $data);

        $result = $this->googleSpreadSheet->process($data);

        $this->assertEquals($newSheetId, $result);
    }

    public function testProcessWritesToSheet(): void
    {
        $sheetId = 'existing-sheet-id';
        $data = [['name' => 'Product A', 'price' => 100]];

        $this->googleSheetEnvConfigMock
            ->method('getSheetID')
            ->willReturn($sheetId);

        $this->sheetWriterMock
            ->expects($this->once())
            ->method('write')
            ->with($sheetId, 'Sheet1!A1', $data);

        $this->googleSpreadSheet->process($data);
    }
}
