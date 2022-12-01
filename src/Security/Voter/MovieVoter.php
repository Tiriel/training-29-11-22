<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MovieVoter extends Voter
{
    public const VIEW = 'movie.view';
    public const EDIT = 'movie.edit';

    public function __construct(private readonly AuthorizationCheckerInterface $checker) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::EDIT])
            && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->checker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User || !$subject instanceof Movie) {
            return false;
        }

        return match ($attribute) {
            self::VIEW => $this->checkView($user, $subject),
            self::EDIT => $this->checkEdit($user, $subject),
            default => false,
        };
    }

    private function checkView(User $user, Movie $movie): bool
    {
        $age = $user->getBirthday()?->diff(new \DateTimeImmutable())->y ?? null;

        return match ($movie->getRated()) {
            'G', 'Not Rated' => true,
            'PG', 'PG-13' => $age && $age >= 13,
            'R', 'NC-17' => $age && $age >= 17,
            default => false,
        };
    }

    private function checkEdit(User $user, Movie $movie): bool
    {
        return $this->checkView($user, $movie) && $movie->getCreatedBy() === $user;
    }
}