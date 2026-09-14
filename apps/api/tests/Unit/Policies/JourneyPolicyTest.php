<?php

namespace Tests\Unit\Policies;

use App\Models\Journey;
use App\Models\User;
use App\Policies\JourneyPolicy;
use PHPUnit\Framework\TestCase;

class JourneyPolicyTest extends TestCase
{
    public function test_owner_can_view_update_delete_and_transition_journey(): void
    {
        $owner = new User(['name' => 'Owner']);
        $owner->id = 10;
        $journey = new Journey;
        $journey->owner_id = 10;
        $policy = new JourneyPolicy;

        $this->assertTrue($policy->view($owner, $journey));
        $this->assertTrue($policy->update($owner, $journey));
        $this->assertTrue($policy->delete($owner, $journey));
        $this->assertTrue($policy->transition($owner, $journey));
    }

    public function test_non_owner_cannot_view_update_delete_or_transition_journey(): void
    {
        $otherUser = new User(['name' => 'Other user']);
        $otherUser->id = 11;
        $journey = new Journey;
        $journey->owner_id = 10;
        $policy = new JourneyPolicy;

        $this->assertFalse($policy->view($otherUser, $journey));
        $this->assertFalse($policy->update($otherUser, $journey));
        $this->assertFalse($policy->delete($otherUser, $journey));
        $this->assertFalse($policy->transition($otherUser, $journey));
    }
}
