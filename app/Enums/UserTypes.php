<?php

namespace App\Enums;

abstract class UserTypes
{
    const Admin = 1;
    const Moderator = 2;
    const Donor = 3;
    const Applicant = 4;

    const LIST = ["", "Admin", "Moderator", "Donor", "Community Member"];
}