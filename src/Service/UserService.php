<?php

/*
 *
 * (c) Vincent Amstoutz <vincent.amstoutz.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Service;

use SensitiveParameter;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final readonly class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PasswordHasherInterface $passwordHasher,
    ) {}

    public function create(string $username, #[SensitiveParameter] string $password): User
    {
        $passwordHashed = $this->passwordHasher->hash($password);

        $user = (new User())
            ->setUsername($username)
            ->setPassword($passwordHashed)
        ;

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
