<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserTimeRequest;
use App\Http\Traits\ConvertTimeZone;
use Illuminate\Support\Facades\DB;
use App\Models\Reminder;
use Carbon\Carbon;
use Inertia\Inertia;
use DateTime;

class ReminderController extends Controller
{
    use ConvertTimeZone;

    public function index()
    {
        $reminders = Reminder::query()
                        ->where('user_id', auth()->id())
                        ->whereNull('reminder_type')
                        ->get();

        return Inertia::render('Setting/Reminder',[
            'reminders' => $reminders,
        ]);
    }

    public function store(UpdateUserTimeRequest $request)
    {
        $reminder = auth()->user()->reminders()->create($request->validated());
        $reminder->update([
            'time' => $this->convertTimeZone(auth()->user()->timezone,Carbon::createFromFormat('H:i',$reminder->original_time)->toTimeString()),
            'timezone' => auth()->user()->timezone
        ]);
    }
    
    public function update(Reminder $reminder,UpdateUserTimeRequest $request)
    {
        DB::beginTransaction();
        try {
            $reminder->update($request->validated());
            $reminder->update([
                'time' => $this->convertTimeZone($reminder->timezone,Carbon::createFromFormat('H:i',$reminder->original_time)->toTimeString())
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
       
    }
    public function delete(Reminder $reminder)
    {
        $reminder->delete();
    }
    public function changeStatus(Reminder $reminder, Request $request)
    {
        $reminder->update([
            'status' => $request->status
        ]);
    }
    private function reformatTime($time)
    {
        $dateTime = new DateTime($time);
        return $dateTime->format("h:i A");
    }
}
