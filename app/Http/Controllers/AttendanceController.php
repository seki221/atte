<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use DateTime;

class AttendanceController extends Controller
{
    //「勤務開始」判定
    private function didWorkStart($user)
    {
        
        $oldAttendance = Attendance::where('user_id', $user->id)->latest()->first();
        
        if ($oldAttendance) {
            $oldAttendanceDay = new Carbon($oldAttendance->date);
            $today = Carbon::today();

            return ($oldAttendanceDay == $today) && ((!$oldAttendance->end_time));
        } else {
            return false;
        }
    }

    //「勤務終了」判定
    private function didWorkEnd()
    {
        $user = Auth::user();
        $oldAttendance = Attendance::where('user_id', $user->id)->latest()->first();
        $oldDay = '';

        if ($oldAttendance) {
            $oldDay = new Carbon($oldAttendance->date);
        }
        
        $today = Carbon::today();
        //休憩を最低1度以上「開始」と「終了」を両方選択している
        return ($oldDay == $today);
    }

    //「休憩中」判定
    private function didRestStart()
    {
        $user = Auth::user();
        $oldRest = '';
        $oldDay = '';

        if (Attendance::where('user_id', $user->id)->exists()) {
            $attendance = Attendance::where('user_id', $user->id)->latest()->first();

            if (Rest::where('attendance_id', $attendance->id)->exists()) {
                $oldRest = Rest::where('attendance_id', $attendance->id)->latest()->first();
            }

            if ($oldRest) {
                $oldRestStartTime = new Carbon($oldRest->start_time);
                $oldDay = $oldRestStartTime->startOfday();
            }

            $today = Carbon::today();

            //restsテーブルの最新のレコードが今日のデータ、かつ休憩終了がない（レコードがあるということは勤務開始＆休憩開始されている）
            return ($oldDay == $today) && (!$oldRest->end_time);
        }
    }

    //勤務時間-休憩時間の計算
    private function actualWorkTime($attendanceToday, $restTimeDiffInSecondsTotal)
    {
        //勤務時間の算出
        $attendanceStartTime = $attendanceToday->start_time;
        $attendanceStartTimeCarbon = new Carbon($attendanceToday->start_time);
        $attendanceEndTime = $attendanceToday->end_time;
        $attendanceEndTimeCarbon = new Carbon($attendanceToday->end_time);
        $workTimeDiffInSeconds = $attendanceEndTimeCarbon->diffInSeconds($attendanceStartTimeCarbon);
        $workTimeSeconds = floor($workTimeDiffInSeconds % 60);
        $workTimeMinutes = floor($workTimeDiffInSeconds / 60);
        $workTimeHours = floor($workTimeMinutes / 60);
        $workTime = $workTimeHours . ":" . $workTimeMinutes . ":" . $workTimeSeconds;

        //合算された休憩時間を整形する
        $restTimeSeconds = floor($restTimeDiffInSecondsTotal % 60);
        $restTimeMinutes = floor($restTimeDiffInSecondsTotal / 60);
        $restTimeHours = floor($restTimeMinutes / 60);
        $restTime = $restTimeHours . ":" . $restTimeMinutes . ":" . $restTimeSeconds;

        //実労働時間の算出
        $actualWorkTimeDiffInSeconds = $workTimeDiffInSeconds - $restTimeDiffInSecondsTotal;
        $actualWorkTimeSeconds = floor($actualWorkTimeDiffInSeconds % 60);
        $actualWorkTimeMinutes = floor($actualWorkTimeDiffInSeconds / 60);
        $actualTimeHours = floor($actualWorkTimeMinutes / 60);
        $actualWorkTime = $actualTimeHours . ":" . $actualWorkTimeMinutes . ":" . $actualWorkTimeSeconds;

        $userId = User::where('id', $attendanceToday->user_id)->first();
        $userName = $userId->name;
        
        $param = [
            'userName' => $userName,
            'attendanceStartTime' => $attendanceStartTime,
            'attendanceEndTime' => $attendanceEndTime,
            'restTime' => $restTime,
            'actualWorkTime' => $actualWorkTime,
        ];
        return $param;
    }

    //一つ一つの休憩について休憩時間を計算
    private function calculateRestTime($restToday)
    {
        $restStartTime = new Carbon($restToday->start_time);
        $restEndTime = new Carbon($restToday->end_time);
        $restTimeDiffInSeconds = $restEndTime->diffInSeconds($restStartTime);
        return $restTimeDiffInSeconds;
    }

    //打刻ページを表示
    public function index(){
        if (Auth::check()) {
            $user = Auth::user();
            $oldAttendance = Attendance::where('user_id', $user->id)->latest()->first();
            if ($oldAttendance) {
                
                $isWorkStarted = $this->didWorkStart($user);
                $isWorkEnded = $this->didWorkEnd();
                $isRestStarted = $this->didRestStart();
            } else {
                $isWorkStarted = false;
                $isWorkEnded = false;
                $isRestStarted = false;
            }

            $param = [
                'user' => $user,
                'isWorkStarted' => $isWorkStarted,
                'isWorkEnded' => $isWorkEnded,
                'isRestStarted' => $isRestStarted,
            ];
            return view('/index', $param);
        } else {
            return redirect('/login');
        }
    }

