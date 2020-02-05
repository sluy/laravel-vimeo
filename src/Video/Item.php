<?php

namespace Vientodigital\LaravelVimeo\Video;

use Carbon\Carbon;

class Item extends Base
{
    public function getCreatedTime()
    {
        return new Carbon($this->get('created_time'));
    }

    public function getModifiedTime()
    {
        return new Carbon($this->get('modified_time'));
    }

    public function getReleaseTime()
    {
        return new Carbon($this->get('release_time'));
    }

    public function isDownloable()
    {
        return true === $this->get('privacy.download');
    }

    public function isCommentable()
    {
        return true === $this->get('privacy.comments');
    }

    public function getPictureUrl($size, $playButton = false)
    {
        return $this->resolvePictureUrl($this->get('pictures.sizes'), $size, $playButton);
    }

    public function getUserPictureUrl($size)
    {
        return $this->resolvePictureUrl($this->get('user.pictures.sizes'), $size);
    }

    public function getEmbedIframeAs($control = 'div')
    {
        $html = $this->get('embed.html');

        return str_replace('</iframe>', "</{$control}>", str_replace('<iframe ', "<{$control} ", $html));
    }

    protected function resolvePictureUrl($data, $size, $playButton = false)
    {
        if (is_array($data) && !empty($data)) {
            if (is_string($size)) {
                $size = \strtolower($size);
                if ('big' === $size || 'small' === $size) {
                    if ('big' === $size) {
                        $data = array_reverse($data);
                    }
                    foreach ($data as $current) {
                        return ($playButton)
                            ? $current['link_with_play_button']
                            : $current['link'];
                    }

                    return null;
                }
                $tmp = explode('x', $size);
                $size = [];
                if (isset($tmp[0])) {
                    $size['height'] = $tmp[0];
                }
                if (isset($tmp[1])) {
                    $size['width'] = $tmp[1];
                }
            }
            foreach ($data as $current) {
                $is = empty($size) ||
                    (isset($size['height']) && $current['height'] === $size['height'] && (!isset($size['width'])) || $current['width'] === $size['width']) ||
                    (isset($size['width']) && $current['width'] === $size['width'] && (!isset($size['height']) || $current['height'] === $size['height']));
                if ($is) {
                    return ($playButton)
                        ? $current['link_with_play_button']
                        : $current['link'];
                }
            }
        }

        return null;
    }
}
