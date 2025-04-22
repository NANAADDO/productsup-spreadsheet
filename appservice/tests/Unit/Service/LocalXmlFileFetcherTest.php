<?php
namespace App\Tests\Unit\Service;

use App\Application\Config\Contract\FileSourceConfigContract;
use App\Domain\Exceptions\FileNotAccessibleException;
use App\Domain\Exceptions\InvalidFileTypeException;
use App\Domain\Exceptions\NotFoundException;
use App\Infrastructure\File\Fetch\LocalXmlFileFetcher;
use PHPUnit\Framework\TestCase;

class LocalXmlFileFetcherTest extends TestCase
{
    private LocalXmlFileFetcher $fetcher;
    private $fileSourceConfigMock;
    private $fileInfoMock;
    private $fileDirectory;

    protected function setUp(): void
    {
        $this->fileSourceConfigMock = $this->createMock(FileSourceConfigContract::class);
        $this->fetcher = new LocalXmlFileFetcher();
        $this->fileDirectory = __DIR__ . '/../../Fixtures/';
    }

    public function testFetchThrowsNotFoundExceptionIfFileDoesNotExist()
    {

        $this->fileSourceConfigMock->method('getFilePath')->willReturn('/nonexistent/file.xml');


        $this->fileInfoMock = $this->createMock(\SplFileInfo::class);
        $this->fileInfoMock->method('isFile')->willReturn(false);


        $this->expectException(NotFoundException::class);
        $this->fetcher->fetch($this->fileSourceConfigMock);
    }

    public function testFetchThrowsFileNotAccessibleExceptionIfFileIsNotReadable()
    {

        $filePath = $this->fileDirectory.'malformed_sample.xml';
        chmod($filePath, 0000);
        $this->fileSourceConfigMock->method('getFilePath')->willReturn($filePath);

        $this->fileInfoMock = $this->createMock(\SplFileInfo::class);
        $this->fileInfoMock->method('isFile')->willReturn(true);
        $this->fileInfoMock->method('isReadable')->willReturn(false);

        $this->expectException(FileNotAccessibleException::class);
        $this->fetcher->fetch($this->fileSourceConfigMock);
    }

    public function testFetchThrowsInvalidFileTypeExceptionIfFileTypeIsNotXML()
    {
        $filePath = $this->fileDirectory.'sample.txt';

        $this->fileSourceConfigMock->method('getFilePath')->willReturn($filePath);

        $this->fileInfoMock = $this->createMock(\SplFileInfo::class);
        $this->fileInfoMock->method('isFile')->willReturn(true);
        $this->fileInfoMock->method('isReadable')->willReturn(true);
        $this->fileInfoMock->method('getExtension')->willReturn('txt');

        $this->expectException(InvalidFileTypeException::class);
        $this->fetcher->fetch($this->fileSourceConfigMock);
    }

    public function testFetchReturnsFileContentsIfValidFile()
    {
        $filePath = $this->fileDirectory.'coffee_feed_sample_test.xml';
        $this->fileSourceConfigMock->method('getFilePath')->willReturn($filePath);


        $this->fileInfoMock = $this->createMock(\SplFileInfo::class);
        $this->fileInfoMock->method('isFile')->willReturn(true);
        $this->fileInfoMock->method('isReadable')->willReturn(true);
        $this->fileInfoMock->method('getExtension')->willReturn('xml');


        $expectedContent = '<xml><data></data></xml>';


        $result = $this->fetcher->fetch($this->fileSourceConfigMock);

        $this->assertEquals($expectedContent, $result);
    }
}
