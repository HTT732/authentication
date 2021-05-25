<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Global property and variable limit
     *
     * @var int
     */
    protected $limit;

    /**
     * Function constructor
     *
     * @param
     * @return void
     */
    public function __construct()
    {
        $this->limit = config('constants.backend.per_page');

    }
}
