<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadFile implements ShouldQueue
{
    use Dispatchable;
    // use InteractsWithQueue, Queueable, SerializesModels

    private UploadedFile $file;
    private string $folder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UploadedFile $file, string $folder)
    {
        $this->file = $file;
        $this->folder = $folder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->file->storeAs(
            $this->folder,
            str()->random(40) . '.' . $this->file->getClientOriginalExtension(),
            'public',
        );
    }
}
