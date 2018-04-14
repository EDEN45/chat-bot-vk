<?php

namespace Bisaga\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180414122637 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $worklogtable = $schema->createTable('worklogtable');
        $worklogtable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement'=>true]);
        $worklogtable->addColumn('workdate', 'date', ['notnull'=>true]);
        $worklogtable->addColumn('location', 'string', ['length' => 60]);
        $worklogtable->addColumn('milage', 'decimal', ['precision' => 8, 'scale'=>2]);
        $worklogtable->addColumn('starttime', 'time');
        $worklogtable->addColumn('endtime','time');
        $worklogtable->addColumn('totaltime','time');
        $worklogtable->addColumn('status', 'string', ['length' => 30]);
        $worklogtable->setPrimaryKey(['id']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('worklogtable');

    }
}
