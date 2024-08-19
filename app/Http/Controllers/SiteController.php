<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Event;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Customer $customer, Request $request)
    {
        $userID = $request->cookie('userID');
        $user = $userID? $customer->where('id', $userID)->first() : [];
        $events = Event::where('visualization', '1')
        ->whereDate('end', '>=', Carbon::now()->toDateString())
        ->orderBy('start', 'asc')
        ->orderBy('start_time', 'asc')
        ->with(['media'])
        ->get();

        return view('public.index', compact('user', 'events'));
    }

    public function EventDetails($id, $name, Customer $customer, Request $request)
    {
        $userID = $request->cookie('userID');
        $user = $userID? $customer->where('id', $userID)->first() : null;
        $event = Event::where('id', $id)->with(['attendance_lists', 'media'])->first();
        $isChecked = $userID? DB::table('customer_event')
        ->where('customer_id', $userID)
        ->where('event_id', $id)
        ->pluck("checkin")->first() : null;
        $attendance = $userID? $event->attendance($id, $userID) : false;
        $attendanceCount = $event->attendanceCount($id);
        $guests = $userID? $event->guests($id, $userID) : [];
        $eventEnd = Carbon::createFromFormat('d/m/Y', $event->end);
        $address = urlencode($event->street.",".$event->number.",".$event->neighborhood.",".$event->city.",".$event->state.",".$event->country);
        $open = $eventEnd->greaterThanOrEqualTo(Carbon::today());
        return view('public.events.details', compact('user', 'event', 'attendance', 'guests', 'attendanceCount', 'open', 'address', 'isChecked'));
    }

    public function AttendanceList($id, $name, Customer $customer, Request $request)
    {
        $userID = $request->cookie('userID');
        $user = $userID? $customer->where('id', $userID)->first() : null;
        $event = Event::where('id', $id)->with(['attendance_lists', 'media'])->first();
        $attendanceCount = $event->attendanceCount($event->id);
        $attendanceCheckInCount = $event->attendanceCheckInCount($event->id);
        $attendanceList = $event->attendanceList($event->id);
        $attendanceListFull = $event->attendanceListFull($event->id);

        return view('public.events.list', compact('user', 'event', 'attendanceCount', 'attendanceCheckInCount', 'attendanceListFull', 'attendanceList'));
    }

    public function CheckinList($id, Customer $customer, Request $request)
    {
        $userID = $request->cookie('userID');
        $user = $userID? $customer->where('id', $userID)->first() : null;
        $event = Event::where('id', $id)->with(['attendance_lists', 'media'])->first();
        $attendanceCount = $event->attendanceCount($event->id);
        $attendanceCheckInCount = $event->attendanceCheckInCount($event->id);
        $attendanceList = $event->attendanceList($event->id);
        $attendanceListFull = $event->attendanceListFull($event->id);

        return view('public.events.checkin', compact('user', 'event', 'attendanceCount', 'attendanceCheckInCount', 'attendanceListFull', 'attendanceList'));
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

    public function confirmAttendance($eventID, Request $request, Customer $customer)
    {
        //dd($request->all());
        $userID = $request->cookie('userID');
        $event = Event::where('id', $eventID)->with(['attendance_lists', 'media'])->first();
        $eventEnd = Carbon::createFromFormat('d/m/Y', $event->end);
        $open = $eventEnd->greaterThanOrEqualTo(Carbon::today());
        $attendanceCount = $event->attendanceCount($eventID);
        $name = str_replace(' ', '-', $event->name);
        if($userID){
            if($open){
                if(($event->type === '1' || $event->capacity > $attendanceCount)){
                    $exist = DB::table('customer_event')
                    ->where('event_id', $eventID)
                    ->where('customer_id', $userID)
                    ->first();

                    if(!$exist){
                        DB::table('customer_event')->insert([
                            'event_id' => $eventID,
                            'customer_id' => $userID
                        ]);
                    } 

                    return redirect("/event-details/$event->id/$name/#attendance")->with('success', 'Presença confirmada com sucesso!');
                    
                } else {
                    return redirect("/event-details/$event->id/$name")->with('error', 'Este evento atingiu sua capacidade máxima!');
                }
            } else {
                return redirect("/event-details/$event->id/$name")->with('error', 'Este evento já encerrou!');
            }
        } else if($request->phonenumber){
            $phonenumber = preg_replace('/[^0-9]/', '', $request->phonenumber);
            $customerID = $customer->hasCustomer($phonenumber);

            if($customerID){
                Customer::where('id', $customerID)->update([
                    'name' => $request->name,
                    'surname' => $request->surname
                ]);

                $userID = $customerID;
            } else {
                $customer = Customer::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'phonenumber' => $request->phonenumber
                ]);

                $userID = $customer->id;
            }

            Cookie::queue('userID', $userID, 120);

            if($open){
                if(($event->type === '1' || $event->capacity > $attendanceCount)){
                    $exist = DB::table('customer_event')
                    ->where('event_id', $eventID)
                    ->where('customer_id', $userID)
                    ->first();

                    if(!$exist){
                        DB::table('customer_event')->insert([
                            'event_id' => $eventID,
                            'customer_id' => $userID
                        ]);
                    } 

                    return redirect("/event-details/$event->id/$name/#attendance")->with('success', 'Presença confirmada com sucesso!');
                    
                } else {
                    return redirect("/event-details/$event->id/$name")->with('error', 'Este evento atingiu sua capacidade máxima!');
                }
            } else {
                return redirect("/event-details/$event->id/$name")->with('error', 'Este evento já encerrou!');
            }
        } else {
            // return redirect()->route('customers.login', ['eventID' => $eventID]);
            return redirect()->route('site.event.details', ['id' => $eventID, 'name' => str_replace(' ', '-', $event->name), 'login_model' => true]);
        }
    }

    public function redirectWhatsapp(Request $request){
        return redirect("https://wa.me/$request->whatsapp?text=$request->message");
    }

    public function saveGuests($eventID, Request $request)
    {
        $data = json_decode($request->input('guests'));
        $userID = $request->cookie('userID');
        $event = Event::where('id', $eventID)->with(['attendance_lists', 'media'])->first();
        $eventEnd = Carbon::createFromFormat('d/m/Y', $event->end);
        $open = $eventEnd->greaterThanOrEqualTo(Carbon::today());
        $attendanceCount = $event->attendanceCount($eventID);
        $name = str_replace(' ', '-', $event->name);
        if($userID){
            if($open){
                if(($event->type === '1' || $event->capacity > $attendanceCount)){
                    // foreach ($data as $guest) {
                    //     if(isset($guest->guestID)){
                    //         if(isset($guest->delete)){
                    //             DB::table('customer_event_guests')
                    //             ->where('id', $guest->guestID)
                    //             ->delete();
                    //         } else {
                    //             DB::table('customer_event_guests')
                    //             ->where('id', $guest->guestID)
                    //             ->update([
                    //                 'guest' => $guest->name
                    //             ]);
                    //         }
                    //     } else {

                    //         $exist = DB::table('customer_event_guests')
                    //         ->where('event_id', $eventID)
                    //         ->where('customer_id', $userID)
                    //         ->where('guest', $guest->name)
                    //         ->first();

                    //         if(!$exist){
                    //             DB::table('customer_event_guests')->insert([
                    //                 'event_id' => $eventID,
                    //                 'customer_id' => $userID,
                    //                 'guest' => $guest->name
                    //             ]);
                    //         }
                    //     }
                    // }
                    return redirect("/event-details/$event->id/$name/#attendance")->with('success', 'Lista salva com sucesso!');
                } else {
                    return redirect("/event-details/$event->id/$name")->with('error', 'Este evento atingiu sua capacidade máxima!');
                }

            } else {
                return redirect("/event-details/$event->id/$name")->with('error', 'Este evento já encerrou!');
            }
        } else {
            return redirect()->route('customers.login', ['eventID' => $eventID]);
        }

    }

    public function addGuest(Request $request, $eventID, $customerID){
        $exist = DB::table('customer_event_guests')
        ->where('event_id', $eventID)
        ->where('customer_id', $customerID)
        ->where('guest', $request->name)
        ->first();

        if(!$exist){
            $id = DB::table('customer_event_guests')->insertGetId([
                'event_id' => $eventID,
                'customer_id' => $customerID,
                'guest' => $request->name
            ]);

            return response()->json(['message' => 'sucess', 'guestID' => $id]);
        }

        return response()->json(['message' => 'sucess']);
    }

    public function deleteGuest(Request $request, $guestID){
        DB::table('customer_event_guests')
        ->where('id', $guestID)
        ->delete();

        return response()->json(['message' => 'sucess']);
    }

    public function CustomerLogin(Customer $customer, Request $request)
    {
        $userID = $request->cookie('userID');
        $user = $userID? $customer->where('id', $userID)->first() : false;
        $eventID = $request->eventID;
        if($user){
            if($eventID){
                $event = Event::where('id', $eventID)->first();
                return redirect()->route('site.event.details', ['id' => $eventID, 'name' => str_replace(' ', '-', $event->name)]);
            } else {
                return redirect()->route('site.home');
            }
        } else {
            return view('public.customer-form', [
                'register' => false,
                'eventID' => $eventID
            ]);
        }
    }

    public function CustomerRegister(Customer $customer, Request $request)
    {
        $userID = $request->cookie('userID');
        $user = $userID? $customer->where('id', $userID)->first() : false;
        $eventID = $request->eventID;
        if($user){
            if($eventID){
                $event = Event::where('id', $eventID)->first();
                return redirect()->route('site.event.details', ['id' => $eventID, 'name' => str_replace(' ', '-', $event->name)]);
            } else {
                return redirect()->route('site.home');
            }
        } else {
            return view('public.customer-form', [
                'register' => true,
                'code' => $request->code,
                'ddd' => $request->ddd,
                'number' => $request->number,
                'phonenumber' => $request->phonenumber,
                'birthdate' => $request->birthdate,
                'eventID' => $eventID
            ]);
        }
    }

    public function CustomerLogout()
    {
        Cookie::queue(Cookie::forget('userID'));
        return redirect()->route('site.home');
    }

    public function CustomerStore(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());
        Cookie::queue('userID', $customer->id, 120);
        $eventID = $request->eventID;
        if($eventID){
            $event = Event::where('id', $eventID)->first();
            return redirect()->route('site.event.details', ['id' => $eventID, 'name' => str_replace(' ', '-', $event->name)]);
        } else {
            return redirect()->route('site.home');
        }
    }
    
    public function verifyCustomer(Customer $customer, Request $request)
    {
        $phonenumber = preg_replace('/[^0-9]/', '', $request->phonenumber);
        $customerID = $customer->hasCustomer($phonenumber);
        // $birthdate = Carbon::createFromFormat('d/m/Y', $request->birthdate);

        // $verifyBirth = $customer->where('id', $customerID)
        // ->where('birthdate', $birthdate->format('Y-m-d'))
        // ->first();
        $eventID = $request->eventID;

        if($customerID){
            Cookie::queue('userID', $customerID, 120);
            if($eventID){
                $event = Event::where('id', $eventID)->first();
                return redirect()->route('site.event.details', ['id' => $eventID, 'name' => str_replace(' ', '-', $event->name)]);
            } else {
                return redirect()->route('site.home');
            }

            // if($verifyBirth){
            // } else {
            //     return redirect()->route('customers.login', ['eventID' => $eventID])->with('error', 'Dados incompatíveis');
            // }
        } else {
            return redirect()->route('customers.register', ['code' => $request->code, 'ddd' => $request->ddd, 'number' => $request->number, 'phonenumber' => $request->phonenumber, 'eventID' => $eventID]);
        }
    }
}
