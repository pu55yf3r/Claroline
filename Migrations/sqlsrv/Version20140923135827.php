<?php

namespace Claroline\CoreBundle\Migrations\sqlsrv;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/09/23 01:58:31
 */
class Version20140923135827 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_workspace_model_resource (
                id INT IDENTITY NOT NULL, 
                resource_node_id INT NOT NULL, 
                model_id INT NOT NULL, 
                isCopy BIT NOT NULL, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_F5D706351BAD783F ON claro_workspace_model_resource (resource_node_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_F5D706357975B7E7 ON claro_workspace_model_resource (model_id)
        ");
        $this->addSql("
            ALTER TABLE claro_workspace_model_resource 
            ADD CONSTRAINT FK_F5D706351BAD783F FOREIGN KEY (resource_node_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_workspace_model_resource 
            ADD CONSTRAINT FK_F5D706357975B7E7 FOREIGN KEY (model_id) 
            REFERENCES claro_workspace_model (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_message ALTER COLUMN receiver_string NVARCHAR(2047) NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE claro_workspace_model_resource
        ");
        $this->addSql("
            ALTER TABLE claro_message ALTER COLUMN receiver_string NVARCHAR(1023) NOT NULL
        ");
    }
}