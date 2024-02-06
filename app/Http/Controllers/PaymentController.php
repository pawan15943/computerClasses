<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;
use DB;
use PHPUnit\Framework\MockObject\Stub\Stub;
use PDF;
use App\Http\Controllers\StudentController;

class PaymentController extends Controller
{
    public function index(){
        $transections=DB::table('transaction')->get();
        return view('admin.transaction',compact('transections'));
    }

    public function show(Request $request){
        $id=$request->id;
        $stuId=$request->student_id;
        
        $transections=DB::table('transaction')->where('id',$id)->first();
        $data=User::leftJoin('students','users.id','=','students.user_id')->where('students.id',$stuId)->first();
        $course=Course::where('id',$data->course_id)->first();
        return response()->json(['data' => $data, 'transaction'=>$transections,'course'=>$course]);
    }

    public function verified(Request $request){
            $id= $request->id;
           $verification_id= $request->verification_id;
        
           DB::table('transaction')->where('id',$id)->update([
            'is_varified'=>$verification_id,
            ]);
            $student_last_uid=Student::orderBy('student_uid', 'desc')->value('student_uid');
            $student_id=DB::table('transaction')->where('id',$id)->value('student_id');
                if($student_last_uid==null){
                    $student_last_uid='2023000001';
                }else{
                    $student_last_uid ++;
                }
                // dd($student_last_uid);
            if($verification_id==1){
              
                Student::findOrFail($student_id)->update([
                    'student_uid'=>$student_last_uid,
                    'is_paid'=>1
                    ]);
               
                $dynamic = [
                    'tital' => 'Payment Verification',
                    'message' => 'Your Payment Verified.',
                    'url' => url('/my_transaction'),
                   
                ];
    
            }elseif($verification_id==2){
                $dynamic = [
                    'tital' => 'Payment Verification',
                    'message' => 'Your Payment Verification Decline', 
                    'url' => url('/my_transaction'),
                   
                ];
            }
            $studentController = new StudentController();
             $pdfResult = $studentController->pdfgenerate($student_id);
             $user_id=Student::where('id',$student_id)->value('user_id');
             $user=User::where('id',$user_id)->first();
            $is_receipt = DB::table('transaction')->where('id',$id)->update(['acknowledgement_receipt' => $pdfResult['path']]);
            Notification::send($user, new CustomNotification($dynamic));
         
        return response()->json($pdfResult);
         
    }

    //this function only dummy function
    public function pdfSendWithMail($inserted_id){
        $return_array=array("status_code"=>"204");
        $data['inserted_id']=$inserted_id;
            
        if($data && isset($data['inserted_id']) && !empty($data['inserted_id']))
        {
            $transaction= DB::table('students_fees')
            ->select('student_id','transaction_id','offline_transaction_id','sch_percentage','installments_number','paid_amount','invoice_ref_no')->where('id', $data['inserted_id'])->first();
            
            $stinfo = DB::table('students')->select('students.id','students.other_school','students.school_id','schools.name as schools','courses.code as courses_code','course_types.name as coursetypes','classes.name as class_name','courses.name as course_name','study_centers.name as study_center','countries.currency_code as currency')
            ->leftJoin('schools', 'students.school_id', '=', 'schools.id')
            ->leftJoin('classes', 'students.class_id', '=', 'classes.id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->leftJoin('study_centers','students.center_id', '=', 'study_centers.id')
            ->leftJoin('countries','students.country_id', '=', 'countries.id')
            ->leftJoin('course_types', 'courses.course_type_id', '=', 'course_types.id')  
            ->where('students.id', $transaction->student_id)->first();
       

        //     $student_data=Student::where('id',$transaction->student_id)->first();

            // $send_data['data']=$student_data;
            $send_data['transactiondate']=$transactiondate->transaction_date;
           
            $send_data['coursecode']=$stinfo->courses_code;
            $send_data['class']=$stinfo->class_name;
            $send_data['course']=$stinfo->course_name;
            $send_data['currency']=$stinfo->currency;
            $send_data['study_center']=$stinfo->study_center;  
            $send_data['paid_amount']=$transaction->paid_amount;
            $send_data['payment_mode']=$transactiondate->payment_mode;
            // $send_data['invoice_ref_no']=$transaction->invoice_ref_no;
          
        //    pr($send_data); die;
            $pdf = PDF::loadView('backend.pdfapi.mailPDF', $send_data); 
            $pdf_name=time().'_'.$data['inserted_id'].".pdf";
            $pdf->save(public_path()."/allpdf/".$pdf_name);
            $return_path= url('/allpdf/'.$pdf_name);
            $return_array=array("path"=>$return_path,"name"=>$pdf_name,"status_code"=>"200");
            $is_receipt = StudentsFee::where('id',$data['inserted_id'])->update(['acknowledgement_receipt' => $return_path]);
            // if( $is_receipt > 0){

            //     $details = [
            //                 'name' => $student_data->name,
            //                 'form_num' => $student_data->form_num,
            //                 'pdf_path' => $return_path
            //             ];

            //     \Mail::to($student_data->email)->send(new \App\Mail\FeeReceipt($details));

            // }

        }
        return response()->json($return_array);
     
    }

    public function checkStatus(Request $request){
        $student_id=$request->sid;
        $stu_trans=DB::table('transaction')->where('student_id',$student_id)->get();
        $student=Student::where('id',$student_id)->first();
       
        if($student->payment_option=='installment'){
           
            foreach($stu_trans as $stu_tran){
                $installment=[];
                if(($stu_tran->installment==1 || $stu_tran->installment==2 || $stu_tran->installment==3) && $stu_tran->is_varified==1){

                    $installment=[$stu_tran->installment=>$stu_tran->paid_amount];
                }
            }
            
        }


    }
}
