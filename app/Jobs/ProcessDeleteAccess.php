<?php

namespace App\Jobs;

use App\Events\DeleteAccessEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\UserAccess;
use App\VpnServerLog;
use App\VpnServerAccess;
use App\VpnServer;
use App\User;

class ProcessDeleteAccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userAccessList;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userAccessList = UserAccess::where('end_at', '<', time())
            ->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->userAccessList as $userAccess) {
            $vpnServersAccess = VpnServerAccess::where('user_id', '=', $userAccess->user_id)
                ->where('status', '=', 'open')
                ->get();

            foreach ($vpnServersAccess as $vpnServerAccess) {
                $vpnLog = new VpnServerLog();
                $vpnLog->vpn_server_id = $vpnServerAccess->vpn_server_id;
                $vpnLog->user_id = $vpnServerAccess->user_id;
                $vpnLog->type = 'request';
                $vpnLog->action = 'delete-access';
                $vpnLog->save();

                $vpnServer = VpnServer::where('id', '=', $vpnServerAccess->vpn_server_id)
                    ->first();

                if (!$vpnServer) {
                    continue;
                }

                $user = User::where('id', '=', $vpnServerAccess->user_id)
                    ->first();

                if (!$user) {
                    continue;
                }

                event(new DeleteAccessEvent($vpnLog->event_id, $vpnServer->ip, $user));
            }
        }
    }
}
