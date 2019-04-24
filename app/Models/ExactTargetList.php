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
            'OptFamilyPrograms' => 'Families',
            'OptEvents' => 'Public Programs',
            'OptStudentTeacherPrograms' => 'Students and Teachers',
            'OptTeenPrograms' => 'Teens',
            'OptAcademicEngagement' => 'Academic Engagement and Research',
        ]);
    }
}
