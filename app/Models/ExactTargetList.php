<?php

namespace App\Models;

// Class used to keep track of our newsletter options

class ExactTargetList
{
    public static function getList()
    {
        return collect([
            'OptEveningAssociates' => 'Evening Associates',
            'OptEvents' => 'Public Programs',
            'OptFamilyPrograms' => 'Family Programs',
            'OptMemberTravel' => 'Member Travel',
            'OptStudentTeacherPrograms' => 'Student and Teacher Programs',
            'OptTeenPrograms' => 'Teen Programs',
            'OptAcademicEngagement' => 'Academic Engagement',
            'OptEnews' => 'E-news',
            'DP Test' => 'DP test list',
        ]);
    }
}
