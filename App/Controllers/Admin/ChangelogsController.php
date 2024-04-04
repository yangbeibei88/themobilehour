<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
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
      AdminErrorController::notFound('Changelogs not found');
    } else {
      loadView('Admin/Changelogs/index', [
        'changelogs' => $changelogs
      ]);
    }
  }
}
