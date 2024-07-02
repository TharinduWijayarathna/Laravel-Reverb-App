<?php

namespace App\Jobs;

use App\Events\ExportPdfStatusUpdated;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessPdfExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        event(new ExportPdfStatusUpdated($this->user, [
            'message' => 'Exporting...',
        ]));

        sleep(5);

        event(new ExportPdfStatusUpdated($this->user, [
            'message' => 'Complete!',
            'link'    => Storage::put('exports/'.$this->user->id.'.pdf', Pdf::loadView('exports.pdf', ['user' => $this->user])->output()),
        ]));
    }
}
