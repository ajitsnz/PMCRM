<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\PredefinedReply;
use App\Models\Reminder;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Queries\TicketDataTable;
use App\Repositories\NoteRepository;
use App\Repositories\TicketRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaStream;
use Spatie\MediaLibrary\Models\Media;
use Yajra\DataTables\DataTables;

class TicketController extends AppBaseController
{
    /** @var  TicketRepository */
    private $ticketRepository;

    /** @var NoteRepository */
    private $noteRepository;

    public function __construct(TicketRepository $ticketRepo, NoteRepository $noteRepository)
    {
        $this->ticketRepository = $ticketRepo;
        $this->noteRepository = $noteRepository;
    }

    /**
     * Display a listing of the Ticket.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new TicketDataTable())->get($request->only(['status','customer_id'])))->make(true);
        }

        $statusArr = TicketStatus::pluck('name', 'id');
        $data = $this->ticketRepository->getTicketStatusCounts();

        return view('tickets.index', compact('statusArr', 'data'));
    }

    /**
     * Show the form for creating a new Ticket.
     *
     * @return Factory|View
     */
    public function create()
    {
        $data = $this->ticketRepository->getSyncList();

        return view('tickets.create', compact('data'));
    }

    /**
     * Store a newly created Ticket in storage.
     *
     * @param  CreateTicketRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateTicketRequest $request)
    {
        $input = $request->all();
        $input['ticket_status_id'] = TicketStatus::where('id', 1)->value('id');
        $this->ticketRepository->create($input);

        Flash::success('Ticket saved successfully.');

        return redirect(route('ticket.index'));
    }

    /**
     * Display the specified Ticket.
     *
     * @param  Ticket  $ticket
     *
     * @return Factory|View
     */
    public function show(Ticket $ticket)
    {
        $data = $this->ticketRepository->getReminderData($ticket->id, Ticket::class);
        $notifiedReminder = Reminder::IS_NOTIFIED;
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $notes = $this->ticketRepository->getNotesData($ticket);
        $groupName = (request('group') === null) ? 'ticket_details' : (request('group'));

        return view("tickets.views.$groupName",
            compact('ticket', 'data', 'notifiedReminder', 'status', 'priorities', 'notes', 'groupName'));
    }

    /**
     * Show the form for editing the specified Ticket.
     *
     * @param  Ticket  $ticket
     *
     * @return Factory|View
     */
    public function edit(Ticket $ticket)
    {
        $data = $this->ticketRepository->getSyncList();

        return view('tickets.edit', compact('ticket', 'data'));
    }

    /**
     * Update the specified Ticket in storage.
     *
     * @param  Ticket  $ticket
     *
     * @param  UpdateTicketRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        $input = $request->all();
        $this->ticketRepository->update($input, $ticket);

        Flash::success('Ticket updated successfully.');

        return redirect(route('ticket.index'));
    }

    /**
     * Remove the specified Ticket from storage.
     *
     * @param  Ticket  $ticket
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Ticket $ticket)
    {
        activity()->performedOn($ticket)->causedBy(getLoggedInUser())
            ->useLog('Ticket deleted.')->log($ticket->subject.' Ticket deleted.');

        $ticket->tags()->delete();
        $ticket->clearMediaCollection(Ticket::TICKET_ATTACHMENT_PATH);
        $ticket->delete();

        return $this->sendSuccess('Ticket deleted successfully.');
    }

    /**
     * @param  int  $predefinedReplyId
     *
     * @return mixed
     */
    public function getPredefinedReplyBody($predefinedReplyId)
    {
        return PredefinedReply::whereId($predefinedReplyId)->value('body');
    }

    /**
     * @param  Ticket  $ticket
     *
     * @return MediaStream
     */
    public function downloadMedia(Ticket $ticket)
    {
        $downloads = $ticket->getMedia(Ticket::TICKET_ATTACHMENT_PATH);

        return MediaStream::create('attachments.zip')->addMedia($downloads);
    }

    /**
     * @param  Ticket  $ticket
     *
     * @return mixed
     */
    public function getNotesCount(Ticket $ticket)
    {
        return $this->sendResponse($ticket->notes()->count(), 'Notes count retrieved successfully.');
    }

    /**
     *
     * @return Factory|View
     */
    public function kanbanList()
    {
        $tickets = Ticket::with([
            'user.media', 'ticketPriority', 'service', 'department',
        ])->get()->groupBy('ticket_status_id');

        $ticketStatus = TicketStatus::get();

        return View('tickets.kanban.index', compact('tickets', 'ticketStatus'));
    }

    /**
     * @param  Ticket  $ticket
     *
     * @param  int  $statusId
     *
     * @return mixed
     */
    public function changeStatus(Ticket $ticket, $statusId)
    {
        $ticket->update(['ticket_status_id' => $statusId]);

        return $this->sendSuccess('Ticket status updated successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function attachmentDelete(Request $request)
    {
        $mediaId = $request->all();
        $attachment = Media::findOrFail($mediaId['mediaId'])->delete();

        return $this->sendSuccess('Attachment deleted successfully.');
    }

    /**
     * @param  Media  $mediaItem
     *
     * @return Media
     */
    public function download(Media $mediaItem)
    {
        return $mediaItem;
    }
}
