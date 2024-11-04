<?php

/*
 *
 * (c) Vincent Amstoutz <vincent.amstoutz.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Phpunit\Unit\Service;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class UserServiceTest extends TestCase
{
    private UserService $userService;

    private EntityManagerInterface&MockObject $entityManager;

    private PasswordHasherInterface&MockObject $passwordHasher;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->passwordHasher = $this->createMock(PasswordHasherInterface::class);
        $this->userService = new UserService($this->entityManager, $this->passwordHasher);
    }

    public function test_create_user(): void
    {
        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(User::class));

//        $this->entityManager
//            ->expects($this->once())
//            ->method('flush');

        $this->passwordHasher->method('hash')
            ->with('test')
            ->willReturn('hashed_test_password');

        $user = $this->userService->create('Alice', 'test');

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Alice', $user->getUsername());
        $this->assertSame('hashed_test_password', $user->getPassword());
    }
}
