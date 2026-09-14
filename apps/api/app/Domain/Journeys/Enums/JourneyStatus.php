<?php

namespace App\Domain\Journeys\Enums;

enum JourneyStatus: string
{
    case Draft = 'DRAFT';
    case PrivatePreview = 'PRIVATE_PREVIEW';
    case PendingReview = 'PENDING_REVIEW';
    case Recruiting = 'RECRUITING';
    case MinimumReached = 'MINIMUM_REACHED';
    case Confirmed = 'CONFIRMED';
    case Full = 'FULL';
    case WaitlistOnly = 'WAITLIST_ONLY';
    case Preparing = 'PREPARING';
    case Active = 'ACTIVE';
    case Paused = 'PAUSED';
    case Emergency = 'EMERGENCY';
    case Completed = 'COMPLETED';
    case Cancelled = 'CANCELLED';
    case Archived = 'ARCHIVED';

    /** @return list<self> */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::Draft => [self::PrivatePreview, self::PendingReview, self::Recruiting, self::Cancelled],
            self::PrivatePreview => [self::Draft, self::PendingReview, self::Recruiting, self::Cancelled],
            self::PendingReview => [self::Draft, self::Recruiting, self::Cancelled],
            self::Recruiting => [self::MinimumReached, self::Confirmed, self::Full, self::WaitlistOnly, self::Cancelled],
            self::MinimumReached => [self::Recruiting, self::Confirmed, self::Full, self::Cancelled],
            self::Confirmed => [self::Recruiting, self::Full, self::Preparing, self::Cancelled],
            self::Full => [self::Recruiting, self::WaitlistOnly, self::Preparing, self::Cancelled],
            self::WaitlistOnly => [self::Recruiting, self::Full, self::Preparing, self::Cancelled],
            self::Preparing => [self::Active, self::Cancelled],
            self::Active => [self::Paused, self::Emergency, self::Completed, self::Cancelled],
            self::Paused => [self::Active, self::Emergency, self::Cancelled],
            self::Emergency => [self::Paused, self::Active, self::Cancelled],
            self::Completed, self::Cancelled => [self::Archived],
            self::Archived => [],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }
}
