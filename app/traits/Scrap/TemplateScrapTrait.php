<?php

namespace App\Traits\Scrap;

use App\Core\View;

trait TemplateScrapTrait
{
    public function renderTrackTemplate($tracks, $key, $objStatus, $timeLine = null)
    {
        return View::render('rastreio/index', ['title' => 'Código de rastreio para $key', 'key' => $key, 'objStatus' => $objStatus, 'tracks' => $tracks, 'timeLine' => $timeLine]);
    }
}
