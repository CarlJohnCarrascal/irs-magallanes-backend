<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Informant;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use App\Models\Responder;
use DateTime;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Validation\Validator;
use Validator;

class IncidentController extends BaseController
{
    public function index(Request $request)
    {
        $r = $request->all();
        $s = $r['r'];
        $t = $r['t'];
        $my = $r['my'];
        $id = auth('api')->user()->id;
        $q = null;
        if ($s == 'today') {
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            if ($t == 'pending') {
                $q = Incident::whereDate('datetime','=' ,$from_date)->where('status', '=', 'pending');
            }else {
                 $q = Incident::whereDate('datetime','=' ,$from_date)->where('status', '!=', 'pending');
            }
            //return $this->sendResponse(Incident::whereDate('datetime','=' ,$from_date), 'Incident List.' . $from_date .' '. $to_date);
        }
        if ($s == 'week') {
            $week_start = date("Y-m-d", strtotime('monday this week'));
            $week_end = date("Y-m-d", strtotime('sunday this week'));
            if ($t == 'pending') {
                $q = Incident::whereBetween('datetime', [$week_start, $week_end])->where('status', '=', 'pending');
            }else {
                $q = Incident::whereBetween('datetime', [$week_start, $week_end])->where('status', '!=', 'pending');
            }
            //return $this->sendResponse(Incident::whereBetween('datetime', [$week_start, $week_end])->get(), 'Incident List.' . $week_start . '/'. $week_end);
        }
        if ($s == 'month') {
            $month_start = date('Y-m-01');
            $month_end = date('Y-m-t');
            if ($t == 'pending') {
                $q = Incident::whereBetween('datetime', [$month_start, $month_end])->where('status', '=', 'pending');
            }else {
                $q = Incident::whereBetween('datetime', [$month_start, $month_end])->where('status', '!=', 'pending');
            }
            //return $this->sendResponse(Incident::whereBetween('datetime', [$month_start, $month_end])->get(), 'Incident List.' . $month_start . '/'. $month_end);
        }
        if ($s == 'year') {
            $year = date('Y');
            if ($t == 'pending') {
                $q = Incident::whereYear('datetime', $year)->where('status', '=', 'pending');
            }else {
                $q = Incident::whereYear('datetime', $year)->where('status', '!=', 'pending');
            }
        }
        if($s == 'all'){
            if ($t == 'pending') {
                $q = Incident::where('status', '=', 'pending');
            }
            else{
                $q = Incident::where('status', '!=', 'pending');
            }
            //return $this->sendResponse(Incident::all(), 'Incident List.');            
        }
        $cc = '';
        if($s == 'custom'){
            $cd1 = $r['cd1'];
            $cd2 = $r['cd2'];
            $date_start = date("Y-m-d", $cd1);
            $date_end = date("Y-m-d", $cd2);
            if ($t == 'pending') {
                $q = Incident::whereBetween('datetime', [$date_start, $date_end])
                ->where('status', '=', 'pending');
            }else {
                $q = Incident::whereBetween('datetime', [$date_start, $date_end])
                ->where('status', '!=', 'pending');
            }
            $cc = $date_start . "-" . $date_end . "-" . $my;
        }   
        if ($my == "true"){
            return $this->sendResponse($q->where('userid','=', $id)->get(), 'Incident List.' . $cc);           
        }
        return $this->sendResponse($q->get(), 'Incident List.' . $cc);           

    }
    public function show(Incident $incident)
    {
        return $this->sendResponse($incident, 'Incident Details.');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'barangay' => 'required',
            'purok' => 'required',
            'datetime' => 'required',
            'severity' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incident Validation Error.', $validator->errors());
        }
        $input = $request->all();
        //return $this->sendResponse($input, 'Incident Store successfully.' . json_encode($input['informant']));

        $input['userid'] = auth('api')->user()->id;
        if (auth('api')->user()->role == 'admin') {
            $input['status'] = 'on process';
        }else{
            $input['status'] = 'pending';
        }
        $input['causes'] = '';
        $incident = Incident::create($input);

