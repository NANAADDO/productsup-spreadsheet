<?php

namespace App\Tests\Unit\Service;

use App\Application\Config\Contract\ExternalFeedSourceConfigContract;
use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\Http\Contract\HttpClientContract;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\UnauthorizedException;
use App\Infrastructure\File\Fetch\RemoteXmlFetcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RemoteXmlFetcherTest extends TestCase
{
    private MockObject $externalConfigMock;
    private MockObject $fileSourceConfigMock;
    private MockObject $curlClientMock;
    private RemoteXmlFetcher $fetcher;

    protected function setUp(): void
    {
        $this->externalConfigMock = $this->createMock(ExternalFeedSourceConfigContract::class);
        $this->fileSourceConfigMock = $this->createMock(FileSourceConfigContract::class);
        $this->curlClientMock = $this->createMock(HttpClientContract::class);

        $this->fetcher = new RemoteXmlFetcher(
            $this->externalConfigMock,
            $this->curlClientMock
        );
    }

    public function testFetchReturnsXmlContent(): void
    {
        $this->externalConfigMock->method('getHost')->willReturn('https://remote.com');
        $this->externalConfigMock->method('getUsername')->willReturn('user');
        $this->externalConfigMock->method('getPassword')->willReturn('pass');
        $this->fileSourceConfigMock->method('getFileName')->willReturn('data.xml');

        $this->curlClientMock->method('get')
            ->willReturn('<xml><foo>bar</foo></xml>');

        $result = $this->fetcher->fetch($this->fileSourceConfigMock);

        $this->assertStringContainsString('<foo>bar</foo>', $result);
    }

    public function testFetchThrowsUnauthorizedException(): void
    {
        $this->externalConfigMock->method('getHost')->willReturn('https://remote.com');
        $this->externalConfigMock->method('getUsername')->willReturn('user');
        $this->externalConfigMock->method('getPassword')->willReturn('wrongpass');
        $this->fileSourceConfigMock->method('getFileName')->willReturn('data.xml');

        $this->curlClientMock->method('get')
            ->willThrowException(new UnauthorizedException('Access denied'));

        $this->expectException(UnauthorizedException::class);

        $this->fetcher->fetch($this->fileSourceConfigMock);
    }

    public function testFetchThrowsNotFoundException(): void
    {
        $this->externalConfigMock->method('getHost')->willReturn('https://remote.com');
        $this->externalConfigMock->method('getUsername')->willReturn('user');
        $this->externalConfigMock->method('getPassword')->willReturn('pass');
        $this->fileSourceConfigMock->method('getFileName')->willReturn('missing.xml');

        $this->curlClientMock->method('get')
            ->willThrowException(new NotFoundException());

        $this->expectException(NotFoundException::class);

        $this->fetcher->fetch($this->fileSourceConfigMock);
    }
}
