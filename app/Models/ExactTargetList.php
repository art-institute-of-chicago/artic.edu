<?php

namespace App\Models;

// Class used to keep track of our newsletter options

class ExactTargetList
{
    public static function getList()
    {
        return collect([
            'OptEnews' => 'News and Exhibitions',
            'OptHumanResources' => 'Career Opportunities',
            'OptEveningAssociates' => 'Evening Associates',
            'OptFamilyPrograms' => 'Family Programs',
            'OptEvents' => 'Public Programs',
            'OptStudentTeacherPrograms' => 'Student and Teacher Programs',
            'OptTeenPrograms' => 'Teen Programs',
            'OptAcademicEngagement' => 'Academic Engagement and Research',
        ]);
    }
}
