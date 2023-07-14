<?php

namespace App\Enums;

abstract class UserStatus
{
    const Inactive = 0;
    const Active = 1;

    const LIST = ["Inactive", "Active"];
}