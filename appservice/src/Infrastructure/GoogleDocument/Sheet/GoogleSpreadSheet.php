<?php

namespace App\Infrastructure\GoogleDocument\Sheet;

use App\Application\Cache\Contract\CacheContract;
use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\Config\Contract\GoogleSheetConfigContract;
use App\Application\GoogleDocument\Sheet\Contract\GoogleSpreadsheetContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetCreatorContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetWriterContract;
use App\Shared\Util\SheetNameHelper;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(GoogleSpreadsheetContract::class)]
class GoogleSpreadSheet implements GoogleSpreadsheetContract
{
    private string $spreadSheetId;

    public function __construct(
        private CacheContract $redisCache,
        private GoogleSheetConfigContract $googleSheetEnvConfig,
        private FileSourceConfigContract $fileSourceEnvConfig,
        private SheetWriterContract $sheetWriter,
        private SheetCreatorContract $sheetCreator
    ) {
    }

    public function process($data): string
    {
        $sheetEnvID = $this->googleSheetEnvConfig->getSheetID();

        if (!empty($sheetEnvID)) {
            $sheetID = $sheetEnvID;
        } else {
            $sheetName = SheetNameHelper::getSheetName($this->fileSourceEnvConfig->getClientName(), $this->fileSourceEnvConfig->getFileName());

            if ($this->redisCache->verifyCacheHasData($sheetName)) {
                $sheetID = trim($this->redisCache->getCacheData($sheetName), '"');
            } else {
                $sheetID = $this->sheetCreator->create($sheetName);
                $this->redisCache->setCacheData($sheetName, $sheetID, 15000);
            }
        }

        $this->sheetWriter->write($sheetID, 'Sheet1!A1', $data);

        return $sheetID;
    }

}