        $validator = Validator::make($input['informant'], [
            'name' => 'required',
            'date_of_call' => 'required',
            'time_of_call' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            Incident::destroy($incident->id);
            return $this->sendError('INformant Validation Error.', $validator->errors());
        }
        $in['incidentid'] = $incident->id;
        $in['name'] = $input['informant']['name'];
        $in['address'] = $input['informant']['address'];
        $in['phone'] = $input['informant']['phone'];
        $in['date_of'] = $input['informant']['date_of_call'];
        $in['time_of'] = $input['informant']['time_of_call'];
        $informant = Informant::create($in);

        $hasP = count($input['patients']);
        if ($hasP > 0) {
            for ($i = 0; $i < $hasP; $i++) {
                # code...
                $p = $input['patients'][$i];
                $validator = Validator::make($p, [
                    'name' => 'required',
                    'address' => 'required',
                    'age' => 'required',
                    'gender' => 'required',
                    'status' => 'required',
                    'cause' => 'required',
                ]);
                if ($validator->fails()) {
                    Informant::destroy($informant->id);
                    Incident::destroy($incident->id);
                    return $this->sendError('Patient Validation Error.', $validator->errors());
                }
                $pa['incidentid'] = $incident->id;
                $pa['name'] = $p['name'];
                $pa['address'] = $p['address'];
                $pa['age'] = $p['age'];
                $pa['gender'] = $p['gender'];
                $pa['cause'] = $p['cause'];
                $pa['status'] = $p['status'];
                $patient = Patient::create($pa);
                $incident['patientsdetail'] = $patient;
            }
        }

        $re['incidentid'] = $incident->id;
        $respo = $input['responder'];
        $re['leader'] = $respo['leader'];
        $re['driver'] = $respo['driver'];
        $re['member1'] = $respo['member1'];
        $re['member2'] = $respo['member2'];
        $re['member3'] = $respo['member3'];
        $re['member4'] = $respo['member4'];
        $re['member5'] = $respo['member5'];
        $re['member6'] = $respo['member6'];
        $re['member7'] = $respo['member7'];
        $re['member8'] = $respo['member8'];
        $re['member9'] = $respo['member9'];
        $re['member10'] = $respo['member10'];

        $responder = Responder::create($re);

        $incident['informantdetail'] = $informant;
        $incident['responderdetail'] = $responder;

        if (auth('api')->user()->role == 'user') {
            $nfor = 'all';
            $ntype = 'Report';
            $nmsg = 'New incident reported happen in '. $incident->barangay;
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }
        if (auth('api')->user()->role == 'admin') {
            $nfor = 'user';
            $ntype = 'Report';
            $nmsg = 'New incident reported happen in '. $incident->barangay;
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }
        return $this->sendResponse($incident, 'Incident Store successfully.');
        //return response()->json("Incident Stored");
    }
    public function update(Request $request, Incident $incident)
    {
        $id = auth('api')->user()->id;
        $role = auth('api')->user()->role;

        if($role == 'admin' || $id == $incident->userid){
        }else {
            return $this->sendError('Unauthorised.', ['error' => 'You are not allowed for this operation!']);
        }

        $fails = false;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'barangay' => 'required',
            'purok' => 'required',
            'datetime' => 'required',
            'severity' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['causes'] = '';


        $validator = Validator::make($input['informant'], [
            'name' => 'required',
            'date_of_call' => 'required',
            'time_of_call' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('INformant Validation Error.', $validator->errors());
        }

        $in['incidentid'] = $incident->id;
        $in['name'] = $input['informant']['name'];
        $in['address'] = $input['informant']['address'];
        $in['phone'] = $input['informant']['phone'];
        $in['date_of'] = $input['informant']['date_of_call'];
        $in['time_of'] = $input['informant']['time_of_call'];

        $hasP = count($input['patients']);
        if ($hasP > 0) {
            for ($i = 0; $i < $hasP; $i++) {
                # code...
                $p = $input['patients'][$i];
                $validator = Validator::make($p, [
                    'name' => 'required',
                    'address' => 'required',
                    'age' => 'required',
                    'gender' => 'required',
                    'status' => 'required',
                    'cause' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Patient Validation Error.', $validator->errors());
                }
                $pa['incidentid'] = $incident->id;
                $pa['name'] = $p['name'];
                $pa['address'] = $p['address'];
                $pa['age'] = $p['age'];
                $pa['gender'] = $p['gender'];
                $pa['cause'] = $p['cause'];
                $pa['status'] = $p['status'];
                Patient::where('incidentid', $incident->id)->delete();
                $patient = Patient::create($pa);
            }
        }

        $respo = $input['responder'];
        $re['leader'] = $respo['leader'];
        $re['driver'] = $respo['driver'];
        $re['member1'] = $respo['member1'];
        $re['member2'] = $respo['member2'];
        $re['member3'] = $respo['member3'];
        $re['member4'] = $respo['member4'];
        $re['member5'] = $respo['member5'];
        $re['member6'] = $respo['member6'];
        $re['member7'] = $respo['member7'];
        $re['member8'] = $respo['member8'];
        $re['member9'] = $respo['member9'];
        $re['member10'] = $respo['member10'];

        Responder::where('incidentid', $incident->id)->update($re);

        Informant::where('incidentid', $incident->id)->update($in);
        $incident->update($input);

        if ($id == $incident->userid && $role == 'user') {
            $nfor = 'admin';
            $ntype = 'Report';
            $nmsg = 'A user update his report from'. $incident->barangay;
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }
        if ($id != $incident->userid && $role == 'admin') {
            $nfor = $incident->userid;
            $ntype = 'Report';
            $nmsg = 'The admin has updated your report.';
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }

        return $this->sendResponse($incident, 'Incident Updated successfully.');
    }
    public function destroy(Incident $incident)
    {
        $id = auth('api')->user()->id;
        $role = auth('api')->user()->role;

        if($role == 'admin' || $id == $incident->userid)
        {
            if ($id == $incident->userid && $incident->status == 'pending'){
                return $this->sendError('Unauthorised.', ['error' => 'You are not allowed for this operation!']);
            }
            DB::table('patients')
            ->where('incidentid',$incident->id)
            ->delete();
            DB::table('informants')
            ->where('incidentid',$incident->id)
            ->delete();
            DB::table('responders')
            ->where('incidentid',$incident->id)
            ->delete();
            $incident->delete();    

            if ($id != $incident->userid) {
                $nfor = $incident->userid;
                $ntype = 'Report';
                $nmsg = 'The admin has deleted your report';
                $nid = $incident->id;
                $this->addToNotification($nfor, $ntype, $nmsg, $nid);
            }

            return $this->sendResponse('', 'Incident deleted successfully!.');
        }else {
            return $this->sendError('Unauthorised.', ['error' => 'You are not allowed for this operation!']);
        }

        
    }
    public function updatestatus(Request $request, Incident $incident)
    {
        $input = $request->all();
        $input['status'] = $input['status'];
        $incident->update($input);

        $id = auth('api')->user()->id;
        if ($id != $incident->userid) {
            $nfor = $incident->userid;
            $ntype = 'Report';
            $nmsg = 'The admin has change the status of your report.';
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }

        return $this->sendResponse($incident, 'Incident status changed successfully.');
    }
    public function viewed(Incident $incident)
    {
        $input['seened_at'] = now();
        $incident->update($input);
        $id = auth('api')->user()->id;
        if ($id != $incident->userid) {
            $nfor = $incident->userid;
            $ntype = 'Report';
            $nmsg = 'Your report has been seen by the admin.';
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }
        return $this->sendResponse($incident, 'Incident Updated successfully.');
    }
    public function accept(Incident $incident)
    {
        $input['status'] = 'approved';
        $input['accepted_at'] = now();
        $incident->update($input);

        $id = auth('api')->user()->id;
        if ($id != $incident->userid) {
            $nfor = $incident->userid;
            $ntype = 'Report';
            $nmsg = 'Your report has been approved by the admin.';
            $nid = $incident->id;
            $this->addToNotification($nfor, $ntype, $nmsg, $nid);
        }
        return $this->sendResponse($incident, 'Incident Updated successfully.');
    }

    public function getpatients(Request $request){

        $r = $request->all();
        $s = $r['r'];
        $q = null;
        if ($s == 'today') {
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            //$q = Patient::all()->where('incident_date','=' ,$from_date);
            //$q = Patient::all();
            $q = DB::table('patients')
            ->select('patients.*','incidents.datetime as incident_date','incidents.type as incident_type')
            ->join('incidents','incidents.id','=','patients.incidentid')
            ->whereDate('datetime','=', $from_date)
            ->get();
        }
        if ($s == 'week') {
            $week_start = date("Y-m-d", strtotime('monday this week'));
            $week_end = date("Y-m-d", strtotime('sunday this week'));
            //$q = Patient::whereBetween('incident_date', [$week_start, $week_end])->get();
            $q = DB::table('patients')
            ->select('patients.*','incidents.datetime as incident_date','incidents.type as incident_type')
            ->join('incidents','incidents.id','=','patients.incidentid')
            ->whereBetween('incidents.datetime',[$week_start, $week_end])
            ->get();
        }
        if ($s == 'month') {
            $month_start = date('Y-m-01');
            $month_end = date('Y-m-t');
            //$q = Patient::whereBetween('incident_date', [$month_start, $month_end])->get();
            $q = DB::table('patients')
            ->select('patients.*','incidents.datetime as incident_date','incidents.type as incident_type')
            ->join('incidents','incidents.id','=','patients.incidentid')
            ->whereBetween('incidents.datetime',[$month_start, $month_end])
            ->get();
        }
        if ($s == 'year') {
            $year = date('Y');
            //$q = Patient::whereYear('incident_date', $year)->get();
            $q = DB::table('patients')
            ->select('patients.*','incidents.datetime as incident_date','incidents.type as incident_type')
            ->join('incidents','incidents.id','=','patients.incidentid')
            ->whereYear('incidents.datetime',$year)
            ->get();
        }
        if($s == 'all'){        
            return $this->sendResponse(Patient::all(),'patient list');
        }
        $cc = '';
        if($s == 'custom'){
            $cd1 = $r['cd1'];
            $cd2 = $r['cd2'];
            $date_start = date("Y-m-d", $cd1);
            $date_end = date("Y-m-d", $cd2);
            $q = DB::table('patients')
            ->select('patients.*','incidents.datetime as incident_date','incidents.type as incident_type')
            ->join('incidents','incidents.id','=','patients.incidentid')
            ->whereBetween('incidents.datetime',[$date_start, $date_end])
            ->get();

            $cc = $date_start . "-" . $date_end;
        }

        return $this->sendResponse($q, 'Patient List.'. $cc);
    }
}
