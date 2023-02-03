<?php

namespace App\Services\FileLibrary;

use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\Factory as FilesystemManager;

class Disk extends \A17\Twill\Services\FileLibrary\Disk
{
    /**
     * @param mixed $id
     * @return mixed
     */
    public function getUrl($id)
    {
        $url = $this->filesystemManager->disk($this->config->get('twill.file_library.disk'))->url($id);
        return asset(parse_url($url, PHP_URL_PATH));
    }
}
