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
use App\Service\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    private EntityManagerInterface&MockObject $entityManager;

    private PasswordHasherInterface&MockObject $passwordHasher;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class); // bad practice only for demo
        $this->passwordHasher = $this->createMock(PasswordHasherInterface::class); // bad practice only for demo
        $this->userRepository = new UserRepository($this->entityManager, $this->passwordHasher); // bad practice only for demo
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

        $user = $this->userRepository->create('Alice', 'test');

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Alice', $user->getUsername());
        $this->assertSame('hashed_test_password', $user->getPassword());
    }
}
