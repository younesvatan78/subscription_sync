<?php
/**
 * This class check the status of user subscription in the app to only be android or ios and retry if needed.
 * 
 */
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Subscription;
use App\Models\App;
use App\Services\AndroidGw;
use App\Services\FakeSubcheckGw;
use App\Services\IosGw;
use App\Mail\SendExpiredNotifyMailToAdmin;
use App\Models\Platform;
use Illuminate\Support\Facades\Mail;


class CheckSubStatusService{
    protected $subscriptions = [
        'android' => AndroidGw::class,
        'ios' => IosGw::class
    ];
    public function subcheckstatus(){
        $Subscriptions = Subscription::with('App')->get();
        foreach($Subscriptions as $sub){
            $platformName = $sub->app->platform_id === 1 ? 'android' : 'ios';

            $service = $this->getsubtype($platformName);
            $status = $this->checkstatus($service,$platformName,$sub);
            if($status !== $sub->status){
                $sub->update([
                    'status'=> $status
                ]);
            }elseif($status == 'expired'){
                // echo $platformName;
                $sub->update([
                    'status' => 'expired'
                ]);
                // $this->notifyAdmin($sub,$platformName);
            }
            
        }
        // var_dump($Subscriptions);
    }
    // This func ensure the platform is only android or ios
    public function getsubtype(string $platform): FakeSubcheckGw
    {
        if (!isset($this->subscriptions[$platform])) {
            throw new \InvalidArgumentException("Invalid platform: $platform");
        }

        return new $this->subscriptions[$platform];
    }



    // This func checks the status of subscripions and http response to retry on none-200 code
    protected function checkStatus(FakeSubcheckGw $service, string $platform, $sub): string
    {
        $response = $service->checkStatus($sub);
        $status = $response['status'] ?? null;
        $httpStatusCode = $response['http_code'] ?? null;


        $retryDelay = $this->getRetryDelay($platform, $httpStatusCode);
        if ($retryDelay) {
            echo "Platform: {$platform} \nHttpStatusCode: $httpStatusCode \n";
            echo "Sub with ID: {$sub->id} is {$status} \n";
            echo "Try after {$retryDelay} minutes\n";
            echo "----------- \n";
            sleep($retryDelay);
            return $this->checkStatus($service, $platform, $sub);
        }
        echo "Platform: {$platform} \nHttpStatusCode: $httpStatusCode \n";
        echo "Sub with ID: {$sub->id} is {$status}\n";
        echo "----------------------\n";
        return $status;
        
    }





    // Defined time of retry for each platform on non-200 http response 
    protected function getRetryDelay(string $platform, ?int $httpStatusCode): ?int
    {
        if ($httpStatusCode !== 200) {
            $retryDelays = [
                'android' => 3600, // Retry after 1 hour for Android
                'ios' => 7200,     // Retry after 2 hours for iOS
            ];

            return $retryDelays[$platform] ?? null;
        }

        return null; // No retry for HTTP 200 status code
    }








    public function GetLatestExpiredSubs($platform)
    {
        // $platformID = $platform === 'android' ? 1 : 2;
        $platformID = is_null($platform) ? null : ($platform === 'android' ? 1 : 2);

        $subs = Subscription::with('App')->where([
            'status'=>'expired'])->get();
            

        $latestExpiredSubscriptions = collect();

        foreach ($subs as $sub) {
            
            if ($sub) {
                $latestExpiredSubscriptions->push($sub);
            }
        }
        return ($platformID) ? $latestExpiredSubscriptions->where('app.platform_id', $platformID)->values() : $latestExpiredSubscriptions;

    }
    public function notifyAdmin($sub,$platformName){
        // Sends email to admin to notify about expired 
        // echo $sub->id,$platformName,$sub->updated_at;
        $message = 'Subsctipion with this id ' .$sub->id. 'and the platfrom name:'. $platformName.',expired at '.$sub->updated_at;
        Mail::to('uniyounes@gmail.com')->send(new SendExpiredNotifyMailToAdmin($message));
    }
}