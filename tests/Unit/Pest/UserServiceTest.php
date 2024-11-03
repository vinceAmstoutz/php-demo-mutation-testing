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
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

beforeEach(function (): void {
    /* @var EntityManagerInterface&MockObject $this entityManager */
    $this->entityManager = Mockery::mock(EntityManagerInterface::class);

    /* @var PasswordHasherInterface&MockObject $this entityManager */
    $this->passwordHasher = Mockery::mock(PasswordHasherInterface::class);

    $this->userService = new UserService($this->entityManager, $this->passwordHasher);
});

covers(UserService::class);
it('creates a user', function (): void {
    $this->entityManager
        ->shouldReceive('persist')
        ->once()
        ->with(Mockery::type(User::class));

    $this->entityManager->shouldReceive('flush');

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
