<?php

namespace App\Controllers;

use App\Classes\Email;
use App\Classes\ScrapPage;
use App\Core\View;
use App\Models\User;
use App\Traits\ApiMethods;

class Home
{
    use ApiMethods;

    public function index()
    {
        $scrapPage = new ScrapPage;
        $scrapPage->fetchObj();
    }
}
