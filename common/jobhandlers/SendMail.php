<?php
namespace common\jobhandlers;

use shmilyzxt\queue\base\JobHandler;

class SendMail extends JobHandler
{

    public function handle($job,$data)
    {
        if($job->getAttempts() > 3){
            $this->failed($job);
        }

        $payload = $job->getPayload();

        //$payload即任务的数据，你拿到任务数据后就可以执行发邮件了
        //TODO 发邮件
        $a = unserialize($payload);
        $b = $a['data'];
        file_put_contents('payload.log', var_export($b,true));
    }

    public function failed($job,$data)
    {
        die("发了3次都失败了，算了");
    }
}