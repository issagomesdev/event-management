<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Customer;
use App\Models\Event;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::with(['attendance_lists', 'media'])->get();

        $customers = Customer::get();

        return view('admin.events.index', compact('customers', 'events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $event->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        if ($request->input('cover', false)) {
            $event->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $event->id]);
        }

        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('attendance_lists');

        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());

        if (count($event->photo) > 0) {
            foreach ($event->photo as $media) {
                if (! in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }
        $media = $event->photo->pluck('file_name')->toArray();
        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $event->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
            }
        }

        if ($request->input('cover', false)) {
            if (! $event->cover || $request->input('cover') !== $event->cover->file_name) {
                if ($event->cover) {
                    $event->cover->delete();
                }
                $event->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
            }
        } elseif ($event->cover) {
            $event->cover->delete();
        }

        return redirect()->route('admin.events.index');
    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceCount = $event->attendanceCount($event->id);
        $attendanceCheckInCount = $event->attendanceCheckInCount($event->id);
        $attendanceList = $event->attendanceList($event->id);
        $attendanceListFull = $event->attendanceListFull($event->id);

        return view('admin.events.show', compact('event', 'attendanceCount', 'attendanceCheckInCount', 'attendanceList', 'attendanceListFull'));
    }

    public function checkin($id, Customer $customer, Request $request)
    {

        $event = Event::where('id', $id)->with(['attendance_lists', 'media'])->first();
        $attendanceCount = $event->attendanceCount($event->id);
        $attendanceCheckInCount = $event->attendanceCheckInCount($event->id);
        $attendanceList = $event->attendanceList($event->id);
        $attendanceListFull = $event->attendanceListFull($event->id);

        return view('admin.events.checkin', compact('event', 'attendanceCount', 'attendanceCheckInCount', 'attendanceListFull', 'attendanceList'));
    }

    public function toCheckIn($id, $eventID, $action, $type)
    {
        if($type === "1"){
            DB::table('customer_event_guests')
            ->where('id', $id)
            ->update([
                'checkin' => $action
            ]);
        } else {
            DB::table('customer_event')
            ->where('customer_id', $id)
            ->where('event_id', $eventID)
            ->update([
                'checkin' => $action
            ]);
        }

        return response()->json(['message' => ' Sucess']);
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventRequest $request)
    {
        $events = Event::find(request('ids'));

        foreach ($events as $event) {
            $event->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('event_create') && Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Event();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
