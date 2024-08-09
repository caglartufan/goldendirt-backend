<?php

namespace App\Enums;

enum FarmFieldStatus: string {
  case Idle = 'IDLE';
  case CropGrowingUp = 'CROP_GROWING_UP';
  case CropGrownUp = 'CROP_GROWN_UP';
  case Barren = 'BARREN';
}
