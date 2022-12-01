<?php

namespace App\Security\Voter;

use App\Entity\Book;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookVoter extends Voter
{
    public const VIEW = 'book.view';
    public const EDIT = 'book.edit';
    public const DELETE = 'book.delete';

    public function __construct(private readonly AuthorizationCheckerInterface $checker) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::EDIT])
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->checker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if (!$subject instanceof Book) {
            return false;
        }

        return match ($attribute) {
            self::EDIT, self::DELETE => $subject->getCreatedBy() === $token->getUser(),
            self::VIEW => true,
            default => false,
        };
    }
}