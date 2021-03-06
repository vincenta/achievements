<?php

class DbInit extends SMigration {

    /**
     * Create users and achievements tables
     * @access public
     * @return void
     */
    public function up() {
        $t = new STable();
        $t->add_primary_key('id');
        $t->add_column('login', 'string', array('null'=>false));
        $t->add_column('password', 'string', array('null'=>false));
        $t->add_column('email', 'string', array('null'=>false));
        $t->add_column('active', 'boolean', array('null'=>false,'default'=>1));
        $t->add_column('created_on', 'datetime');
        $t->add_column('updated_on', 'datetime');
        $this->create_table('users', $t);

        $t = new STable();
        $t->add_primary_key('id');
        $t->add_column('title', 'string', array('null'=>false));
        $t->add_column('description', 'string', array('null'=>false));
        $t->add_column('image_id', 'string');
        $t->add_column('state', 'integer', array('null'=>false,'default'=>0));
        $t->add_column('reward', 'string', array('null'=>false));
        $t->add_column('creator_id', 'integer', array('null'=>false));
        $t->add_column('winner_id', 'integer');
        $t->add_column('created_on', 'datetime');
        $t->add_column('updated_on', 'datetime');
        $this->create_table('achievements', $t);

        $this->execute("ALTER TABLE `achievements` MODIFY `state` ENUM('unlocked','locked','expired') NOT NULL DEFAULT 'locked';");
    }

    /**
     * Drop users and achievements tables
     * @access public
     * @return void
     */
    public function down() {
        $this->drop_table('users');
        $this->drop_table('achievements');
    }

}

