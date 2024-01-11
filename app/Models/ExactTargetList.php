<?php

namespace App\Models;

/**
 * Class used to keep track of our newsletter options
 */
class ExactTargetList
{
    public static function getList()
    {
        return collect([
            'OptMuseum' => 'News and Exhibitions',
            'OptHumanResources' => 'Career Opportunities',
            'OptFamilyPrograms' => 'Families',
            'OptEvents' => 'Public Programs',
            'OptStudentTeacherPrograms' => 'K-12 Educator Resources',
            'OptTeenPrograms' => 'Teen Opportunities',
            'OptAcademicEngagement' => 'Research, Publishing, and Conservation',
            // 'OptShop' => 'Museum Shop',
        ]);
    }
}
