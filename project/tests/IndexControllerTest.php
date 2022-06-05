<?php

namespace App\Tests;

use App\Service\Calculator\Operations;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class IndexControllerTest extends WebTestCase
{
    public function testFormSubmit(): void
    {
        $client = static::createClient();

        foreach (TestCases::$DATA as $testCase) {
            $result = $this->retrieveResult($client, $testCase['valueA'], $testCase['valueB'], $testCase['operation']);
            self::assertEquals($testCase['expected'], $result);
        }
    }

    public function testExpectErrorOnDivisionByZero(): void
    {
        $client = static::createClient();
        $crawler = $this->submitForm($client, 5, 0, Operations::Divide);
        $error = $crawler->filter('div.invalid-feedback')->text();

        self::assertEquals('Division by zero.', $error);
    }

    private function submitForm(KernelBrowser $client, float $valueA, float $valueB, Operations $op) : Crawler
    {
        $crawler = $client->request('GET', '/');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form();

        return $client->submit($form, [
            'calculator[valueA]' => $valueA,
            'calculator[valueB]' => $valueB,
            'calculator[operation]' => $op->value
        ]);
    }

    private function retrieveResult(KernelBrowser $client, float $valueA, float $valueB, Operations $op) : string
    {
        return $this->submitForm($client, $valueA, $valueB, $op)->filter('#result')->text();
    }
}
