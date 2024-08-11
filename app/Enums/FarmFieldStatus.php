<?php

namespace App\Enums;

enum FarmFieldStatus: string {
  case Idle = 'IDLE';
  case Planted = 'PLANTED';
  case Barren = 'BARREN';
}
