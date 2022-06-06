<?php

namespace App\Tests;

use App\Service\Calculator\Operations;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class IndexControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testFormSubmit(): void
    {
        foreach (TestCases::$DATA as $testCase) {
            $result = $this->retrieveResult($testCase['valueA'], $testCase['valueB'], $testCase['operation']);
            self::assertEquals($testCase['expected'], $result);
        }
    }

    public function testExpectErrorOnDivisionByZero(): void
    {
        $crawler = $this->submitForm(5, 0, Operations::Divide);
        $error = $crawler->filter('div.invalid-feedback')->text();

        self::assertEquals('Division by zero.', $error);
    }

    private function submitForm(float $valueA, float $valueB, Operations $op) : Crawler
    {
        $crawler = $this->client->request('GET', '/');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form();

        return $this->client->submit($form, [
            'calculator[valueA]' => $valueA,
            'calculator[valueB]' => $valueB,
            'calculator[operation]' => $op->value
        ]);
    }

    private function retrieveResult(float $valueA, float $valueB, Operations $op) : string
    {
        return $this->submitForm($valueA, $valueB, $op)->filter('#result')->text();
    }
}
