<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

/*
 * in job vazife darad otp tolid konad va dar redis zakhire konad.
 */
class SendOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $mobile;

    public function __construct(string $mobile)
    {
        $this->mobile = $mobile;
    }

    public function handle(): void
    {
        /*
         * code yekbar masraf 6 ragami ra be surate random tolid mikonim.
         */
        $otp = rand(100000, 999999);

        /*
         * mikhahim code be modate 3 dagige motabar bashad, be hamin dalil megdare ttl ra 180s dar nazar migirim.
         */
        $ttlSeconds = 180;
        /*
         * code ra be hamrahe shomare mobile dar cache zakhire mikonim ta badan betavanim ba mobile code marbute ra fetch konim.
         */
        Cache::store('redis')
            ->put(
                key: $this->getOtpCacheKey($this->mobile),
                value: $otp,
                ttl: $ttlSeconds,
            );
    }

    /*
     * kilide redis ra misazim.
     */
    private function getOtpCacheKey(string $mobile): string
    {
        return 'otp:mobile:' . $mobile;
    }
}


