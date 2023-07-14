<?php

namespace App\Enums;

abstract class RequestTypes
{
    const In_Review = 0;
    const Approved = 1;
    const Rejected = 2;
    const Completed = 3;

    const LIST = ["In Review", "Approved", "Rejected", "Completed"];
    const CSS_CLASSES = ["statusLightBlue", "statusGreen", "statusRed", "statusDarkBlue"];
    const CSS_BREADCRUMB_CLASSES = ["statusReview", "statusGreen", "statusRed", "statusDarkBlue"];
    const CSS_FORM_CLASSES = ["reviewStatus", "approvedStatus", "rejectedStatus", "completedStatus"];
}