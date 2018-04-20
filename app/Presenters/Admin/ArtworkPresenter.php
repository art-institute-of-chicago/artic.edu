<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ArtworkPresenter extends BasePresenter
{
    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    public function headerType()
    {
        return "gallery";
    }

    public function imageThumb()
    {
        $image = $this->entity->imageFront('hero', 'default');

        if (!empty($image)) {
            if (isset($image['src'])) {
                return $image['src'];
            }
        }

    }

    public function blocks()
    {
        $blocks = [];
        array_push($blocks, array(
          "type" => 'text',
          "content" => $this->entity->description
        ));

        if ($this->entity->is_on_view) {
            $label = '';
            if (!empty($this->entity->collection_status)) {
                $label .= $this->entity->collection_status . ', ';
            }
            if (!empty($this->entity->gallery_title)) {
                $label .= $this->entity->gallery_title;
            }
            $this->entity->onView = array('label' => $label, 'href' => route('galleries.show', [$this->entity->gallery_id]));

            array_push($blocks, array(
              "type" => 'deflist',
              "variation" => 'deflist--free-spacing u-hide@large+',
              "items" => array(
                array('key' => 'On View', 'value' => $label),
              )
            ));
        }

        array_push($blocks, $this->entity->getArtworkDetailsBlock());
        array_push($blocks, $this->entity->getArtworkDescriptionBlocks());

        // $artworkClassrommResources
        return $blocks;
    }

}
