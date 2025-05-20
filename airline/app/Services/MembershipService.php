<?php
namespace App\Services;

class MembershipService
{
    public static function calculateMembershipLevel($rewardPoints)
    {
        if ($rewardPoints >= 1000) {
            return 'Gold';
        } elseif ($rewardPoints >= 500) {
            return 'Silver';
        } else {
            return 'Bronze';
        }
    }
}