<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\Character\Professions;

use Behat\Behat\Tester\Exception\PendingException;
use App\User\Domain\UserRepository;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Behat\Behat\Context\Context;
use Faker\Factory;
use Faker\Generator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class ProfessionNamesContext implements Context
{
    private readonly Generator $generator;
    private Response $response;
    private string $token = '';

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly UserRepository $userRepository,
        private readonly JWTTokenManagerInterface $tokenManager,
        private readonly JWTEncoderInterface $encoder
    ) {
        $this->generator = Factory::create();
    }
    /**
     * @Given A anon user
     */
    public function aAnonUser(): void
    {
    }

    /**
     * @When I check endpoint :route with :method
     */
    public function iCheckEndpointWith(string $route, string $method): void
    {
        $headers = [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ];
        if ($this->token) {
            $claims = $this->tokenManager->parse($this->token);
            $headers['HTTP_Authorization'] = sprintf('Bearer %s', $this->encoder->encode($claims));
        }

        $request = Request::create(
            $route,
            $method,
            [],
            [],
            [],
            $headers
        );
        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Then I should get an unauthorized response
     */
    public function iShouldGetAnUnauthorizedResponse(): void
    {
        Assert::assertEquals(Response::HTTP_UNAUTHORIZED, $this->response->getStatusCode());
    }

    /**
     * @Given A authorized user
     */
    public function aAuthorizedUser(): void
    {
        $userName = $this->generator->userName();
        $email = $this->generator->email();
        $password = 'veryDifficultPassword';
        $user = new DoctrineUser(
            email: $email,
            username: $userName,
            password: $password,
            roles: ['ROLE_USER'],
            resetPasswordToken: null,
            resetPasswordRequestedAt: null
        );
        $this->userRepository->store($user);
        $this->token = $this->tokenManager->create($user);
    }

    /**
     * @Then I should get profession names response
     */
    public function iShouldGetProfessionNamesResponse(): void
    {
        $content = $this->response->getContent();
        Assert::assertEquals(Response::HTTP_OK, $this->response->getStatusCode());
        $content = $content ? $content : '';
        $parsedResponse = json_decode($content, true, JSON_THROW_ON_ERROR);
        $expectedResult = [
            ["code" => "cleric", "name" =>  "Cleric"],
            ["code" => "fighter", "name" =>  "Fighter"],
            ["code" => "harper", "name" =>  "Harper"],
            ["code" => "mage", "name" =>  "Mage"],
            ["code" => "monk", "name" =>  "Monk"],
            ["code" => "ranger", "name" =>  "Ranger"],
            ["code" => "rogue", "name" =>  "Rogue"],
            ["code" => "thief", "name" =>  "Thief"],
            ["code" => "warriorMage", "name" =>  "Warrior Mage"]
        ];
        Assert::assertEqualsCanonicalizing($expectedResult, $parsedResponse);
    }

    /**
     * @Then I should get profession data response
     */
    public function iShouldGetProfessionDataResponse(): void
    {
        Assert::assertEquals(Response::HTTP_OK, $this->response->getStatusCode());
    }

    /**
     * @Then I should get an not-found code
     */
    public function iShouldGetAnNotFoundCode(): void
    {
        Assert::assertEquals(Response::HTTP_BAD_REQUEST, $this->response->getStatusCode());
    }
}
