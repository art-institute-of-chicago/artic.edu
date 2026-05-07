<?php

use A17\Twill\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $role1 = Role::find(1);
        $role1->name = 'Admin';
        $role1->save();

        $role2 = Role::find(2);
        $role2->name = 'Publisher';
        $role2->revokeAllPermissions();
        $role2->grantGlobalPermission('access-media-library');
        $role2->grantGlobalPermission('edit-media-library');
        $role2->save();


        $role3 = Role::find(3);
        $role3->name = 'XD Publisher';
        $role3->grantGlobalPermission('access-media-library');
        $role3->grantGlobalPermission('edit-media-library');
        $role3->save();
    }

    public function down(): void
    {
        //
    }
};
