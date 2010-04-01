<?php

class StayLoggedInUpdate extends SMigration {

    /**
     * Create the psessions table (Persistent sessions)
     * @access public
     * @return void
     */
    public function up() {
        $t = new STable();
        $t->add_primary_key('id');
        $t->add_column('user_id', 'integer', array('null'=>false));
        $t->add_column('key', 'text', array('null'=>false));
        $t->add_column('created_on', 'datetime');
        $t->add_column('updated_on', 'datetime');
        $this->create_table('psessions', $t);
    }

    /**
     * Drop the psessions table (Persistent sessions)
     * @access public
     * @return void
     */
    public function down() {
        $this->drop_table('psessions');
    }

}

