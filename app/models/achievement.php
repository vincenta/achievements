<?php

class Achievement extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'creator' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'creator_id' ),
        'winner' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'winner_id' )
    );
    public $record_timestamps = true;

    public function __toString() {
        return "{$this->login}";
    }

    public function validate () {
        $this->validate_uniqueness_of('login',array('This Login is already used.'));
        $this->validate_uniqueness_of('email',array('An account already exists for this email.'));
    }

    public function get_gravatar_url($size = 40) {
        return Gravatar::build_gravatar_url($this->email, $size);
    }

    protected function before_create() {
        $this->active = true;
    }
}
