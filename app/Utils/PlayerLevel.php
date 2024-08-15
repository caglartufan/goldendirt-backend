<?php

namespace App\Utils;

class PlayerLevel {
  // Stores data about what player level requires how many experience points (xp) to level up.
  // For level 0 and 1, 0 xp is required because players are initially level 1.
  // To become level 2, player needs total of 200 xp and to become level 3, player needs
  // 250 more xp which means total of 350 xp.
  private static array $levelXpRequirements = [
    0,
    0,
    100,
    150,
    250,
    500, // Level 5 requires total of 1000 xp
  ];

  public static function getXpRequiredForLevel(int $level): int {
    return self::$levelXpRequirements[$level];
  }

  public static function calculateLevelFromTotalXp(int $totalXp): int {
    $level = 1;

    foreach(self::$levelXpRequirements as $xpRequired) {
      if($xpRequired === 0) {
        continue;
      }

      $totalXp -= $xpRequired;
      if($totalXp >= 0) {
        $level++;
      }
    }

    return $level;
  }

  public static function calculateXpRequiredForLevelUp(int $totalXp): int {
    foreach(self::$levelXpRequirements as $xpRequired) {
      $totalXp -= $xpRequired;

      if($totalXp < 0) {
        return -$totalXp;
      }
    }

    // Returning 0 means the player if at maximum level.
    return 0;
  }

  private function __construct() {
    // Private constructor to hint that this class can not be constructed or instantiated.
  }
}
