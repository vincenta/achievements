<?php

class AddAttachment extends SMigration {

    public function up() {
        $this->add_column('comments', 'attachment', 'string');
    }

    public function down() {
        $this->remove_column('comments', 'attachment');
    }
}

