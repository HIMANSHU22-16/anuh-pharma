<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OOS;
use App\Models\User;
use App\Models\Capa;
use App\Models\RoleGroup;
use App\Models\Oosgrids;
use App\Models\OosAuditTrial;
use App\Services\Qms\OOSService;
use App\Models\RecordNumber;
use App\Models\Division;
use App\Models\ActionItem;
use App\Models\QMSDivision;
use App\Models\Extension;
use Carbon\Carbon;
use Error;
use Helpers;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class OOSController extends Controller
{
    public function index()
    {
        $cft = [];

        $old_records = OOS::select('id', 'division_id', 'record')->get();
        $old_record = ActionItem::select('id', 'division_id', 'record')->get();
        $capa_record = Capa::select('id', 'division_id', 'record')->get();
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();

        $users = User::get();
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date= $formattedDate->format('Y-m-d');
        // $changeControl = OpenStage::find(1);
        //  if(!empty($changeControl->cft)) $cft = explode(',', $changeControl->cft);
        return view("frontend.oos.oos-form", compact('due_date', 'record', 'old_records', 'cft','old_record','capa_record','users'));

    }
    
    public function store(Request $request)
    { 
        
        $res = Helpers::getDefaultResponse();

        try {
            
            $oos_record = OOSService::create_oss($request);

            if ($oos_record['status'] == 'error')
            {
                throw new Error($oos_record['message']);
            } 

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
            info('Error in OOSController@store', [
                'message' => $e->getMessage()
            ]);
        }
        

        // $oos_id = $data->id;


        return redirect(url('rcms/qms-dashboard'));
    }


    public static function show($id)
    {
        $cft = [];
        $revised_date = "";
        $data = OOS::find($id);
        $users = User::get();
        $currentDate = Carbon::now();
        $old_record = OOS::select('id', 'division_id', 'record')->get();
        // $revised_date = Extension::where('parent_id', $id)->where('parent_type', "OOS Chemical")->value('revised_date');
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');

        $info_product_materials = $data->grids()->where('identifier', 'info_product_material')->first();
        $details_stability = $data->grids()->where('identifier', 'details_stability')->first();
        $oos_details = $data->grids()->where('identifier', 'oos_detail')->first();
        $decodedData = is_string($oos_details->data) 
        ? json_decode($oos_details->data, true) 
        : $oos_details->data;

        $checklist_IB_invs = $data->grids()->where('identifier', 'checklist_IB_inv')->first();
        $instrument_detail = $data->grids()->where('identifier', 'instrument_detail')->first();
        $phase_two_invs = $data->grids()->where('identifier', 'phase_two_inv')->first();
        $oos_conclusions = $data->grids()->where('identifier', 'oos_conclusion')->first();
        $phase_iii_result = $data->grids()->where('identifier', 'phase_iii_result')->first();
        $phase_iii_result_i = $data->grids()->where('identifier', 'phase_iii_result_i')->first();
        $oos_conclusion_reviews = $data->grids()->where('identifier', 'oos_conclusion_review')->first();
        return view('frontend.OOS.oos_form_view', 
        compact('data', 'old_record','revised_date','cft' , 'info_product_materials', 'details_stability', 'oos_details','decodedData', 'checklist_IB_invs', 'instrument_detail', 'phase_two_invs', 'oos_conclusions', 'oos_conclusion_reviews','users','phase_iii_result','phase_iii_result_i'));

    }

    public function update(Request $request, $id)
    {
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return redirect()->back();
        // }
        $res = Helpers::getDefaultResponse();

        try {
            
            $oos_record = OOSService::update_oss($request,$id);

            if ($oos_record['status'] == 'error')
            {
                throw new Error($oos_record['message']);
            } 

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
            info('Error in OOSController@store', [
                'message' => $e->getMessage()
            ]);
        }
        toastr()->success('Record is Update Successfully');
        return back();
        // return redirect()->route('qms.dashboard');
        
        
    }

    public function send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changestage = OOS::find($id);
            $lastDocument = OOS::find($id);
            if ($changestage->stage == 1) {
                $changestage->stage = "2";
                $changestage->status = "HOD Primary Review";
                $changestage->completed_by_pending_initial_assessment = Auth::user()->name;
                $changestage->completed_on_pending_initial_assessment = Carbon::now()->format('d-M-Y');
                $changestage->comment_pending_initial_assessment = $request->comment;
                                $history = new OosAuditTrial();
                                $history->oos_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->current = $changestage->completed_by_pending_initial_assessment;
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->origin_state = $lastDocument->status;
                                $history->stage = "Completed";
                                $history->action = 'submit';
                                $history->change_to ="HOD Primary Review";
                                $history->save();
                            //     $list = Helpers::getLeadAuditeeUserList();
                            //     foreach ($list as $u) {
                            //         if($u->q_m_s_divisions_id == $changestage->division_id){
                            //             $email = Helpers::getInitiatorEmail($u->user_id);
                            //              if ($email !== null) {
                                      
                            //               Mail::send(
                            //                   'mail.view-mail',
                            //                    ['data' => $changestage],
                            //                 function ($message) use ($email) {
                            //                     $message->to($email)
                            //                         ->subject("Document sent ".Auth::user()->name);
                            //                 }
                            //               );
                            //             }
                            //      } 
                            //   }
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 2) {
                $changestage->stage = "3";
                $changestage->status = "CQA/QA Head Primary Review";
                $changestage->completed_by_under_phaseI_investigation = Auth::user()->name;
                $changestage->completed_on_under_phaseI_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseI_investigation = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    // $history->stage = "Lab Supervisor";
                    $history->action = 'submit';
                    $history->change_to ="CQA/QA Head Primary Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 3) {
                $changestage->stage = "4";
                $changestage->status = "Under Phase-IA Investigation";
                $changestage->completed_by_under_phaseIB_investigation = Auth::user()->name;
                $changestage->completed_on_under_phaseIB_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseIB_investigation = $request->comment;
                            $history = new OosAuditTrial();
                            $history->oos_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->completed_by_under_phaseIB_investigation;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Lab Supervisor";
                            $history->save();
                        
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 4) {
                $changestage->stage = "5";
                $changestage->status = "Phase IA HOD Primary Review";
                $changestage->completed_by_under_hypothesis = Auth::user()->name;
                $changestage->completed_on_under_hypothesis = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_hypothesis = $request->comment;

                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_hypothesis;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Final Approval";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 5) {
                $changestage->stage = "6";
                $changestage->status = "Phase IA QA/CQA Review";
                $changestage->completed_by_under_phaseII_investigation = Auth::user()->name;
                $changestage->completed_on_under_phaseII_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseII_investigation = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Under Phase II investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 6) {
                $changestage->stage = "7";
                $changestage->status = "P-IA CQAH/QAH Review";
                $changestage->completed_by_under_manufacturing_investigation_phaseIIA = Auth::user()->name;
                $changestage->completed_on_under_manufacturing_investigation_phaseIIA = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_manufacturing_investigation_phaseIIA = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 7) {
                $changestage->stage = "8";
                $changestage->status = "Under Phase-IB Investigation";
                $changestage->completed_by_under_phaseIIB_additional_lab_investigation= Auth::user()->name;
                $changestage->completed_on_under_phaseIIB_additional_lab_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseIIB_additional_lab_investigation = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 8) {
                $changestage->stage = "9";
                $changestage->status = "Phase IB HOD Primary Review";
                $changestage->completed_by_under_phaseIII_investigation= Auth::user()->name;
                $changestage->completed_on_under_phaseIII_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseIII_investigation = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 9) {
                $changestage->stage = "10";
                $changestage->status = "Phase IB QA/CQA Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;

                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_phaseIII_investigation;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Approval Completed";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
           
            if ($changestage->stage == 10) {
                $changestage->stage = "11";
                $changestage->status = "P-IB CQAH/QAH Review";
                $changestage->completed_by_close_done= Auth::user()->name;
                $changestage->completed_on_close_done = Carbon::now()->format('d-M-Y');
                $changestage->comment_close_done = $request->comment;
                
                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_phaseIII_investigation;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 11) {
                $changestage->stage = "12";
                $changestage->status = "Under Phase-II A Investigation";
                $changestage->completed_by_assignable_cause = Auth::user()->name;
                $changestage->completed_on_assignable_cause = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_assignable_cause = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    // $history->stage = "Lab Supervisor";
                    $history->action = 'submit';
                    $history->change_to ="Under Phase-II A Investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 12) {
                $changestage->stage = "13";
                $changestage->status = "Phase II A HOD Primary Review";
                $changestage->completed_by_phase2_A = Auth::user()->name;
                $changestage->completed_on_phase2_A = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_A = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    // $history->stage = "Lab Supervisor";
                    $history->action = 'submit';
                    $history->change_to ="Phase II A HOD Primary Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 13) {
                $changestage->stage = "14";
                $changestage->status = "Phase II A QA/CQA Review";
                $changestage->completed_by_phase2_hod_review = Auth::user()->name;
                $changestage->completed_on_phase2_hod_review = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_hod_review = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    // $history->stage = "Lab Supervisor";
                    $history->action = 'submit';
                    $history->change_to ="Phase II A QA/CQA Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 14) {
                $changestage->stage = "15";
                $changestage->status = "P-II A QAH/CQAH Review";
                $changestage->completed_by_phase2_cqa_qa = Auth::user()->name;
                $changestage->completed_on_phase2_cqa_qa = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_cqa_qa = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    // $history->stage = "Lab Supervisor";
                    $history->action = 'submit';
                    $history->change_to ="P-II A QAH/CQAH Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 15) {
                $changestage->stage = "16";
                $changestage->status = "Under Phase-II B Investigation";
                $changestage->completed_by_phase2_assignable_cause_not = Auth::user()->name;
                $changestage->completed_on_phase2_assignable_cause_not = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_assignable_cause_not = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_phase2_assignable_cause_not;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    // $history->stage = "Lab Supervisor";
                    $history->action = 'submit';
                    $history->change_to ="Under Phase-II B Investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 16) {
                $changestage->stage = "17";
                $changestage->status = "Phase II B HOD Primary Review";
                $changestage->completed_by_phase2_b_hod_primary = Auth::user()->name;
                $changestage->completed_on_phase2_b_hod_primary = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_b_hod_primary = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->action = 'submit';
                    $history->change_to ="Phase II B HOD Primary Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 17) {
                $changestage->stage = "18";
                $changestage->status = "Phase II B QA/CQA Review";
                $changestage->completed_by_phase2_b_hod_review = Auth::user()->name;
                $changestage->completed_on_phase2_b_hod_review = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_b_hod_review = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->action = 'submit';
                    $history->change_to ="Phase II B QA/CQA Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }


            if ($changestage->stage == 18) {
                $changestage->stage = "19";
                $changestage->status = "P-II B QAH/CQAH Review";
                $changestage->completed_by_phase2_b_cqa_qa_review = Auth::user()->name;
                $changestage->completed_on_phase2_b_cqa_qa_review = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_b_cqa_qa_review = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->action = 'submit';
                    $history->change_to ="P-II B QAH/CQAH Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }


            if ($changestage->stage == 19) {
                $changestage->stage = "20";
                $changestage->status = "Closed - Done";
                $changestage->completed_by_phase2_b_assignable_couse_not = Auth::user()->name;
                $changestage->completed_on_phase2_b_assignable_couse_not = Carbon::now()->format('d-M-Y');
                $changestage->comment_phase2_b_assignable_couse_not = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->action = 'submit';
                    $history->change_to = "Closed - Done";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }


        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    // ========== requestmoreinfo_back_stage ==============
    public function requestmoreinfo_back_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changestage = OOS::find($id);
            $lastDocument = OOS::find($id);
            if ($changestage->stage == 2) {
                $changestage->stage = "1";
                $changestage->status = "Opened";
                $changestage->moreinfo_hod_primary_by = Auth::user()->name;
                $changestage->moreinfo_hod_primary_on = Carbon::now()->format('d-M-Y');
                $changestage->moreinfo_hod_primary_comment = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_pending_initial_assessment;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 3) {
                $changestage->stage = "2";
                $changestage->status = "Pending Initial Assessment & Lab Incident";
                $changestage->moreinfo_cqa_qahead_primary_by = Auth::user()->name;
                $changestage->moreinfo_cqa_qahead_primary_on = Carbon::now()->format('d-M-Y');
                $changestage->moreinfo_cqa_qahead_primary_comment = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Lab Supervisor";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 4) {
                $changestage->stage = "3";
                $changestage->status = "Under Phase I Investigation";
                $changestage->request_moreinfo_by = Auth::user()->name;
                $changestage->request_moreinfo_on = Carbon::now()->format('d-M-Y');
                $changestage->request_moreinfo_comment = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Lab Supervisor";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 5) {
                $changestage->stage = "4";
                $changestage->status = "Under Phase-IA Investigation";
                $changestage->moreinfo_phase_IA_hod_by = Auth::user()->name;
                $changestage->moreinfo_phase_IA_hod_on = Carbon::now()->format('d-M-Y');
                $changestage->moreinfo_phase_IA_hod_comment = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIB_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Lab Supervisor";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 6) {
                $changestage->stage = "5";
                $changestage->status = "Phase IA HOD Primary Review";
                $changestage->moreinfo_phase_qa_review_by = Auth::user()->name;
                $changestage->moreinfo_phase_qa_review_on = Carbon::now()->format('d-M-Y');
                $changestage->moreinfo_phase_qa_review_comment = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_hypothesis;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Final Approval";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 7) {
                $changestage->stage = "6";
                $changestage->status = "Phase IA QA/CQA Review";
                $changestage->moreinfo_assignable_couse_by = Auth::user()->name;
                $changestage->moreinfo_assignable_couse_on = Carbon::now()->format('d-M-Y');
                $changestage->moreinfo_assignable_couse_comment = $request->comment;
                
                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_phaseII_investigation;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Under Phase II investigation";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 8) {
                $changestage->stage = "7";
                $changestage->status = "P-IA CQAH/QAH Review";
                $changestage->moreinfo_phase_IB_Investigation_by = Auth::user()->name;
                $changestage->moreinfo_phase_IB_Investigation_on = Carbon::now()->format('d-M-Y');
                $changestage->moreinfo_phase_IB_Investigation_comment = $request->comment;
                
                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "P-IA CQAH/QAH Review";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 9) {
                $changestage->stage = "8";
                $changestage->status = "Under Phase-II A Investigation";
                $changestage->completed_by_under_manufacturing_investigation_phaseIIA = Auth::user()->name;
                $changestage->completed_on_under_manufacturing_investigation_phaseIIA = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_manufacturing_investigation_phaseIIA = $request->comment;
                
                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 10) {
                $changestage->stage = "9";
                $changestage->status = "Phase II A HOD Primary Review";
                $changestage->completed_by_under_phaseIIB_additional_lab_investigation= Auth::user()->name;
                $changestage->completed_on_under_phaseIIB_additional_lab_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseIIB_additional_lab_investigation = $request->comment;
                
                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 11) {
                $changestage->stage = "10";
                $changestage->status = "Phase IB QA/CQA Review";
                $changestage->completed_by_under_phaseIII_investigation= Auth::user()->name;
                $changestage->completed_on_under_phaseIII_investigation = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_phaseIII_investigation = $request->comment;
                
                $history = new OosAuditTrial();
                $history->oos_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_under_phaseIII_investigation;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 12) {
                $changestage->stage = "11";
                $changestage->status = "P-IB CQAH/QAH Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 13) {
                $changestage->stage = "12";
                $changestage->status = "Under Phase-II A Investigation";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 14) {
                $changestage->stage = "13";
                $changestage->status = "Phase II A HOD Primary Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 15) {
                $changestage->stage = "14";
                $changestage->status = "Phase II A QA/CQA Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Phase II A QA/CQA Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 16) {
                $changestage->stage = "15";
                $changestage->status = "P-II A QAH/CQAH Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "P-II A QAH/CQAH Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 17) {
                $changestage->stage = "16";
                $changestage->status = "Under Phase-II B Investigation";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Under Phase-II B Investigation";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 18) {
                $changestage->stage = "17";
                $changestage->status = "Phase II B HOD Primary Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Phase II B HOD Primary Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 19) {
                $changestage->stage = "18";
                $changestage->status = "Phase II B QA/CQA Review";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Phase II B QA/CQA Review";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function assignable_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changestage = OOS::find($id);
            $lastDocument = OOS::find($id);

            if ($changestage->stage == 1) {
                $changestage->stage = "21";
                $changestage->status = "QA Head Approval";
                // $changestage->completed_by_under_phaseI_correction= Auth::user()->name;
                // $changestage->completed_on_under_phaseI_correction = Carbon::now()->format('d-M-Y');
                // $changestage->comment_under_phaseI_correction = $request->comment;
                            // $history = new OosAuditTrial();
                            // $history->oos_id = $id;
                            // $history->activity_type = 'Activity Log';
                            // $history->current = $changestage->completed_by_under_phaseI_correction;
                            // $history->comment = $request->comment;
                            // $history->user_id = Auth::user()->id;
                            // $history->user_name = Auth::user()->name;
                            // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            // $history->origin_state = $lastDocument->status;
                            // $history->stage = "Lab Supervisor";
                            // $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 2) {
                $changestage->stage = "21";
                $changestage->status = "QA Head Approval";
                // $changestage->completed_by_under_phaseI_correction= Auth::user()->name;
                // $changestage->completed_on_under_phaseI_correction = Carbon::now()->format('d-M-Y');
                // $changestage->comment_under_phaseI_correction = $request->comment;
                            // $history = new OosAuditTrial();
                            // $history->oos_id = $id;
                            // $history->activity_type = 'Activity Log';
                            // $history->current = $changestage->completed_by_under_phaseI_correction;
                            // $history->comment = $request->comment;
                            // $history->user_id = Auth::user()->id;
                            // $history->user_name = Auth::user()->name;
                            // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            // $history->origin_state = $lastDocument->status;
                            // $history->stage = "Lab Supervisor";
                            // $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if ($changestage->stage == 3) {
            //     $changestage->stage = "4";
            //     $changestage->status = "Under Phase I Correction";
            //     $changestage->completed_by_under_phaseI_correction= Auth::user()->name;
            //     $changestage->completed_on_under_phaseI_correction = Carbon::now()->format('d-M-Y');
            //     $changestage->comment_under_phaseI_correction = $request->comment;
            //                 $history = new OosAuditTrial();
            //                 $history->oos_id = $id;
            //                 $history->activity_type = 'Activity Log';
            //                 $history->current = $changestage->completed_by_under_phaseI_correction;
            //                 $history->comment = $request->comment;
            //                 $history->user_id = Auth::user()->id;
            //                 $history->user_name = Auth::user()->name;
            //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //                 $history->origin_state = $lastDocument->status;
            //                 $history->stage = "Lab Supervisor";
            //                 $history->save();
            //     $changestage->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            //     if ($changestage->stage == 5) {
            //         $changestage->stage = "6";
            //         $changestage->status = "Phase IA HOD Primary Review";
            //         $changestage->completed_by_under_phaseI_correction= Auth::user()->name;
            //         $changestage->completed_on_under_phaseI_correction = Carbon::now()->format('d-M-Y');
            //         $changestage->comment_under_phaseI_correction = $request->comment;
            //                     $history = new OosAuditTrial();
            //                     $history->oos_id = $id;
            //                     $history->activity_type = 'Activity Log';
            //                     $history->current = $changestage->completed_by_under_phaseI_correction;
            //                     $history->comment = $request->comment;
            //                     $history->user_id = Auth::user()->id;
            //                     $history->user_name = Auth::user()->name;
            //                     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //                     $history->origin_state = $lastDocument->status;
            //                     $history->stage = "Lab Supervisor";
            //                     $history->save();
            //         $changestage->update();
            //         toastr()->success('Document Sent');
            //         return back();
            //     }

            // if ($changestage->stage == 4) {
            //     $changestage->stage = "14";
            //     $changestage->status = "Pending Final Approval Completed";
            //     $changestage->completed_by_approval_completed= Auth::user()->name;
            //     $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
            //     $changestage->comment_approval_completed = $request->comment;
            //         $history = new OosAuditTrial();
            //         $history->oos_id = $id;
            //         $history->activity_type = 'Activity Log';
            //         $history->current = $changestage->completed_by_under_phaseIII_investigation;
            //         $history->comment = $request->comment;
            //         $history->user_id = Auth::user()->id;
            //         $history->user_name = Auth::user()->name;
            //         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //         $history->origin_state = $lastDocument->status;
            //         $history->stage = "Approval Completed";
            //         $history->save();
            //     $changestage->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            if ($changestage->stage == 6) {
                $changestage->stage = "7";
                $changestage->status = "Under Repeat Analysis";
                $changestage->completed_by_under_repeat_analysis= Auth::user()->name;
                $changestage->completed_on_under_repeat_analysis = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_repeat_analysis = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_repeat_analysis;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Under Repeat Analysis";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 7) {
                $changestage->stage = "14";
                $changestage->status = "Pending Final Approval Completed";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            // if ($changestage->stage == 9) {
            //     $changestage->stage = "10";
            //     $changestage->status = "Under PhaseIIA Correction";
            //     $changestage->completed_by_under_phaseIIA_correction= Auth::user()->name;
            //     $changestage->completed_on_under_phaseIIA_correction = Carbon::now()->format('d-M-Y');
            //     $changestage->comment_under_phaseIIA_correction = $request->comment;
            //         $history = new OosAuditTrial();
            //         $history->oos_id = $id;
            //         $history->activity_type = 'Activity Log';
            //         $history->current = $changestage->completed_by_under_phaseIIA_correction;
            //         $history->comment = $request->comment;
            //         $history->user_id = Auth::user()->id;
            //         $history->user_name = Auth::user()->name;
            //         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //         $history->origin_state = $lastDocument->status;
            //         $history->stage = "Approval Completed";
            //         $history->save();
            //     $changestage->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            if ($changestage->stage == 10) {
                $changestage->stage = "12";
                $changestage->status = "Under Batch Disposition";
                $changestage->completed_by_under_batch_disposition= Auth::user()->name;
                $changestage->completed_on_under_batch_disposition = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_batch_disposition = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_batch_disposition;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changestage->stage == 11) {
                $changestage->stage = "12";
                $changestage->status = "Under Batch Disposition";
                $changestage->completed_by_under_batch_disposition= Auth::user()->name;
                $changestage->completed_on_under_batch_disposition = Carbon::now()->format('d-M-Y');
                $changestage->comment_under_batch_disposition = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_batch_disposition;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 12) {
                $changestage->stage = "14";
                $changestage->status = "Pending Final Approval Completed";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_under_phaseIII_investigation;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "Approval Completed";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function cancel_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = OOS::find($id);
            $lastDocument = OOS::find($id);
            $data->stage = "0";
            $data->status = "Closed-Cancelled";
            $data->cancelled_by = Auth::user()->name;
            $data->cancelled_on = Carbon::now()->format('d-M-Y');
            $data->comment_cancle = $request->comment;

                    $history = new OosAuditTrial();
                    $history->oos_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous ="";
                    $history->current = $data->cancelled_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state =  $data->status;
                    $history->stage = 'Cancelled';
                    $history->save();
            $data->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function reject_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $capa = Capa::find($id);
            $lastDocument = Capa::find($id);


            if ($capa->stage == 2) {
                $capa->stage = "1";
                $capa->status = "Opened";
                // $capa->rejected_by = Auth::user()->name;
                // $capa->rejected_on = Carbon::now()->format('d-M-Y');
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = "Opened";
                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $capa->division_id){
                //     $email = Helpers::getInitiatorEmail($u->user_id);
                //     if ($email !== null) {
                       
                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $capa],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("More Info Required ".Auth::user()->name);
                //             }
                //         );
                //       }
                //     } 
                // }
                $history->save();

                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 3) {
                $capa->stage = "2";
                $capa->status = "Pending CAPA Plan";
                $capa->qa_more_info_required_by = Auth::user()->name;
                $capa->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = $capa->qa_more_info_required_by;
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'Qa More Info Required';
                        $history->save();   
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = "Pending CAPA Plan<";
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function Done_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = OOS::find($id);
            $changestage = OOS::find($id);
            $lastDocument = OOS::find($id);
            $data->stage = "23";
            $data->status = "Closed-Done";
            $data->Assignable_Cause_Found_By = Auth::user()->name;
            $data->Assignable_Cause_Found_On = Carbon::now()->format('d-M-Y');
            $data->Assignable_Cause_Found_Comment = $request->comment;

            $history = new OosAuditTrial();
            $history->oos_id = $id;
            $history->activity_type = 'Assignable Cause Found By    ,   Assignable Cause Found On';
            if (is_null($lastDocument->Assignable_Cause_Found_By) || $lastDocument->Assignable_Cause_Found_By === '') {
                $history->previous = "Null";
            } else {
                $history->previous = $lastDocument->Assignable_Cause_Found_By . ' , ' . $lastDocument->Assignable_Cause_Found_On;
            }
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action = 'Assignable Cause Found';
            $history->change_from = $lastDocument->status;
            $history->change_to =   "Closed - Done";
            $history->current = $changestage->Assignable_Cause_Found_By . ' , ' . $changestage->Assignable_Cause_Found_On;
            if (is_null($lastDocument->Assignable_Cause_Found_By) || $lastDocument->Assignable_Cause_Found_By === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
          
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }
    }

    public function Done_One_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = OOS::find($id);
            $changestage = OOS::find($id);
            $lastDocument = OOS::find($id);
            $data->stage = "24";
            $data->status = "Closed-Done";
            $data->P_I_B_Assignable_Cause_Found_By = Auth::user()->name;
            $data->P_I_B_Assignable_Cause_Found_On = Carbon::now()->format('d-M-Y');
            $data->P_I_B_Assignable_Cause_Found_Comment = $request->comment;

            $history = new OosAuditTrial();
            $history->oos_id = $id;
            $history->activity_type = 'P-IB Assignable Cause Found By    ,   P-IB Assignable Cause Found On';
            if (is_null($lastDocument->P_I_B_Assignable_Cause_Found_By) || $lastDocument->P_I_B_Assignable_Cause_Found_By === '') {
                $history->previous = "Null";
            } else {
                $history->previous = $lastDocument->P_I_B_Assignable_Cause_Found_By . ' , ' . $lastDocument->P_I_B_Assignable_Cause_Found_On;
            }
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action = 'P-IB Assignable Cause Found';
            $history->change_from = $lastDocument->status;
            $history->change_to =   "Closed - Done";
            $history->current = $changestage->P_I_B_Assignable_Cause_Found_By . ' , ' . $changestage->P_I_B_Assignable_Cause_Found_On;
            if (is_null($lastDocument->P_I_B_Assignable_Cause_Found_By) || $lastDocument->P_I_B_Assignable_Cause_Found_By === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
            // $list = Helpers::getQAUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getCQAUsersList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getInitiatorUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getHodUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
          
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }
    }

    public function Done_Two_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = OOS::find($id);
            $changestage = OOS::find($id);
            $lastDocument = OOS::find($id);
            $data->stage = "25";
            $data->status = "Closed-Done";
            $data->P_II_A_Assignable_Cause_Found_By = Auth::user()->name;
            $data->P_II_A_Assignable_Cause_Found_On = Carbon::now()->format('d-M-Y');
            $data->P_II_A_Assignable_Cause_Found_Comment = $request->comment;

            $history = new OosAuditTrial();
            $history->oos_id = $id;
            $history->activity_type = 'P-II A Assignable Cause Found By    ,   P-II A Assignable Cause Found On';
            if (is_null($lastDocument->P_II_A_Assignable_Cause_Found_By) || $lastDocument->P_II_A_Assignable_Cause_Found_By === '') {
                $history->previous = "Null";
            } else {
                $history->previous = $lastDocument->P_II_A_Assignable_Cause_Found_By . ' , ' . $lastDocument->P_II_A_Assignable_Cause_Found_On;
            }
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action = 'P-II A Assignable Cause Found';
            $history->change_from = $lastDocument->status;
            $history->change_to =   "Closed - Done";
            $history->current = $changestage->P_II_A_Assignable_Cause_Found_By . ' , ' . $changestage->P_II_A_Assignable_Cause_Found_On;
            if (is_null($lastDocument->P_II_A_Assignable_Cause_Found_By) || $lastDocument->P_II_A_Assignable_Cause_Found_By === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
            // $list = Helpers::getQAUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getCQAUsersList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getInitiatorUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getHodUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getProductionUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            // $list = Helpers::getProductionHeadUserList($changestage->division_id);
            // foreach ($list as $u) {
            //    $email = Helpers::getUserEmail($u->user_id);
            //        if ($email !== null) {
            //        Mail::send(
            //            'mail.view-mail',
            //            ['data' => $changestage, 'site' => "OOS/OOT", 'history' => "Review", 'process' => 'OOS/OOT', 'comment' => $request->comments, 'user'=> Auth::user()->name],
            //            function ($message) use ($email, $changestage) {
            //                $message->to($email)
            //                ->subject("Agio Notification: OOS/OOT, Record #" . str_pad($changestage->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review");
            //            }
            //        );
            //    }
            // }
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }
    }
    public function child(Request $request, $id)
    {
        $cft = [];
        $Form_type = OOS::where('id', $id)->value('Form_type');
        $parent_id = $id;
        if ($Form_type === 'OOS_Chemical') {
            $parent_type = 'OOS Chemical';
        } elseif ($Form_type === 'OOS_Micro') {
            $parent_type = 'OOS Micro';
        } else {
            $parent_type = 'OOT';
        }        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $parent_record = OOS::where('id', $id)->value('record_number');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = OOS::where('id', $id)->value('division_id');
        $parent_initiator_id = OOS::where('id', $id)->value('initiator_id');
        $parent_intiation_date = OOS::where('id', $id)->value('intiation_date');
        $parent_created_at = OOS::where('id', $id)->value('created_at');
        $parent_short_description = OOS::where('id', $id)->value('description_gi');
        $hod = User::where('role', 4)->get();
        $record = $record_number;
        // dd($record_number);
        $old_records = OOS::select('id', 'division_id', 'record_number')->get();

        if ($request->child_type == "capa") {
            $parent_name = "CAPA";
            $Capachild = OOS::find($id);
            $relatedRecords = Helpers::getAllRelatedRecords();
            $reference_record = Helpers::getDivisionName($Capachild->division_id ) . '/' . 'OOS/OOT' .'/' . date('Y') .'/' . str_pad($Capachild->record, 4, '0', STR_PAD_LEFT);
            $Capachild->Capachild = $record_number;
            $Capachild->save();

            return view('frontend.forms.capa', compact('reference_record','parent_id','relatedRecords','old_records','record_number', 'parent_record','parent_type', 'record', 'due_date', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'old_records', 'cft'));
        } elseif ($request->child_type == "Action_Item")
         {
            $parent_name = "CAPA";
            $actionchild = OOS::find($id);
            $data = OOS::find($id);
            // $p_record = RootCauseAnalysis::find($id);
            $data_record = Helpers::getDivisionName($actionchild->division_id ) . '/' . 'OOS' .'/' . date('Y') .'/' . str_pad($actionchild->record, 4, '0', STR_PAD_LEFT);    
            $parentRecord = OOS::where('id', $id)->value('record_number');
            $actionchild->actionchild = $record_number;
            $parent_id = $id;
            $actionchild->save();

            return view('frontend.action-item.action-item', compact('parentRecord','parent_short_description','old_records','record_number', 'data_record', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record','parent_type', 'record', 'due_date', 'parent_id', 'data'));
        }
        elseif ($request->child_type == "Resampling")
         {
            $parent_name = "CAPA";
            $actionchild = OOS::find($id);
            $actionchild->actionchild = $record_number;
            $relatedRecords = Helpers::getAllRelatedRecords();
            $parent_id = $id;
            $actionchild->save();

            return view('frontend.resampling.resapling_create', compact('relatedRecords','parent_short_description','old_records','record_number', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'record', 'due_date', 'parent_id', 'parent_type'));
        }
        elseif ($request->child_type == "Extension")
        {
           $parent_name = "CAPA";
           $actionchild = OOS::find($id);
           $actionchild->actionchild = $record_number;
           $parent_id = $id;
           $relatedRecords = Helpers::getAllRelatedRecords();
           $data=OOS::find($id);
           $extension_record = Helpers::getDivisionName($data->division_id ) . '/' . 'OOS/OOT' .'/' . date('Y') .'/' . str_pad($data->record, 4, '0', STR_PAD_LEFT);

           $actionchild->save();

           return view('frontend.extension.extension_new', compact('relatedRecords','extension_record', 'parent_short_description','old_records','record_number', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'record', 'due_date', 'parent_id', 'parent_type'));
       }

        else {
            $parent_name = "Root";
            $Rootchild = OOS::find($id);
            $Rootchild->Rootchild = $record_number;
            $Rootchild->save();
            return view('frontend.forms.root-cause-analysis', compact('parent_id','old_records','record_number', 'parent_record','parent_type', 'record', 'due_date', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', ));
        }
    }

    // public function cancel_record(Request $request, $id)
    // {
    //     $oos_record = OOS::find($id);
    // }

    public function AuditTrial($id)
    {
        $audit = OosAuditTrial::where('oos_id', $id)->orderByDesc('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = OOS::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $users = User::all();
        return view('frontend.OOS.comps.audit-trial', compact('audit', 'document', 'today','users'));
    }

    public function auditDetails($id)
    {

        $detail = OosAuditTrial::find($id);

        $detail_data = OosAuditTrial::where('activity_type', $detail->activity_type)->where('oos_id', $detail->id)->latest()->get();

        $doc = OOS::where('id', $detail->oos_id)->first();
        

        $doc->origiator_name = User::find($doc->initiator_id);
        
        return view('frontend.OOS.comps.audit-trial-inner', compact('detail', 'doc', 'detail_data'));
    }
    public static function auditReport($id)
    {
        $doc = OOS::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = OOSAuditTrial::where('oos_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.oos.comps.auditReport', compact('data', 'doc'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('OOS-Audit' . $id . '.pdf');
        }
    }
    
    public static function singleReport($id)
    {
        $data = OOS::find($id);
        if (!empty($data)) {
            $data->info_product_materials = $data->grids()->where('identifier', 'info_product_material')->first();
            $data->details_stabilities = $data->grids()->where('identifier', 'details_stability')->first();
            $data->oos_details = $data->grids()->where('identifier', 'oos_detail')->first();
            $checklist_lab_invs = $data->grids()->where('identifier', 'checklist_lab_inv')->first();
            $instrument_details = $data->grids()->where('identifier', 'instrument_details')->first();
            $phase_two_invs = $data->grids()->where('identifier', 'phase_two_inv')->first();
            $oos_conclusions = $data->grids()->where('identifier', 'oos_conclusion')->first();
            $oos_conclusion_reviews = $data->grids()->where('identifier', 'oos_conclusion_review')->first();
    
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.OOS.comps.singleReport', compact('data','checklist_lab_invs','phase_two_invs','instrument_details','oos_conclusions','oos_conclusion_reviews'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('OOS Cemical' . $id . '.pdf');
        }
    }
       
}