    //出勤アクション
    public function workStart()
    {
        $user = Auth::user();
        //「勤務開始」判定
        $isWorkStarted = $this->didWorkStart($user);

        //「勤務終了」判定
        $isWorkEnded = $this->didWorkEnd();

        Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'start_time' => Carbon::now(),
            'end_time'=>null,
        ]);

        return redirect()->back();

        
    }

    //退勤アクション
    public function workEnd()
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();
        
        if ($attendance) {
            if (is_null($attendance->end_time)) {
                $rest = Rest::where('attendance_id',$attendance->id)->latest()->first();
                if ($rest && $rest->start_time && !$rest->end_time) {
                    $rest->update([
                        'end_time' => Carbon::now(),
                    ]);
                }

                $attendance->update([
                    'end_time' => Carbon::now()
                ]);

                return redirect()->back();
            } 
        } else 
        {
            return redirect()->back();
        }
        return redirect()->back();
    }
    
    //休憩開始アクション
    public function restStart()
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();

        //「休憩中」判定
        $isRestStarted = $this->didRestStart();

        Rest::create([
            'attendance_id' => $attendance->id,
            'start_time' => Carbon::now(),
        ]);

        return redirect()->back()->with([
            'user' => $user,
            'isRestStarted' => $isRestStarted,
        ]);
    }

    //休憩終了アクション
    public function restEnd()
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();
        $oldRest = Rest::where('attendance_id', $attendance->id)->latest()->first();

        $isRestStarted = $this->didRestStart();

        //end_timeが存在しない場合は、end_timeを格納
        if ($oldRest->start_time && !$oldRest->end_time) {
            $oldRest->update([
                'end_time' => Carbon::now(),
            ]);
        }
        
        return redirect()->back()->with([
            'user' => $user,
            'isRestStarted' => $isRestStarted,
        ]);
    }
    
    //「日付一覧」で表示される、全ユーザーの日付別勤怠情報
    public function getAttendances(Request $request)
    {
        if(is_null($request->date)){
            $yesterday=Carbon::yesterday();
            $today=Carbon::today();
            $tomorrow = Carbon::tomorrow();
            

        }else {
            $today = new Carbon($request->date);
            $yesterday = (new Carbon($request->date))->subDay();
            $tomorrow = (new Carbon($request->date))->addDay();
        }
        // $prevOrNext = $request->changeDay;

        $resultArray[] = array();
        $i = 0;

        $attendanceTodayAll = Attendance::where('date', $today->format('Y-m-d'))->get();
        
        foreach ($attendanceTodayAll as $attendanceToday) {
            if ($attendanceToday->end_time) {
                $restTodayAll = Rest::where('attendance_id', $attendanceToday->id)->get();

                $restTimeDiffInSecondsTotal = 0;

                foreach ($restTodayAll as $restToday) {
                    $restTime = $this->calculateRestTime($restToday);
                    $restTimeDiffInSecondsTotal = $restTime;
                }

                $result = $this->actualWorkTime($attendanceToday, $restTimeDiffInSecondsTotal);
                $resultArray[$i] = $result;
                $i++;
            }
        }

        $attendances = $this->paginate($resultArray, 5, null, ['path' => "/attendance_list?date={$today->format('Y-m-d')}"]);
        // &changeDay={$prevOrNext}

        
        return view('/attendance_list')->with([
            'today' => $today,
            'yesterday' => $yesterday,
            'tomorrow' => $tomorrow,
            'attendances' => $attendances,
        ]);
    }
    
    //配列をページネート
    private function paginate($items, $perPage, $page, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage), 
            $items->count(), 
            $perPage, 
            $page, 
            $options);
    }

    //ユーザー一覧ページ(user_page)
    public function getUserList()
    {
        
        $getUsers = User::select('name', 'email')->get();

        $usersArray[] = array();
        $i = 0;

        foreach ($getUsers as $user) {
            $usersArray[$i] = $user;
            $i++;
        }

        $users = $this->paginate($usersArray, 10, null, ['path' => "/user_page"]);

        return view('/user_page')->with([
            'users' => $users
        ]);
    }

    //ユーザー別勤怠一覧の取得(user_list)
    public function listbyUser (Request $request){

        if (is_null($request->date)) {
            $today = Carbon::today();
        } else {
            $today = new Carbon($request->date);
        }

        $username = $request->name;
        $resultArray[] = array();
        $i = 0;

        $userInfo = User::where('name', $username)->first();
        $userId = $userInfo->id;
        $userAttendanceAll = Attendance::where('user_id', $userId)->get();


        foreach ($userAttendanceAll as $userAttendance) {
            if ($userAttendance->end_time) {
                $userRestAll = Rest::where(
                    'attendance_id',
                    $userAttendance->id
                )->get();

                $restTimeDiffInSecondsTotal = 0;

                foreach ($userRestAll as $userRest) {
                    $restTime = $this->calculateRestTime($userRest);
                    $restTimeDiffInSecondsTotal += $restTime;
                }

                $result = $this->actualWorkTime($userAttendance, $restTimeDiffInSecondsTotal);
                $resultArray[$i] = $result;
                $i++;
            }
        }
        
        $attendances = $this->paginate(
            $resultArray,
            5,
            null,
            ['path' => "/user_list?name={$username}"]
        );

        return view('/user_list')->with([
            'attendances' => $attendances,
            'userName' => $username,
            'today' => $today,
        ]);
    }
}


