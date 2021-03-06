<?php

class AchievementCreateForm extends SForm {

    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);
        
        $this->set_prefix('achievement');
        $this->title = new SCharField(array(
            'required' => true,
            'label'    => __('Title'),
            'input_attrs' => array(
                'style'    => 'width: 50%;'
            )
        ));
        $this->description = new SCharField(array(
            'required' => true,
            'label'    => __('Description'),
            'input_attrs' => array(
                'style'    => 'width: 50%;'
            )
        ));
        $this->reward = new SCharField(array(
            'required' => true,
            'label'    => __('Reward'),
            'input_attrs' => array(
                'style'    => 'width: 50%;'
            )
        ));
        $this->image_id = new ImageSelectorField(array(
            'required'  => true,
            'label'     => __('Image')
        ));
    }

    protected function clean_image_id($value) {
        if (!ImageBrowser::check_file($value))
            throw new SValidationError(__('Select an image'));
        return $value;
    }
}

class SetWinnerForm extends SForm {

    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);
        
        $this->set_prefix('achievement');
        $this->winner_id = new UserSelectorField(array(
            'required'  => true,
            'label'     => __('Choose the winner from the users list below...')
        ));
    }

    protected function clean_winner_id($value) {
        try {
            $user = User::$objects->get($value);
            $this->cleaned_data['winner'] = $user;
        } catch (SRecordNotFound $e) {
            throw new SValidationError(__('Select a winner'));
        }
        return $value;
    }
}

class ImageSelectorField extends SCharField {
    protected $input = 'ImageSelectorInput';
}

class ImageSelectorInput extends SInput {
    protected $type = 'hidden';

    public function __construct(array $attrs = array()) {
        $this->attrs = array('class' => 'imageSelector');
        $this->add_attrs($attrs);
    }
    
    public function render($name, $value = null, array $attrs = array()) {
        $final_attrs = array_merge(array('type' => $this->type, 'name' => $name), $this->attrs, $attrs);
        if ($value != '') $final_attrs['value'] = $value;
        $url = SUrlRewriter::url_for(array('controller' => 'pix', 'action' => 'all_json'));
        $js = "
            <script type=\"text/javascript\">
            $('#{$final_attrs['id']}').imageSelector('{$url}');
            </script>\n";
        return '<input '.$this->flatten_attrs($final_attrs).' />'.$js;
    }
}

class UserSelectorField extends SCharField {
    protected $input = 'UserSelectorInput';
}

class UserSelectorInput extends SInput {
    protected $type = 'hidden';

    public function __construct(array $attrs = array()) {
        $this->attrs = array('class' => 'userSelector');
        $this->add_attrs($attrs);
    }
    
    public function render($name, $value = null, array $attrs = array()) {
        $final_attrs = array_merge(array('type' => $this->type, 'name' => $name), $this->attrs, $attrs);
        if ($value != '') $final_attrs['value'] = $value;
        $url = SUrlRewriter::url_for(array('controller' => 'users', 'action' => 'all_json'));
        $js = "
            <script type=\"text/javascript\">
            $('#{$final_attrs['id']}').imageSelector('{$url}');
            </script>\n";
        return '<input '.$this->flatten_attrs($final_attrs).' />'.$js;
    }
}

class CommentForm extends SForm {

    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);

        $this->set_prefix('comment');
        $this->body = new STextField(array(
            'required' => true,
            'label'    => __('Message'),
            'input_attrs' => array(
                'cols' => 80,
                'rows' => 5
            )
        ));
        $this->attachment = new SFileField(array(
            'required' => false,
            'label'    => __('Attach a file'),
        ));
    }
}

