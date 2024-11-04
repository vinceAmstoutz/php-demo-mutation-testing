<?php

/*
 *
 * (c) Vincent Amstoutz <vincent.amstoutz.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

mutates(UserService::class);

beforeEach(function (): void {
    $this->entityManager = Mockery::mock(EntityManagerInterface::class);
    $this->passwordHasher = Mockery::mock(PasswordHasherInterface::class);
    $this->userService = new UserService($this->entityManager, $this->passwordHasher);
});

it('creates a user', function (): void {
    $this->entityManager
        ->shouldReceive('persist')
        ->once()
        ->with(Mockery::type(User::class));

    $this->entityManager
        ->shouldReceive('flush')
//        ->once()
    ;

    $this->passwordHasher
        ->shouldReceive('hash')
        ->with('test')
        ->andReturn('hashed_test_password');

    $user = $this->userService->create('Alice', 'test');

    expect($user)->toBeInstanceOf(User::class);
    expect($user->getUsername())->toBe('Alice');
    expect($user->getPassword())->toBe('hashed_test_password');
});

afterEach(function (): void {
    Mockery::close();
});
