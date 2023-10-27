<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TimetrackRepository;
use App\Http\Requests\SetTimetrackRequest;

class TimetrackController extends Controller
{
    public function __construct(
        protected TimetrackRepository $timetrackRepository
    ) {}

    /**
     * Start time track
     */
    public function start(SetTimetrackRequest $request)
    {
        return response('', $this->timetrackRepository->startTimer(auth()->user(), $request->project_id) ? 200 : 500);
    }

    /**
     * End time track
     */
    public function stop(SetTimetrackRequest $request)
    {
        return response('', $this->timetrackRepository->endTimer(auth()->user(), $request->project_id) ? 200 : 500);
    }

}
