<?php
namespace App\Services;

use App\Models\App;

interface FakeSubcheckGw{
    public function checkstatus($sub): array;
}