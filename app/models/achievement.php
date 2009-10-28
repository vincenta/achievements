<?php

class Achievement extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'creator' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'creator_id' ),
        'winner' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'winner_id' )
    );
    public $record_timestamps = true;

    public function __toString() {
        return "Achievement #{$this->id}";
    }

    public function is_locked() {
        $id = $this->winner_id;
        return empty($id);
    }
}
