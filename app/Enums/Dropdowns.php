<?php

namespace App\Enums;

abstract class Dropdowns
{
    const GENDER = ["Masculine", "Feminine", "Neutral"];
    const COLOR = ["Red", "Green", "Blue", "Pink", "Orange", "Brown", "Black", "Purple", "White", "Aqua", "Grey", "Peach"];

    const SHIRTSIZE = [
        "Not needed", "Infant - Preemie", "Infant - 0-3 Months", "Infant - 3-6 Months","Infant - 6-9 Months", "Infant - 9-12 Months", 
        "Infant - 12 Months", "Infant - 18 Months", "Infant - 24 Months", "Toddler - 2T", "Toddler - 3T", "Toddler - 4T", "Toddler - 5T",
        "Kids - XSmall 4-5 Years", "Kids - Small 6-7 Years", "Kids - Medium 8-9 Years", "Kids - Large 10-11 Years", "Kids - XLarge 12-13 Years",
        "Junior - XSmall", "Junior - Small", "Junior - Medium", "Junior - Large", "Junior - XLarge", "Adult - XSmall", "Adult - Small", 
        "Adult - Meduim", "Adult - Large", "Adult - XLarge", "Adult - XXLarge"
    ];

    const SOCKSSIZE = [
        "Not needed", "Toddler - 0", "Toddler - 1", "Toddler - 2", "Toddler - 3", "Toddler - 4", "Toddler - 5", "Toddler - 6", "Toddler - 7", 
        "Toddler - 8", "Toddler - 9", "Toddler - 10", "Toddler - 11", "Toddler - 12", "Toddler - 13", 
        "Youth - 1", "Youth - 2", "Youth - 3", "Youth - 4", "Youth - 5", "Youth - 6", "Youth - 7", 
        "Women - 5", "Women - 5.5", "Women - 6", "Women - 6.5", "Women - 7", "Women - 7.5", "Women - 8", "Women - 8.5", "Women - 9", "Women - 9.5", "Women - 10", "Women - 10.5", 
        "Women - 12", "Women - 13", "Women - 14", "Women - 15.5", 
        "Men - 3.5", "Men - 4", "Men - 4.5", "Men - 5", "Men - 5.5", "Men - 6", "Men - 6.5", "Men - 7", "Men - 7.5", "Men - 8", "Men - 8.5", "Men - 9", "Men - 9.5", 
        "Men - 10", "Men - 11", "Men - 12"
    ];

    const DIAPERSIZE = ["Not needed", "Newborn", "1", "2", "3", "4", "5", "6"];

    const SHOES = [
        "Tennis Shoes", "Dress Shoes", "Boots", "Winter Shoes"
    ];
}