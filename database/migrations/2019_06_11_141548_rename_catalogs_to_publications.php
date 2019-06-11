<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCatalogsToPublications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->dropAllIndexes('digital_catalog_page');
        $this->dropAllIndexes('page_printed_catalog');

        $this->rename('digital_catalog', 'digital_publication');
        $this->rename('printed_catalog', 'printed_publication');

        $this->renameRelationshipTable(
            'digital_catalog_page',
            'digital_publication_page',
            'digital_catalog',
            'digital_publication',
            'page',
            'page'
        );

        $this->renameRelationshipTable(
            'page_printed_catalog',
            'page_printed_publication',
            'printed_catalog',
            'printed_publication',
            'page',
            'page'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropAllIndexes('digital_publication_page');
        $this->dropAllIndexes('page_printed_publication');

        $this->rename('digital_publication', 'digital_catalog');
        $this->rename('printed_publication', 'printed_catalog');

        $this->renameRelationshipTable(
            'digital_publication_page',
            'digital_catalog_page',
            'digital_publication',
            'digital_catalog',
            'page',
            'page'
        );

        $this->renameRelationshipTable(
            'page_printed_publication',
            'page_printed_catalog',
            'printed_publication',
            'printed_catalog',
            'page',
            'page'
        );
    }

    private function rename($oldTableName, $newTableName)
    {
        $this->dropAllIndexes("{$oldTableName}_slugs");
        $this->dropAllIndexes("{$oldTableName}_revisions");

        // Schema::table("{$oldTableName}_slugs", function (Blueprint $table) use ($oldTableName) {
        //     $table->dropIndex(["locale"]);
        //     $table->dropForeign("fk_{$oldTableName}_slugs_{$oldTableName}_id");
        // });

        // Schema::table("{$oldTableName}_revisions", function (Blueprint $table) use ($oldTableName) {
        //     $table->dropIndex(["{$oldTableName}_id"]);
        //     $table->dropForeign(["{$oldTableName}_id"]);
        //     $table->dropForeign(["user_id"]);
        // });

        Schema::rename(str_plural($oldTableName), str_plural($newTableName));

        Schema::rename("{$oldTableName}_slugs", "{$newTableName}_slugs");
        Schema::rename("{$oldTableName}_revisions", "{$newTableName}_revisions");

        Schema::table("{$newTableName}_slugs", function (Blueprint $table) use ($oldTableName, $newTableName) {
            $table->renameColumn("{$oldTableName}_id", "{$newTableName}_id");
            $table->index('locale');
            $table->foreign("{$newTableName}_id", "fk_{$newTableName}_slugs_{$newTableName}_id")
                ->references('id')
                ->on(str_plural($newTableName))
                ->onDelete('CASCADE')
                ->onUpdate('NO ACTION');
        });

        Schema::table("{$newTableName}_revisions", function (Blueprint $table) use ($oldTableName, $newTableName) {
            $table->renameColumn("{$oldTableName}_id", "{$newTableName}_id");
            $table->index("{$newTableName}_id");
            $table->foreign("{$newTableName}_id")
                ->references('id')
                ->on(str_plural($newTableName))
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on(config('twill.users_table', 'twill_users'))
                ->onDelete('set null');
        });
    }

    /**
     * Necessary, because for some reason `createDefaultRelationshipTableFields` appends a random string.
     */
    private function dropAllIndexes($tableName)
    {
        $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($tableName);
        $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys($tableName);

        foreach ($foreignKeys as $foreignKey) {
            Schema::table($tableName, function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey->getName());
            });
        }

        foreach ($indexes as $index) {
            if ($index->isPrimary()) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($index) {
                $table->dropIndex($index->getName());
            });
        }
    }


    // Spoof of `createDefaultRelationshipTableFields`
    private function renameRelationshipTable(
        $oldPivotTableName,
        $newPivotTableName,
        $oldFirstTableName,
        $newFirstTableName,
        $oldSecondTableName,
        $newSecondTableName
    ) {
        // Call this before the rename of the main table
        // $this->dropAllIndexes($oldPivotTableName);

        Schema::rename($oldPivotTableName, $newPivotTableName);

        Schema::table($newPivotTableName, function (Blueprint $table) use (
            $oldFirstTableName,
            $newFirstTableName,
            $oldSecondTableName,
            $newSecondTableName
        ) {
            $table->renameColumn("{$oldFirstTableName}_id", "{$newFirstTableName}_id");
            $table->renameColumn("{$oldSecondTableName}_id", "{$newSecondTableName}_id");
            $table->foreign("{$newFirstTableName}_id")
                ->references('id')
                ->on(str_plural($newFirstTableName))
                ->onDelete('cascade');
            $table->foreign("{$newSecondTableName}_id")
                ->references('id')
                ->on(str_plural($newSecondTableName))
                ->onDelete('cascade');
            $table->index([
                    "{$newSecondTableName}_id",
                    "{$newFirstTableName}_id"
                ],
                "idx_{$newFirstTableName}_{$newSecondTableName}_" . str_random(5) // But why?
            );
        });

    }


}
