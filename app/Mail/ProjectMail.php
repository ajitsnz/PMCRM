<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ProjectMail
 */
class ProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $projectMember;


    /**
     * ProjectMail constructor.
     * @param  Project  $project
     * @param $projectMember
     */
    function __construct(Project $project, $projectMember)
    {
        $this->project = $project;
        $this->projectMember = $projectMember;
    }

    /**
     *
     * @return ProjectMail
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('New Project Created')
            ->markdown('emails.project.project');
    }
}
