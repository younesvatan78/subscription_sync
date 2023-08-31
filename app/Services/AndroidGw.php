<?php

namespace App\Services;
use App\Models\App;

class AndroidGw implements FakeSubcheckGw{
    public function checkstatus($sub): array{
        $status_sub = ['active','expired','pending'];
        $http_response = [200,200,200,400];
        return array(
            'status'=>$status_sub[rand(0,count($status_sub) - 1)],
            'http_code'=>$http_response[rand(0,count($http_response) - 1)]);
    }
}