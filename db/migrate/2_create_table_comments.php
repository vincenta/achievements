<?php

class CreateTableComments extends SMigration {

    /**
     * Create the comments table
     * @access public
     * @return void
     */
    public function up() {
        $t = new STable();
        $t->add_primary_key('id');
        $t->add_column('achievement_id', 'integer', array('null'=>false));
        $t->add_column('author_id', 'integer', array('null'=>false));
        $t->add_column('body', 'text', array('null'=>false));
        $t->add_column('created_on', 'datetime');
        $t->add_column('updated_on', 'datetime');
        $this->create_table('comments', $t);
    }

    /**
     * Drop the comments table
     * @access public
     * @return void
     */
    public function down() {
        $this->drop_table('comments');
    }

}

