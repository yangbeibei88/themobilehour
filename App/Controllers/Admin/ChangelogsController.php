<?php

namespace App\Controllers\Admin;

use App\Controllers\ErrorController;
use App\Models\Changelog;

class ChangelogsController
{
  protected $changelogModel;

  public function __construct()
  {
    $this->changelogModel = new Changelog();
  }

  public function index()
  {
    $changelogs = $this->changelogModel->getAllChangelogs();

    if (!$changelogs) {
      ErrorController::notFound('Changelogs not found');
    } else {
      loadView('Admin/Changelogs/index', [
        'changelogs' => $changelogs
      ]);
    }
  }
}
