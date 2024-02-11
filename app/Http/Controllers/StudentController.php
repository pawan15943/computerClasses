<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Profile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses=Course::pluck('id','course_name');
        $classes=Grade::pluck('id','class_name');
       
        return view('student.studentfees' , compact('courses','classes'));
    }
   
    public function courseWiseFees(Request $request)
    {
        if($request->course_id){
            $courseId=$request->course_id;
            $fees=Course::where('id',$courseId)->select('courses.*')->first();
           
            return response()->json($fees);
        }
    }

   
    public function initiatePayment(Request $request)
    {
        
        // Get the UPI ID for the specific user or project owner
        $upiId = "568682417363"; // Replace this with the actual UPI ID

        $uri = "UPI ID:$upiId";

        // $googleChartsUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$upiId";
        $googleChartsUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$upiId&choe=UTF-8";

        return response()->json([
            'success' => true,
            'qrCodeUrl' => $googleChartsUrl,
        ]);
        
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_profile=Profile::where('user_id',Auth::user()->id)->first();

        return view('payment.qrcode',compact('user_profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

           if(Student::where('user_id','=',$request->user_id)->count() >0){
                Student::where('user_id','=',$request->user_id)->update([  
                    'is_certificate'=>$request->is_certificate,
                    'class_id'=>$request->class_id,
                    'course_id'=>$request->course_id,
                    
                ]);
           }else{
                Student::create([  
                    'is_certificate'=>$request->is_certificate,
                    'class_id'=>$request->class_id,
                    'course_id'=>$request->course_id,
                    'user_id'=>$request->user_id,
                ]);
           }
               
            $fees=$request->fee_amount;
            return response()->json(['success' => true, 'fees' =>$fees]);
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    
    public function studentfees_trans(Request $request){
        
        $validator = Validator::make($request->all(), [
            'reciept' => 'required|mimes:png,jpg,jpeg|max:5120',
            'transaction_id' => 'required',
            'transaction_date' => 'required',
            'paymentOption' => 'required',
            'installment' => ['required_if:paymentOption,==,installment'],
            'lumpsum_amt' => ['required_if:paymentOption,==,lumpSum'],
        ],
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


            if($request->hasFile('reciept')){
                    
                $this->validate($request,['reciept' => 'mimes:png,jpg,jpeg|max:5120']);
                $reciept = $request->reciept;
                $recieptNewName = "reciept".time().$reciept->getClientOriginalName();
                $reciept->move('public/uploads/',$recieptNewName);
                $reciept = 'public/uploads/'.$recieptNewName;
                
            }
           
            try {
                $studentid=Student::where('user_id','=',$request->user_id)->select('id','course_id')->first();
                $fees=Course::where('id',$studentid->course_id)->select('course_fees')->first();
                if($request->paymentOption=='lumpSum'){
                    $installment=0;
                    $received_amount=$request->lumpsum_amt;
                    $fee_amount=$request->lumpsum_amt;
                }
                if($request->paymentOption=='installment'){
                    $installment=$request->installment;
                    if($installment==1){
                        $received_amount=$request->installment1;
                    }elseif($installment==2){
                        $received_amount=$request->installment2;
                        
                    }elseif($installment==3){
                        $received_amount=$request->installment3;
                    }
                    $fee_amount= $request->installment1 + $request->installment2 + $request->installment3;
                }
                // fee_amount=> after discount amount and paid amount is total recieved amount 
                $count_inst=DB::table('transaction')->where('student_id',$studentid->id)->where('installment',$installment)->count();
                if($count_inst>0){
                    return response()->json(['error' => true,  'message' =>'This installment already']);
                }
                $insert_id=DB::table('transaction')->insertGetId([  
                    'transaction_id'=>$request->transaction_id,
                    'transaction_date'=>$request->transaction_date,
                    'student_id'=>$studentid->id,
                    'fee_amount'=>$fee_amount,
                    'installment'=>$installment,
                    'received_amount'=> $received_amount,
                    'payment_mode'=>'Online',
                    'reciept'=>$reciept
                ]);
                
                //calculate amount store in student table
                $paid_amount=DB::table('transaction')->where('student_id',$studentid->id)->select('received_amount')->get();
                if($paid_amount!=null || $paid_amount!=0){
                    $total_paid_amount = $paid_amount->sum('received_amount');
                }else{
                    $total_paid_amount=null;
                }
                if($fee_amount>0){
                    $pending_amount=$fee_amount - $total_paid_amount;
                }else{
                    $pending_amount=0;
                }
                
                Student::where('id',$studentid->id)->update([
                    'total_course_fees'=>$fees->course_fees,
                    'paid_amount' => $total_paid_amount,
                    'pending_amount' => $pending_amount,
                    'payment_option'=>$request->paymentOption
                ]);
                $pdf_result = $this->pdfgenerate($studentid->id);
                $is_receipt = DB::table('transaction')->where('id',$insert_id)->update(['acknowledgement_receipt' => $pdf_result['path']]);
               
                $auth_user=User::where('id',$request->user_id)->value('name');

                $dynamic = [
                    'tital' => 'Amount Received from'.$auth_user,
                    // 'message' => $received_amount.'amount received from'.$auth_user.'<a href="'.$reciept.'">Reciept</a>',
                    'message' => $received_amount.'amount received from',
                    'url' => url('/paymentVerify'),
                   
                ];
               
               
                if(User::role('admin')->count()>0){
                    $admin = User::role('admin')->value('id');
                }else{
                    $admin=1;
                }
                $adminUser = User::find($admin);
                if ($adminUser) {
                    Notification::send($adminUser, new CustomNotification($dynamic));
                } else {
                    return response()->json(['error' => true,  'message' =>'admin not found']);
                }
                
                return response()->json(['success' => true,  'message' =>'Payment Success']);
            }catch(Exception $e){
                return response()->json(['error' => true, 'message' => $e->getMessage()]);
            }
    }

    public function userWiseFees(Request $request){
        $courseId=Student::where('user_id',Auth::user()->id)->select('course_id')->first();
        $fees=Course::where('id',$courseId->course_id)->select('courses.*')->first();
           
        return response()->json($fees);
    }
    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function pdfgenerate($student_id){
       
        $pdf_name = date('d-m-Y_H-i-s') . '_' . $student_id . '.pdf';
        $student=Student::leftJoin('courses','students.course_id','=','courses.id')->where('students.id',$student_id)
           ->select('students.id as student_id','students.*','courses.course_name as course_name','courses.duration as duration','courses.course_fees','courses.discount')->first();
        $user=User::join('profiles','profiles.user_id','=','users.id')->where('users.id',$student->user_id)->first(); 
       
        $transactons=DB::table('transaction')->where('student_id',$student_id)->get();  
       
        $pdf = PDF::loadView('pdf.reciept_pdf', compact('user','transactons','pdf_name','student'));
        $pdf->save(public_path('allpdf/' . $pdf_name));
        $return_path = url('allpdf/' . $pdf_name);
        $return_array=array("path"=>$return_path,"name"=>$pdf_name,"status_code"=>"200");
        return $return_array;
        
    }
}
