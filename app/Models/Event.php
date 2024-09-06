<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\DB;


class Event extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'events';

    protected $appends = [
        'photo',
        'cover'
    ];

    public const ALLOW_GUESTS_RADIO = [
        '1' => 'Sim',
        '0' => 'Não',
    ];

    public const TYPE_RADIO = [
        '1' => 'Ilimitado',
        '0' => 'Limitado',
    ];

    public const VISUALIZATION_RADIO = [
        '1' => 'Público',
        '0' => 'Privado',
    ];

    protected $dates = [
        'start',
        'end',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'start',
        'end',
        'description',
        'rules',
        'link',
        'link_instruction',
        'pixel',
        'visualization',
        'type',
        'allow_guests',
        'capacity',
        'whatsapp',
        'whatsappmessage',
        'start_time',
        'end_time',
        'country',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getPhotoAttribute()
    {
        $files = $this->getMedia('photo');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function getCoverAttribute()
    {
        $file = $this->getMedia('cover')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getStartTimeAttribute($value)
    {
        if ($value) {
            return 'ás '.Carbon::createFromFormat('H:i:s', $value)->format('H:i');
        }

        return null;
    }

    public function getEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['end'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndTimeAttribute($value)
    {
        if ($value) {
            return 'ás '.Carbon::createFromFormat('H:i:s', $value)->format('H:i');
        }

        return null;
    }

    public function attendance_lists()
    {
        return $this->belongsToMany(Customer::class);
    }

    public function attendance($event, $customer)
    {
        return DB::table('customer_event')->where('event_id', $event)->where('customer_id', $customer)->exists();
    }

    public function guests($event, $customer)
    {
        return DB::table('customer_event_guests')->where('event_id', $event)->where('customer_id', $customer)->get();
    }

    public function attendanceList($event)
    {
        $event = $this->find($event);
        $event->load('attendance_lists');
        foreach ($event->attendance_lists as $att) {
            $att->checkin = DB::table('customer_event')
            ->where('event_id', $event->id)
            ->where('customer_id', $att->id)
            ->pluck('checkin')
            ->first();
            $att->guests = DB::table('customer_event_guests')
            ->where('event_id', $event->id)
            ->where('customer_id', $att->id)
            ->get();
        }

        return $event->attendance_lists;
    }

    public function attendanceListFull($event)
    {
        $event = $this->find($event);
        $event->load('attendance_lists');

        $fullList = [];

        foreach ($event->attendance_lists as $att) {
            $client = new \stdClass();
            $client->customerID = $att->id;
            $client->name = $att->name.' '.$att->surname;
            $client->checkin = DB::table('customer_event')
            ->where('event_id', $event->id)
            ->where('customer_id', $att->id)
            ->pluck('checkin')
            ->first();
            $client->type = 0;
            $fullList[] = $client;
            
            $guests = DB::table('customer_event_guests')
            ->where('event_id', $event->id)
            ->where('customer_id', $att->id)
            ->get();

            foreach ($guests as $guest) {
                $invited = new \stdClass();
                $invited->customerID = $att->id;
                $invited->customer = $att->name.' '.$att->surname;
                $invited->guestID = $guest->id;
                $invited->name = $guest->guest;
                $invited->checkin = $guest->checkin;
                $invited->type = 1;
                $fullList[] = $invited;
            }
        }

        return $fullList;
    }

    public function attendanceCount($event)
    {
        $customers = DB::table('customer_event')->where('event_id', $event)->count();
        $guests = DB::table('customer_event_guests')->where('event_id', $event)->count();
        return $customers + $guests;
    }

    public function attendanceCheckInCount($event)
    {
        $customers = DB::table('customer_event')->where('event_id', $event)->where('checkin', 1)->count();
        $guests = DB::table('customer_event_guests')->where('event_id', $event)->where('checkin', 1)->count();
        return $customers + $guests;
    }
}
