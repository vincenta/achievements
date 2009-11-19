<?php

class AchievementCreateForm extends SForm {

    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);
        
        $this->set_prefix('achievement');
        $this->title = new SCharField(array(
            'required' => true,
            'label'    => __('Title')
        ));
        $this->description = new SCharField(array(
            'required' => true,
            'label'    => __('Description')
        ));
        $this->image_id = new ImageSelectorField(array( //FIXME: advanced image picker
            'required'  => false,
            'label'     => __('Image')
        ));
        $this->reward = new SCharField(array(
            'required' => true,
            'label'    => __('Reward')
        ));
    }

    protected function clean() {
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
