<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context;

use Behat\Behat\Context\Context;
use Behat\Mink\Session;
use PHPUnit\Framework\Assert;
use RuntimeException;

final class ApiReadyContext implements Context
{
    public function __construct(private Session $session)
    {
    }

    /**
     * @When I make a request to :routePath
     */
    public function iMakeARequestTo(string $routePath): void
    {
        $this->session->visit($routePath);
    }

    /**
     * @Then I should have a response
     */
    public function iShouldHaveAResponse(): void
    {
        $responseCode = $this->session->getStatusCode();
        if ($responseCode !== 200) {
            throw new RuntimeException("Error loading page!");
        }
    }

    /**
     * @Then The response should be show the ready message
     */
    public function theResponseShouldBeShowTheReadyMessage(): void
    {
        $response = $this->session->getDriver()->getContent();
        $expectedResponse = json_encode(['ready' => true]);
        Assert::assertEquals($expectedResponse, $response);
    }
}
