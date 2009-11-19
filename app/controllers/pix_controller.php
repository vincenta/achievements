<?php

class PixController extends ApplicationController {

    public function all_json() {
        $this->layout = '';

        $all = array();
        foreach (ImageBrowser::all() as $title => $image) {
            $all[] = array(
                'image_id' => $image->filename,
                'title'    => $image->title,
                'url'      => $this->url_for($image->path)
            );
        }
        $this->render_json(array(
            'message' => 'ok',
            'count'   => count($all),
            'images'  => $all
        ));
    }

}
