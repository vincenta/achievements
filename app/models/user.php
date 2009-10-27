<?php

class User extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'achievements' => 'has_many'
    );
    public $record_timestamps = true;

    public function __toString() {
        return "{$this->login}";
    }

    public function validate () {
        $this->validate_uniqueness_of('login',array('This Login is already used.'));
        $this->validate_uniqueness_of('email',array('An account already exists for this email.'));
    }

    protected function before_create() {
        $this->active = true;
    }
}
