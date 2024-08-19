<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    public $table = 'customers';

    protected $dates = [
        'birthdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'surname',
        'phonenumber',
        'email',
        'birthdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function hasCustomer($phonenumber)
    {
        return $this->where('phonenumber', $phonenumber)->first()->id ?? false;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function attendanceListEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function guests($customerID, $eventID)
    {
        return DB::table('customer_event_guests')
        ->where('event_id', $event)
        ->where('customer_id', $customerID)
        ->puck('id', 'name');
    }

    public function getBirthdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdateAttribute($value)
    {
        $this->attributes['birthdate'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
