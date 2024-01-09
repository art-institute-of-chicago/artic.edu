<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='exhibitionPressRooms' where blockable_type='App\Models\ExhibitionPressRoom'");
        DB::statement("UPDATE related SET subject_type='exhibitionPressRooms' where subject_type='App\Models\ExhibitionPressRoom'");
        DB::statement("UPDATE related SET related_type='exhibitionPressRooms' where related_type='App\Models\ExhibitionPressRoom'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='exhibitionPressRooms' where api_relatable_type='App\Models\ExhibitionPressRoom'");
        DB::statement("UPDATE mediables SET mediable_type='exhibitionPressRooms' where mediable_type='App\Models\ExhibitionPressRoom'");

        DB::statement("UPDATE blocks SET blockable_type='researchGuides' where blockable_type='App\Models\ResearchGuide'");
        DB::statement("UPDATE related SET subject_type='researchGuides' where subject_type='App\Models\ResearchGuide'");
        DB::statement("UPDATE related SET related_type='researchGuides' where related_type='App\Models\ResearchGuide'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='researchGuides' where api_relatable_type='App\Models\ResearchGuide'");
        DB::statement("UPDATE mediables SET mediable_type='researchGuides' where mediable_type='App\Models\ResearchGuide'");

        DB::statement("UPDATE blocks SET blockable_type='sponsors' where blockable_type='App\Models\Sponsor'");
        DB::statement("UPDATE related SET subject_type='sponsors' where subject_type='App\Models\Sponsor'");
        DB::statement("UPDATE related SET related_type='sponsors' where related_type='App\Models\Sponsor'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='sponsors' where api_relatable_type='App\Models\Sponsor'");
        DB::statement("UPDATE mediables SET mediable_type='sponsors' where mediable_type='App\Models\Sponsor'");

        DB::statement("UPDATE blocks SET blockable_type='digitalPublicationSections' where blockable_type='App\Models\DigitalPublicationSection'");
        DB::statement("UPDATE related SET subject_type='digitalPublicationSections' where subject_type='App\Models\DigitalPublicationSection'");
        DB::statement("UPDATE related SET related_type='digitalPublicationSections' where related_type='App\Models\DigitalPublicationSection'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='digitalPublicationSections' where api_relatable_type='App\Models\DigitalPublicationSection'");
        DB::statement("UPDATE mediables SET mediable_type='digitalPublicationSections' where mediable_type='App\Models\DigitalPublicationSection'");

        DB::statement("UPDATE blocks SET blockable_type='magazineIssues' where blockable_type='App\Models\MagazineIssue'");
        DB::statement("UPDATE related SET subject_type='magazineIssues' where subject_type='App\Models\MagazineIssue'");
        DB::statement("UPDATE related SET related_type='magazineIssues' where related_type='App\Models\MagazineIssue'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='magazineIssues' where api_relatable_type='App\Models\MagazineIssue'");
        DB::statement("UPDATE mediables SET mediable_type='magazineIssues' where mediable_type='App\Models\MagazineIssue'");

        DB::statement("UPDATE blocks SET blockable_type='pressReleases' where blockable_type='App\Models\PressRelease'");
        DB::statement("UPDATE related SET subject_type='pressReleases' where subject_type='App\Models\PressRelease'");
        DB::statement("UPDATE related SET related_type='pressReleases' where related_type='App\Models\PressRelease'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='pressReleases' where api_relatable_type='App\Models\PressRelease'");
        DB::statement("UPDATE mediables SET mediable_type='pressReleases' where mediable_type='App\Models\PressRelease'");
    }

    public function down(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='App\Models\ExhibitionPressRoom' where blockable_type='exhibitionPressRooms'");
        DB::statement("UPDATE related SET subject_type='App\Models\ExhibitionPressRoom' where subject_type='exhibitionPressRooms'");
        DB::statement("UPDATE related SET related_type='App\Models\ExhibitionPressRoom' where related_type='exhibitionPressRooms'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\ExhibitionPressRoom' where api_relatable_type='exhibitionPressRooms'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\ExhibitionPressRoom' where mediable_type='exhibitionPressRooms'");

        DB::statement("UPDATE blocks SET blockable_type='App\Models\ResearchGuide' where blockable_type='researchGuides'");
        DB::statement("UPDATE related SET subject_type='App\Models\ResearchGuide' where subject_type='researchGuides'");
        DB::statement("UPDATE related SET related_type='App\Models\ResearchGuide' where related_type='researchGuides'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\ResearchGuide' where api_relatable_type='researchGuides'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\ResearchGuide' where mediable_type='researchGuides'");

        DB::statement("UPDATE blocks SET blockable_type='App\Models\Sponsor' where blockable_type='sponsors'");
        DB::statement("UPDATE related SET subject_type='App\Models\Sponsor' where subject_type='sponsors'");
        DB::statement("UPDATE related SET related_type='App\Models\Sponsor' where related_type='sponsors'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\Sponsor' where api_relatable_type='sponsors'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\Sponsor' where mediable_type='sponsors'");

        DB::statement("UPDATE blocks SET blockable_type='App\Models\DigitalPublicationSection' where blockable_type='digitalPublicationSections'");
        DB::statement("UPDATE related SET subject_type='App\Models\DigitalPublicationSection' where subject_type='digitalPublicationSections'");
        DB::statement("UPDATE related SET related_type='App\Models\DigitalPublicationSection' where related_type='digitalPublicationSections'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\DigitalPublicationSection' where api_relatable_type='digitalPublicationSections'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\DigitalPublicationSection' where mediable_type='digitalPublicationSections'");

        DB::statement("UPDATE blocks SET blockable_type='App\Models\MagazineIssue' where blockable_type='magazineIssues'");
        DB::statement("UPDATE related SET subject_type='App\Models\MagazineIssue' where subject_type='magazineIssues'");
        DB::statement("UPDATE related SET related_type='App\Models\MagazineIssue' where related_type='magazineIssues'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\MagazineIssue' where api_relatable_type='magazineIssues'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\MagazineIssue' where mediable_type='magazineIssues'");

        DB::statement("UPDATE blocks SET blockable_type='App\Models\PressRelease' where blockable_type='pressReleases'");
        DB::statement("UPDATE related SET subject_type='App\Models\PressRelease' where subject_type='pressReleases'");
        DB::statement("UPDATE related SET related_type='App\Models\PressRelease' where related_type='pressReleases'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\PressRelease' where api_relatable_type='pressReleases'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\PressRelease' where mediable_type='pressReleases'");
    }
};
