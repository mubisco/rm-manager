<?php

namespace App\Tests\acceptance\User;

use App\User\Domain\Username;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordAcceptanceTest extends WebTestCase
{
    private KernelBrowser $client;

    /** @test */
    public function asUserIWantToResetMyPassword(): void
    {
        $this->givenAResetPasswordRequest();
        $this->whenUserRequestedExists();
        $this->thenIShouldReceiveA200Response();
        $this->andUserHasResetPasswordToken();
    }
    /** @test */
    public function asEmptyUserIWantToResetMyPassword(): void
    {
        $this->givenAResetPasswordRequest();
        $this->whenRequestIsEmpty();
        $this->thenIShouldReceiveA400Response();
    }
    /** @test */
    public function asNonExistantUserIWantToResetMyPassword(): void
    {
        $this->givenAResetPasswordRequest();
        $this->whenUserRequestedDoesNotExist();
        $this->thenIShouldReceiveA404Response();
    }

    private function givenAResetPasswordRequest(): void
    {
        $this->client = self::createClient();
    }
    private function whenUserRequestedExists(): void
    {
        $this->buildRequest(['username' => 'existinguser']);
    }
    private function thenIShouldReceiveA200Response(): void
    {
        $this->assertResponseCode(200);
    }
    private function andUserHasResetPasswordToken(): void
    {
        $repository = $this->client->getContainer()->get('test.userRepository');
        /** @var DoctrineUser */
        $user = $repository->byUsername(new Username('existinguser'));
        $this->assertNotEmpty($user->passwordResetToken());
    }

    private function whenRequestIsEmpty(): void
    {
        $this->buildRequest(null);
    }
    private function thenIShouldReceiveA400Response(): void
    {
        $this->assertResponseCode(400);
    }

    private function whenUserRequestedDoesNotExist(): void
    {
        $this->buildRequest(['username' => 'notexistantuser']);
    }

    private function buildRequest(?array $content): void
    {
        $this->client->request(
            'PUT',
            '/api/user/reset-password',
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            $content === null ? null : json_encode($content)
        );
    }

    private function thenIShouldReceiveA404Response(): void
    {
        $this->assertResponseCode(404);
    }

    private function assertResponseCode(int $responseCode): void
    {
        $this->client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame($responseCode);
    }
}
