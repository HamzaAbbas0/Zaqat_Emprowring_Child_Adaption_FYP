<?php

namespace App\Enums;

abstract class ServiceTypes
{
    const Eyeglasses_Recycling = 1;
    const Giving_Tree = 2;
    const Adoption = 3;
    const Ramp_Building = 4;

    const LIST = ["", "Eyeglasses Recycling", "Giving Tree", "Adoption", "Ramp Building"];
}