<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider providePublicUrlsAndStatusCodes
     * @group smoke
     */
    public function testPublicUrlIsSuccessful(string $url, int $statusCode): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame($statusCode);
    }

    public function providePublicUrlsAndStatusCodes(): \Generator
    {
        yield 'index' => ['/', 200];
        yield 'contact' => ['/contact', 200];
        yield 'book_index' => ['/book', 200];
        yield 'book_show' => ['/book/3', 200];
        yield 'hello' => ['/hello/Georges', 200];
        yield 'toto' => ['/toto', 404];
    }
}
