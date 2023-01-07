<?php


namespace Deschool\Http\Controllers;

//phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Deschool\Billing\Paymentgateway;
use Deschool\Orders\OrderDetails;
use Deschool\Models\Memo;
use Deschool\Http\Middleware\RevalidateBackHistory;
use Deschool\Models\RegisterStaffTeacher;
use Deschool\Models\RegisterPeriod;
use Deschool\Models\RegisterClasses;
use Deschool\Models\RegisterSubject;
use Deschool\Models\Corox_model;
use Deschool\Models\RegisterStudentInformation;
use Deschool\Models\RegisterParentInformation;
use Deschool\Models\RegisterSchoolInformation;
use Deschool\Models\RegisterStaffInformation;
use Deschool\Models\RegisterStaffRegister;
use Deschool\Models\RegisterStudentRegister;
use Deschool\Models\Role;
use Deschool\Models\Permit;
use Validator;
class CoroxController extends Controller
{
          public function __construct(){
            $this->middleware('preventBackHistory');
          }
          //show login here
          public function index(){
            return view('login');
            
          }

          // show info settings page
          public function registerInfoSettings(){
            /* if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }*/
            if(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;

              $adminEmail=Auth::user()->email;
            }
            
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                        $numberOfStaffs = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->where("status", NULL)->count(); 
              }
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
              $services = array();
              $schoolServices =array();
              $result= explode('-',$schoolInformation->school_services);
              foreach($result as $key => $value){
                        $services[$value]= $value;    
              }
              $arrayServices= explode('-','creche/playgroup-nursery-primary/basic-secondary');
              $arrayServices =array_diff($arrayServices, $services);
              foreach($arrayServices as $key => $value){
                        $schoolServices[$value]= $value;    
              }
            }else{
              $services = array();
              $schoolServices = array();
              $schoolInformation= new RegisterSchoolInformation;
              $numberOfStaffs = new RegisterStaffInformation;
                
            }
            $date = date('Y');
            return view('settings-information',['date'=>$date, 'schoolInformation'=> $schoolInformation, 'numberOfStaffs'=> $numberOfStaffs, 'userId'=>$userId, 'userEmail'=>$adminEmail, 'services'=>$services, 'schoolServices'=>$schoolServices, 'title'=>'Information Update']);
          }
          
          //get memo page
          public function getSendMemo(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
                      
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
              $staffInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->where("status", NULL)->paginate(10);    
            }else{
              $staffInformation= new RegisterStaffInformation;     
            }                    
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            } 
                                
            return view('memo',['date'=>$date,'schoolInformation'=> $schoolInformation, 'staffInformation'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Send Memo']);       
          }

          public function postSendMemo(Request $request){
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';   

              if(Auth::user()->isAdmin()){  
                $userId=Auth::user()->id;
              if($request->sender =='' ){     
                return response()->json(['sender'=>'danger','sender_message'=> 'Sender\'s email is required']);                                   
              }elseif($request->subject =='' ){     
                return response()->json(['subject'=>'danger','subject_message'=> 'Subject is required']);                                   
              }elseif($request->email =='' || $request->email =='none'){
                return response()->json(['email'=>'danger','email_message'=> 'Receiver email required']);                                                                 
              }elseif($request->message =='' || $request->message =='none'){
                return response()->json(['mess'=>'danger','mess_message'=> 'Message Description is required']);                                                                 
              }

               $mail = new PHPMailer(true);

              try {
                  //Server settings
                  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                  $mail->isSMTP();                                            //Send using SMTP
                  $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                  $mail->SMTPAuth = true; // authentication enabled
                  $mail->SMTPSecure = 'ssl';
                  $mail->Host = "smtp.gmail.com";                    //Set the SMTP server to send through                                  //Enable SMTP authentication
                  $mail->Username = "methyl2007@gmail.com";
                  $mail->Password = "ontvlykbrmgwxedu";                               //SMTP password
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                  $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                  //Recipients
                  $mail->setFrom($request->sender);
                  foreach($request->email as $email){
                     $mail->addAddress($email);     //Add a recipient                    
                   }                 
              
                  //Content
                  $mail->isHTML(true);                                  //Set email format to HTML
                  $mail->Subject = $request->subject;
                  $mail->Body    = $request->message;
                  $mail->send();
                  $data['sender_email'] =protectData($request->sender); 
                  $data['subject'] =protectData($request->subject);                    
                  $data['message'] =protectData($request->message);
                  $data['receiver_email'] =implode(" ",$request->email);
                  $data['corox_model_id'] =protectData($userId);
                  $memo= Memo::create($data);
                  return response()->json(['result'=>'success','message'=> 'Memo successfully sent']);
              } catch (Exception $e) {
                return response()->json(['result'=>'danger','message'=> $mail->ErrorInfo]);
              }
            }
          }          
          // create record info settings page
          public function registerInfoSettingsAdd( Request $request ){
            $data = array();
            $image = $request->file('profileImage');

            $name=$request->input('name');
            $phone1=$request->input('phone1');
            $phone2=$request->input('phone2');
            $email=$request->input('email');
            $city=$request->input('city');
            $address=$request->input('address');
            $license=$request->input('license');
            $state=$request->input('state');
            $social =$request->input('social');
            $numberOfStaffs=$request->input('numberStaff');
            $description=$request->input('description');
            $services =$request->input('services');
            $date=$request->input('date');
            $licenseNumber=$request->input('licenseNumber');    
            $date=$request->input('date');
            $postalAddress=$request->input('postalAddress');         
            $localG=$request->input('localG');

            if(Corox_model::where("email",protectData($email))->exists()){
                      $request->session()->flash('message', 'This email , '.$request->email.' is not available');
                      return redirect()->route('info-settings');;
            }              
            $rules=array(
            'profileImage'=>'required',
            'name'=>'required',
            'email'=>'required|email|unique:register_staff_informations,email',
            'phone1'=>'required',
            'phone2'=>'required',                               
            'address'=>'required',
            'address'=>'required',
            'license'=>'required',
            'city'=>'required',
            'social'=>'required',
            'state'=>'required',
            'localG'=>'required',
            'numberStaff'=>'required',
            'description'=>'required',
            'services'=>'required',
            'date'=>'required',
            'licenseNumber'=>'required',
            'postalAddress'=>'required',
            );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              return redirect()->route('info-settings')->withErrors($validator);
            }else{ 
              if($image ==NULL || $image =='' ){
                      $data['school_profile_image']  = $image; 
              }else{
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                $data['school_profile_image'] =$image->getFilename().'.'.$image->getClientOriginalExtension();
              }
              $data['school_name'] =protectData($name);
              $data['school_email'] =protectData($email);
              $data['school_phone1'] =protectData($phone1);
              $data['school_phone2'] =protectData($phone2);
              $data['school_address'] =protectData($address);
              $data['school_license'] =protectData($license);
              $data['school_city'] =protectData($city);
              $data['school_social_media'] =protectData($social);
              $data['school_state'] =protectData($state);
              $data['school_localG'] =protectData($localG);
              $data['school_number_of_staffs'] =$numberStaff > 0 ? protectData($numberStaff)  : 1 ;
              $data['school_description'] =protectData($description);
              $data['school_services'] =$services !==null ? protectData(implode('-',$services)) :protectData($services);
              $data['school_establish_date'] =protectData($date);
              $data['school_license_number'] =protectData($licenseNumber);                    
              $data['school_postal_address'] =protectData($postalAddress);
              $data['corox_model_id'] =protectData($request->userId);
              $schoolInformation= RegisterSchoolInformation::create($data);
            }
            $request->session()->flash('messageSuccess', ucfirst($name).' school information successfully created');                              
            return redirect()->route('info-settings');
          }
          // update record info settings page
          public function registerInfoSettingsUpdate( Request $request ){

            $schoolInformation = RegisterSchoolInformation::find(protectData($request->id));
            $image = $request->file('profileImage');

            $name=protectData($request->input('name'));
            $phone1=protectData($request->input('phone1'));
            $phone2=protectData($request->input('phone2'));
            $email=protectData($request->input('email'));
            $city=protectData($request->input('city'));
            $address=protectData($request->input('address'));
            $license=protectData($request->input('license'));
            $state=protectData($request->input('state'));
            $social = protectData($request->input('social'));
            $numberOfStaffs=protectData($request->input('numberStaff'));
            $description=protectData($request->input('description'));
            $services = $request->input('services');
            $date=protectData($request->input('date'));
            $licenseNumber=protectData($request->input('licenseNumber'));    
            $date=protectData($request->input('date'));
            $postalAddress=protectData($request->input('postalAddress'));         
            $localG=protectData($request->input('localG'));

            if(Corox_model::where("email",protectData($email))->exists()){
                      $request->session()->flash('message', 'This email , '.$request->email.' is not available');
                      return redirect()->route('info-settings');;
            }              
            $rules=array(
              'name'=>'required',
              'email'=>'required',
              'phone1'=>'required',
              'phone2'=>'required',                               
              'address'=>'required',
              'address'=>'required',
              'license'=>'required',
              'city'=>'required',
              'social'=>'required',
              'state'=>'required',
              'localG'=>'required',
              'numberStaff'=>'required',
              'description'=>'required',
              'services'=>'required',
              'date'=>'required',
              'licenseNumber'=>'required',
              'postalAddress'=>'required',
              );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              return redirect()->route('info-settings')->withErrors($validator);
            }else{ 

              $FileSystem = new Filesystem();
              $directory = public_path().'/uploads/';
              if($image ==NULL || $image =='' ){
                if($schoolInformation->school_profile_image !=Null || $schoolInformation->school_profile_image !='' ){
                  
                }else{
                  $schoolInformation->school_profile_image = $image; 
                }
              }elseif($image->getFilename().'.'.$image->getClientOriginalExtension() != $schoolInformation->school_profile_image){
                if($FileSystem->exists($directory.$image->getFilename().'.'.$image->getClientOriginalExtension())){
                  unlink(public_path('uploads/'.$schoolInformation->school_profile_image));
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                }
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
              }else{
                if($FileSystem->exists($directory.$schoolInformation->school_profile_image)){
                  unlink(public_path('uploads/'.$schoolInformation->school_profile_image));                              
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                }
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                
                $schoolInformation->school_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
              }


              $schoolInformation->school_name =protectData($request->name);
              $schoolInformation->school_email =protectData($request->email);
              $schoolInformation->school_phone1 =protectData($request->phone1);
              $schoolInformation->school_phone2 =protectData($request->phone2);
              $schoolInformation->school_address =protectData($request->address);
              $schoolInformation->school_license =protectData($request->license);
              $schoolInformation->school_city =protectData($request->city);
              $schoolInformation->school_social_media =($request->social);
              $schoolInformation->school_state =protectData($request->state);
              $schoolInformation->school_localG =protectData($request->localG);
              $schoolInformation->school_number_of_staffs =$request->numberStaff > 0 ? protectData($request->numberStaff)  : 1 ;
              $schoolInformation->school_description =protectData($request->description);
              $schoolInformation->school_services =$request->services !==null ? implode('-',$request->services) :protectData($request->services) ;
              $schoolInformation->school_establish_date =protectData($request->date);
              $schoolInformation->school_license_number =protectData($request->licenseNumber);
              $schoolInformation->school_postal_address =protectData($request->postalAddress);
              $schoolInformation->corox_model_id =protectData($request->userId);
              $schoolInformation->save();
              $request->session()->flash('messageSuccess', ucfirst($name).' school information successfully updated');                              
              return redirect()->route('info-settings');                      
           }

          }                  
          //show register page here
          public function registerShowSignUp(){
                    return view('signup');
          }
          // show login here
           public function registerLogin(Request $request){

            $email=$request->input('email');
            $pass=$request->input('password');
            $rules=array(
              'email'=>'required|email',
              'password'=>'required',
            );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              //fail request
              return redirect()->route('login')->withErrors($validator);
            }else{

              $email=protectData($request->input('email'));
              $pass=protectData($request->input('password'));
              $data=array('email'=>$email,'password'=>$pass);

              if($request->input('remember_me')=='on'){
                $remember=true;
              }else{
                $remember=false;
              }
              
              if(Auth::attempt($data,$remember)){
                return redirect()->route('dashboard');
              }else{
                return  back()->with('message', 'Your login detail is wrong');
              }

            }
          }
          //showing register dashboard here
          public function registerDashboard(){
            //if(Permit::where("corox_model_id",Auth::user()->id)->exists()){
                      // $roleExist = Permit::where("corox_model_id",Auth::user()->id)->first();
                      // if( $roleExist->role_id !=4){
            if(Auth::user()->isMember()){
                      $roleId =1;
                      $roleInformation = Permit::where("role_id",$roleId)->first();
                      $userId= $roleInformation->corox_model_id;
                      $date = date('Y');
                      $adminInformation = Corox_model::where("id",$userId)->first();
                      $adminEmail=$adminInformation->email;
                      //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
                      $email= Auth::user()->email;
                      $date = date('Y');
                      $userId=Auth::user()->id;
                      $adminEmail=Auth::user()->email;
            }

            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
                      $services = array();
                      $schoolServices = array();
                      $schoolInformation= new RegisterSchoolInformation;     
            }                                         
                      // }else{
                        //        return redirect('/Dregister/info-settings');                 
                      //}
            //}else{
                      //return redirect('/Dregister/info-settings');     
            //}
                   
            return view('dashboard',['userEmail'=>$adminEmail, 'date'=>$date, 'schoolInformation'=> $schoolInformation, 'title'=>'Dashboard']);
          }
          // show register signup page here
          public function registerSignUp(Request $request){
            $user= new Corox_model;
            $email=protectData($request->input('email'));
            $pass=protectData(Hash::make($request->input('password')));
            $remember_token=protectData($request->input('_token'));
            $admin="admin";
            $rules=array(
              'email'=>'required|email|unique:corox_models,email',
              'password'=>'required',
            );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              return redirect()->route('signup')->withErrors($validator);
            }else{
              $role_id=DB::table('roles')->where('role',$admin)->first();
              $reg_id=$result=DB::table('corox_models')->where('email',$email)->first();
              $roleCheck=DB::table('corox_model_role')->where('role_id',$role_id)->where('corox_model_id',$reg_id);
              if($roleCheck == null){
                $request->session()->flash('errorMessage', $email.' has already been registered as an '.$admin );
                return  redirect()->route('signup');
              } 
              $user->email=protectData($email);
              $user->password=protectData($pass);
              $user->remember_token=protectData($remember_token);
              if($user->save()){
                $reg_id=$result=DB::table('corox_models')->where('email',$email)->first();
                $role_id=DB::table('roles')->where('role',$admin)->first();
                $permit= new Permit;
                $permit->role_id=protectData($role_id->id);
                $permit->corox_model_id=protectData($reg_id->id);
                if($permit->save()){
                  $request->session()->flash('message', 'You have successfully registered '.$email.' as an admin');
                  return  redirect()->route('signup');
                };
              };
            }
          }
          //showing the register profile page
          public function registerProfile(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }                  

            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }                    
            return view('profile',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Profile']);
          }                    
          //tracking page to show add staff page
          public function registerStaff(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }                  
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
             $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{

             $schoolInformation= new RegisterSchoolInformation;     
            }
            return view('add-staff',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Staff']);
          }          
          //tracking page to post create staff details
          public function registerAddStaff(Request $request){
            /* if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }*/
            if(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            } 

            $firstname=$request->input('firstname');
            $middlename=$request->input('middlename');
            $lastname=$request->input('lastname');
            $email=$request->input('email');
            $maritalStatus=$request->input('maritalStatus');
            $dob=$request->input('dob');
            $gender=$request->input('gender');
            $phone=$request->input('phone');
            $city=$request->input('city');
            $socialMedia=$request->input('socialMedia');
            $address=$request->input('address');
            $state=$request->input('state');
            $hobbies =$request->input('hobbies');
            $disabilityStatus=$request->input('disabilityStatus');
            $listDisability=$request->input('listDisability');
            $localG=$request->input('localG');

            if(Corox_model::where("email",protectData($email))->exists()){
              $request->session()->flash('message', 'Please register this staff with another email, '.$request->email.' is not available');
              return redirect()->route('add-staff');
            }
            
            if(($disabilityStatus =='yes')  && $listDisability ==''){
              $request->session()->flash('listDisability', 'List your Disability'); 
              return redirect()->route('add-staff');                            
            }                
            $rules=array(
              'firstname'=>'required',
              'middlename'=>'required',
              'lastname'=>'required',
              'email'=>'required|email|unique:register_staff_informations,staff_email',
              'maritalStatus'=>'required',
              'disabilityStatus'=>'required',
              'dob'=>'required',
              'gender'=>'required',
              'phone'=>'required',
              'city'=>'required',
              'socialMedia'=>'required',
              'address'=>'required',
              'hobbies'=>'required',
              'state'=>'required',
              'localG'=>'required',
            );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              return redirect()->route('add-staff')->withErrors($validator);
            }else{  
              
              $data = array();                                        
              $image = $request->file('profileImage');
              if($image == NULL || $image =='' ){
                      $data['staff_profile_image']  = 'no image'; 
              }else{                    
                        Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                        $data['staff_profile_image'] =$image->getFilename().'.'.$image->getClientOriginalExtension();
              }                                        
              $data['staff_firstname']= protectData($firstname);
              $data['staff_middlename']= protectData($middlename);
              $data['staff_lastname']= protectData($lastname);            
              $data['staff_email']= protectData($email);
              $data['staff_marital_status']= protectData($maritalStatus);
              $data['staff_gender']= protectData($gender);            
              $data['staff_phone']= protectData($phone);
              $data['staff_dob']= protectData($dob);
              $data['staff_disability']= protectData($disabilityStatus);
              $data['staff_list_disability']= protectData($listDisability);
              $data['staff_hobbies']= protectData($hobbies);
              $data['staff_address']= protectData($address);
              $data['staff_city']= protectData($city);
              $data['staff_social_media']= protectData($socialMedia);
              $data['staff_state']= protectData($state);
              $data['staff_localG']= protectData($localG);
              $data['user_corox_model_id'] = 0;
              $data['corox_model_id'] =protectData($request->userId);
              $schoolInformation= RegisterStaffInformation::create($data);    
              $request->session()->flash('messageSuccess', 'Staff with email, '.$email.' is successfully created');                              
              return redirect()->route('add-staff');
            }
          }
          //tracking page to post update staff detail
          public function registerUpdateStaff(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
                    
            if($request->id == null || $request->id == '' || !is_numeric($request->id)){
              $request->session()->flash('message', 'You are not allowed to update this staff record');
              return redirect()->route('404'); 
            }
            if( RegisterStaffInformation::where(['id'=>protectData($request->id)])->exists()){
              $image = $request->file('profileImage');
              $staffInformation = RegisterStaffInformation::find(protectData($request->id));                              
              $FileSystem = new Filesystem();
              $directory = public_path().'/uploads/';
              if($image ==NULL || $image =='' ){
                
                if($staffInformation->staff_profile_image !=Null || $staffInformation->staff_profile_image !='' ){
                  
                }else{
                  $staffInformation->staff_profile_image = $image; 
                }
              }elseif($image->getFilename().'.'.$image->getClientOriginalExtension() != $staffInformation->staff_profile_image){
                  if($FileSystem->exists($directory.$image->getFilename().'.'.$image->getClientOriginalExtension())){
                    unlink(public_path('uploads/'.$staffInformation->staff_profile_image));                              
                    Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                    $staffInformation->staff_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                  }
                  //dd($image->getFilename());
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $staffInformation->staff_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
              }else{
                if($FileSystem->exists($directory.$staffInformation->staff_profile_image)){
                  unlink(public_path('uploads/'.$staffInformation->staff_profile_image));                              
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $staffInformation->staff_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                }
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                $staffInformation->staff_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
              } 
              $firstname=$request->input('firstname');
              $middlename=$request->input('middlename');
              $lastname=$request->input('lastname');
              $maritalStatus=$request->input('maritalStatus');
              $dob=$request->input('dob');
              $gender=$request->input('gender');
              $phone=$request->input('phone');
              $city=$request->input('city');
              $socialMedia=$request->input('socialMedia');
              $address=$request->input('address');
              $state=$request->input('state');
              $hobbies = $request->input('hobbies');
              $disabilityStatus=$request->input('disabilityStatus');
              $listDisability=$request->input('listDisability');
              $localG=protectData($request->input('localG'));
              if($disabilityStatus =='yes'  && $listDisability ==''){
                $request->session()->flash('listDisability', 'List your Disability'); 
                return redirect()->route('edit-staff',['id' => $request->id]);                        
              }           
              $rules=array(
                'firstname'=>'required',
                'middlename'=>'required',
                'lastname'=>'required',
                'maritalStatus'=>'required',
                'disabilityStatus'=>'required',
                'dob'=>'required',
                'gender'=>'required',
                'phone'=>'required',
                'city'=>'required',
                'socialMedia'=>'required',
                'address'=>'required',
                'hobbies'=>'required',
                'state'=>'required',
                'localG'=>'required',
              );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){ 
              //return redirect()->route('edit-staff', ['id' => $id])->withErrors($validator);
              return redirect()->route('edit-staff',['id' => $request->id])->withErrors($validator);     
            }else{                                                                       
              $staffInformation->staff_firstname= protectData($firstname);
              $staffInformation->staff_middlename= protectData($middlename);
              $staffInformation->staff_lastname= protectData($lastname);            
              $staffInformation->staff_marital_status= protectData($maritalStatus);
              $staffInformation->staff_gender= protectData($gender);            
              $staffInformation->staff_phone= protectData($phone);
              $staffInformation->staff_dob= protectData($dob);
              $staffInformation->staff_disability= protectData($disabilityStatus);
              $staffInformation->staff_list_disability= protectData($listDisability);
              $staffInformation->staff_hobbies= protectData($hobbies);
              $staffInformation->staff_address= protectData($address);
              $staffInformation->staff_city= protectData($city);
              $staffInformation->staff_social_media= protectData($socialMedia);
              $staffInformation->staff_state= protectData($state);
              $staffInformation->staff_localG= protectData($localG);
              if($staffInformation->save()){
                $request->session()->flash('messageSuccess', 'Staff with email, '.$request->email.' is successfully updated');                                                           
              }else{
                $request->session()->flash('message', 'Staff with email, '.$request->email.' is not successfully updated');                       
              }
              return back()->with($request->id);  
            }                         
            }else{
              $request->session()->flash('message', 'You are not allowed to update this staff record');
              return back()->with($request->id); 
            }
                    
          }
          //show privilege page here
          public function registerPrivilegeSettings(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            } 
            if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
              $staffInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->where("status", NULL)->get();
            }else{
              $staffInformation= new RegisterStaffInformation;     
            }
            if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
              $staffPrivilegeInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->where("status", NULL)->paginate(10);
              $roleIdSInformation = Permit::all();
            }else{
              $staffPrivilegeInformation= new RegisterStaffInformation;
              $roleIdSInformation = new Permit;
            }                     
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
              $allSchoolInformation = Corox_model::all(); 
            }else{
              $schoolInformation= new RegisterSchoolInformation;
              $allSchoolInformation = new Corox_model;
            }                     
            return view('settings-privilege',['date'=>$date,'schoolInformation'=> $schoolInformation, 'allSchoolInformation'=> $allSchoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=> $staffInformation, 'staffPrivilegeInformation'=> $staffPrivilegeInformation, 'roleIdSInformation'=>$roleIdSInformation, 'paginator'=> $staffPrivilegeInformation, 'userId'=>$userId, 'title'=>'Setting Privilege']);
            
          }
          
          public function registerPrivilege(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if($request->privilege !="none" || $request->privilege !=null){
                      
              if($request->privilege == "access"){
                $member ='member';
                if($request->staffEmail =="none" || $request->staffEmail ==null ){
                  return response()->json(['staff'=>'danger','message'=>'Please select a staff']);            
                }else{
                  $reg_id=$result=DB::table('corox_models')->where('email',protectData($request->staffEmail))->first();
                  if($reg_id !=null){
                    $role_id =4;
                    $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();
                    if($checkRole !== null){
                      $role_id =2;
                      $permit= $checkRole->update(['role_id'=>$role_id]);
                      if($permit){
                        return response()->json(['success'=>'success','message'=>'You have successfully re-assign staff with email '.$request->staffEmail.' an access privilege']);      
                      }                  
                    }elseif($checkRole === null){
                      $role_id =2;
                      $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();
                      if($checkRole === null){
                        // dd($reg_id->id);
                        $role_id =2;
                        $permit= new Permit;
                        $permit->role_id=$role_id;
                        $permit->corox_model_id=$reg_id->id;
                        if($permit->save()){
                                  if(Corox_model::where("email",protectData($request->staffEmail))->exists()){
                                            $userInformation = Corox_model::where("email",protectData($request->staffEmail))->first();
                                            if(RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->exists()){
                                                      $staffInformation = RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->first();
                                                      $staffInformation= $staffInformation->update(['user_corox_model_id'=>$userInformation->id]);
                                                      if($staffInformation){                                                                                          
                                                                return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                                                            
                                                      }else{
                                                                return response()->json(['success'=>'danger','message'=>'Problem assigning staff with email '.$request->staffEmail.' an access privilege']);                         
                                                      }
                                            }else{
                                                      return response()->json(['success'=>'danger','message'=>'staff with email '.$request->staffEmail.' can not be found']);                         
                                            }
                                  }else{
                                            return response()->json(['success'=>'danger','message'=>'user with email '.$request->staffEmail.' can not be found']);                      
                                  }
                        }                 
                      }else{
                       return response()->json(['success'=>'danger','message'=>'The staff with email '.$request->staffEmail.' has already been assigned an access privilege']);        
                      }                
                    }
                    return response()->json(['success'=>'danger','message'=>'The staff with email '.$request->staffEmail.' has already been assigned an access privilege']);        
                  }else{
                            $user = new Corox_model;
                            $user->email=protectData($request->staffEmail);
                            $user->password=Hash::make('dlocenots');
                            $user->remember_token=protectData($request->_token);
                            if($user->save()){          
                              $role_id=DB::table('roles')->where('role',$member)->first();
                              $permit= new Permit;
                              $permit->role_id=$role_id->id;
                              $permit->corox_model_id=$user->id;
                              if($permit->save()){
                                if(RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->exists()){
                                  $staffInformation = RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->first();
                                  $staffInformation= $staffInformation->update(['user_corox_model_id'=>$user->id]);
                                  if($staffInformation){                                                                                          
                                    return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                                                            
                                  }else{
                                    return response()->json(['success'=>'danger','message'=>'Problem assigning staff with email '.$request->staffEmail.' an access privilege']);                         
                                  }
                                }
                                return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                         
                              }
                            }
                  }
                }  
              }elseif($request->privilege == "onhold"){
                $role_id =4;
                $userId=Auth::user()->id;
                if($request->staffEmail =="none" || $request->staffEmail ==null ){
                  return response()->json(['staff'=>'danger','message'=>'Please select a staff']);     
                }else{
                  $reg_id=$result=DB::table('corox_models')->where('email',protectData($request->staffEmail))->first();
                  if($reg_id->id != null){
                    $role_id =2;
                    $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();
                    if($checkRole !== null){
                      $role_id =4;
                      $permit= $checkRole->update(['role_id'=>$role_id]);
                      if($permit){
                        return response()->json(['success'=>'success','message'=>'You have successfully put staff with email '.$request->staffEmail.' privilege on hold']);      
                      }                  
                    }elseif($checkRole === null){
                      $role_id =4;
                      $checkRole = Permit::where(["role_id"=>$role_id, "corox_model_id"=>$reg_id->id])->first();                                                            
                      if($checkRole === null){
                        $role_id =4;
                        $permit= new Permit;
                        $permit->role_id=$role_id;
                        $permit->corox_model_id=$reg_id->id;
                        if($permit->save()){
                          if(Corox_model::where("email",protectData($request->staffEmail))->exists()){
                            $userInformation = Corox_model::where("email",protectData($request->staffEmail))->first();
                            if(RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->exists()){                                                                                                    
                              $staffInformation = RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail),"corox_model_id"=>$userId])->first();
                              $staffInformation = $staffInformation->update(['user_corox_model_id'=>$reg_id->id]);
                              if($staffInformation){                                                                                          
                                return response()->json(['success'=>'success','message'=>'You have successfully assign staff with email '.$request->staffEmail.' an access privilege']);                                                            
                              }else{
                                return response()->json(['success'=>'danger','message'=>'Problem assigning staff with email '.$request->staffEmail.' an access privilege']);                         
                              }
                            }else{
                              return response()->json(['success'=>'danger','message'=>'staff with email '.$request->staffEmail.' can not be found']);                         
                            }
                          }else{
                            return response()->json(['success'=>'danger','message'=>'user with email '.$request->staffEmail.' can not be found']);                      
                          }                                                                                          
                        }                 
                      }else{
                        return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' privilege is already on hold contact the administrator']);  
                      }                
                    }                                                            
                    return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' privilege is on hold contact the administrator']);        
                  }else{
                    $user = new Corox_model;
                    $user->email=protectData($request->staffEmail);
                    $user->password=Hash::make('dlocenots');
                    $user->remember_token=protectData($request->_token);
                    if($user->save()){
                      $permit= new Permit;
                      $permit->role_id=$role_id;
                      $permit->corox_model_id=$user->id;
                      if($permit->save()){
                        if(RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->exists()){
                          $staffInformation = RegisterStaffInformation::where(["staff_email"=>protectData($request->staffEmail), "corox_model_id"=>$userId])->first();
                          $staffInformation= $staffInformation->update(['user_corox_model_id'=>$user->id]);
                          if($staffInformation){                                                                                          
                            return response()->json(['success'=>'success','message'=>'The staff with an email '.$request->staffEmail.' privilege as been put onhold']);                                                            
                          }else{
                            return response()->json(['success'=>'danger','message'=>'Problem putting staff with email '.$request->staffEmail.' privilege onhold']);                         
                          }
                        }                                                                      
                      }
                    }
                  }                                                      
                }                                        
              }elseif($request->privilege == "remove"){
                $userId=Auth::user()->id;
                if($request->staffEmail =="none" || $request->staffEmail ==null ){
                  return response()->json(['staff'=>'danger','message'=>'Please select a staff']);     
                }else{
                  $reg_id=$result=DB::table('corox_models')->where('email',protectData($request->staffEmail))->first();
                  if(Permit::where("corox_model_id", $reg_id->id)->where("status", "!=", "delete")->exists()){
                    //soft delete
                    $remove = Permit::where("corox_model_id",$reg_id->id)->update('status', 'delete');
                    if($remove){
                      return response()->json(['success'=>'success','message'=>'The staff with an email '.$request->staffEmail.' privilege as been deleted']);                             
                    }else{
                      return response()->json(['success'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' has no privilege']);                                                              
                    }  
                  }else{
                    return response()->json(['staff'=>'danger','message'=>'The staff with an email '.$request->staffEmail.' has no privilege']);                                                                   
                  }                                                  
                }                                    
              }else{
                return response()->json(['privilege'=>'danger','message'=>'You have no right to set privilege, please select privilege']);          
              }
      
            }else{

              return response()->json(['privilege'=>'danger','message'=>'Privilege is not selected']);     
            }
            
          }
          public function registerPrivilegeEnableSettings(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if($request->read == "on"){
              $readOnly ="readonly";
              $staffInformation = RegisterSchoolInformation::where(["corox_model_id"=>$userId])->first();     
              $staffInformation->update(['school_enable'=>$readOnly]);
              return response()->json(['success'=>'success','message'=>'You have successfully disabled school settings information']);
            }elseif($request->read == "off"){
              $readOnly ="";
              $staffInformation = RegisterSchoolInformation::where(["corox_model_id"=>$userId])->first();     
              $staffInformation->update(['school_enable'=>$readOnly]);
              return response()->json(['success'=>'danger','message'=>'You have successfully enabled school settings information']);                              
            }else{
              $readOnly ="readonly";
              $staffInformation = RegisterSchoolInformation::where(["corox_model_id"=>$userId])->first();     
              $staffInformation->update(['school_enable'=>$readOnly]);
              return response()->json(['success'=>'danger','message'=>'contact the administrator, you don\'t have the right privilege']);
            }          
          }
          //show staffs here
          public function registerViewStaffs(){
                    if(Auth::user()->isMember()){
                      $roleId =1;
                      $roleInformation = Permit::where("role_id",$roleId)->first();
                      $userId= $roleInformation->corox_model_id;
                      $date = date('Y');
                      $adminInformation = Corox_model::where("id",$userId)->first();
                      $adminEmail=$adminInformation->email;
                      //return redirect('/Dregister/dashboard');
                    }elseif(Auth::user()->isAdmin()){  
                      $email= Auth::user()->email;
                      $date = date('Y');
                      $userId=Auth::user()->id;
                      $adminEmail=Auth::user()->email;
                    }
                    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
                      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
                    }else{
                      $schoolInformation= new RegisterSchoolInformation;     
                    }
                    if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
                      $staffInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->paginate(10);    
                    }else{
                      $staffInformation= new RegisterStaffInformation;     
                    }                    
                    return  view('view-staffs-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'staffInformation'=> $staffInformation, 'paginator'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'View Staff Table']);
          }
          public function registerViewStaff($id){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            $staffInformation = DB::table('register_staff_informations')->where('id', $id)->get();           
            return  view('view-staffs-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'staffInformation'=> $staffInformation, 'paginator'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
  }          
          //show general page here
          public function registerGeneralSettings(){
            /* if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }*/
            if(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            return view('general-settings',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'General Settings']);
          }          
          //show edit staff here
          public function registerEditStaff(Request $request, $id){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }

            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if( $id == null || $id == '' || !is_numeric($id)){
              $request->session()->flash('message', 'You are not allowed to edit this staff');
              return redirect()->route('404'); 
            }             
            if(RegisterStaffInformation::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->exists()){
              $staffInformation = RegisterStaffInformation::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->first();
            }else{
              $request->session()->flash('message', 'You are not allowed to edit this staff');                               
              return redirect()->route('404');    
            }                    
            return  view('edit-staff',['date'=>$date,'schoolInformation'=> $schoolInformation, 'staffInformation'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Eidt Staff']);
          }
          //show delete staff here
          public function registerDeleteStaff($id){
            if(Auth::user()->isMember()){
                      $roleId =1;
                      $roleInformation = Permit::where("role_id",$roleId)->first();
                      $userId= $roleInformation->corox_model_id;
                      $date = date('Y');
                      $adminInformation = Corox_model::where("id",$userId)->first();
                      $adminEmail=$adminInformation->email;
                      //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if($id == null || $id == '' || is_nan($id)){
              return response()->json(['success'=>'fail','message'=>'You are not allowed to delete this staff']);                   
            }
            if(RegisterStaffInformation::where("id",protectData($id))->exists()){
                      if(RegisterStaffInformation::where("id",protectData($id))->exists()){
                                $staffInformation = RegisterStaffInformation::where("id",protectData($id))->first();
                                if(Corox_model::where("id",$staffInformation->user_corox_model_id)->exists()){
                                          if(Corox_model::where("id",$staffInformation->user_corox_model_id)->update("status", "delete")){
                                                      if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->exists()){
                                                              if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->update("status", "delete")){
                                                                        if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
                                                                                  if(RegisterStaffTeacher::where("staff_id",protectData($id))->update("status","delete" )){
                                                                                            if(RegisterStaffInformation::where(protectData($id))->update("status", "delete")){
                                                                                                      return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                            }
                                                                                  }                                
                                                                        }else{
                                                                                 //soft delete
                 
                                                                                  if(RegisterStaffInformation::where(protectData($id))->update('status', 'delete')){
                                                                                            return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                  }                                                                      
                                                                        }
                                                      
                                                              }                                                               
                                                      }else{
                                                              if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
                                                                
                                                                        if(RegisterStaffTeacher::where("staff_id",protectData($id))->update('status', 'delete')){
                                                                                  if(RegisterStaffInformation::where(protectData($id))->update('status', 'delete')){
                                                                                            return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                  }
                                                                        }                                
                                                              }else{
                                                                        if(RegisterStaffInformation::where(protectData($id))->update('status', 'delete')){
                                                                                  return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                        }                                                                      
                                                              }                                                            
                                                      }
  
                                          }                                                  
                                }else{
                                          if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->exists()){
                                                    if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->update("status", "delete")){
                                                              if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
                                                                        if(RegisterStaffTeacher::where("staff_id",protectData($id))->update("status", "delete")){
                                                                                  if(RegisterStaffInformation::where(protectData($id))->update("status", "delete")){
                                                                                            return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                                  }
                                                                        }                                
                                                              }else{
                                                                        if(RegisterStaffInformation::where(protectData($id))->update("status", "delete")){
                                                                                  return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                        }                                                                      
                                                              }
                                            
                                                    }                                                               
                                          }else{
                                                    if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
                                                              if(RegisterStaffTeacher::where("staff_id",protectData($id))->update("status", "delete")){
                                                                        if(RegisterStaffInformation::where(protectData($id))->update("status", "delete")){
                                                                                  return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                                        }
                                                              }                                
                                                    }else{
                                                              if(RegisterStaffInformation::where(protectData($id))->update("status", "delete")){
                                                                        return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                                                              }                                                                      
                                                    }                                                            
                                          }                                                  
                                }

                                
                      }else{
                                return response()->json(['success'=>'danger','message'=> 'No current staff record']);                                   
                      }                               

                      
            }else{
              return response()->json(['success'=>'danger','message'=> 'No current staff record']);                                   
            } 

          }
          //create class for register ajax
          public function registerAddClass(Request $request){
            $userId=Auth::user()->id;
            if($request->input('class') == ''){
              return response()->json(['class'=>'danger','message'=>'Class name is required']);
            }elseif($request->input('date') ==''){
              return response()->json(['date'=>'danger','message'=>'Date created is required']);
            }else{
              $class = protectData($request->input('class'));
              $date = protectData($request->input('date'));
              $userCheck= RegisterClasses::where('class_name',$class)->first();
              if($userCheck !=null){
                return response()->json(['failure'=>'danger','message'=> ucfirst($class).' has already been created']);
              }else{
                $class_result= new RegisterClasses;
                $classs_result->class_name=$class;
                $class_result->corox_model_id = $userId;
                $class_result->class_date= $date;
                if($classes->save()){
                  return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->class.' class']);      
                }else{
                  return response()->json(['failure'=>'danger','message'=> $request->class.' class not created, contact the administrator']);     
                }                                                
              }
            }            
          }
          // create subject for register ajax
          public function registerAddSubject(Request $request){
            $userId=Auth::user()->id;
            if($request->input('subject') == ''){
              return response()->json(['subject'=>'danger','message'=>'Subject name is required']);
            }elseif($request->input('date') ==''){
              return response()->json(['date'=>'danger','message'=>'Date created is required']);
            }else{
              $subject = protectData($request->input('subject'));
              $date = protectData($request->input('date'));
              $userCheck= RegisterSubject::where('subject_name',$subject)->first();
              if($userCheck !=null){
                return response()->json(['failure'=>'danger','message'=> ucfirst($subject).' has already been created']);
              }else{
                $subject_result= new RegisterSubject;
                $subject_result->subject_name=$subject;
                $subject_result->corox_model_id = $userId;
                $subject_result->subject_date= $date;
                if($subject_result->save()){
                  return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->subject.' subject']);      
                }else{
                  return response()->json(['failure'=>'danger','message'=> $request->subject.' subject not created, contact the administrator']);     
                }                                                
              }                    

            }
          }
          // create period for register ajax
          public function registerAddPeriod(Request $request){
            $userId=Auth::user()->id;
            if($request->input('period') == ''){
              return response()->json(['period'=>'danger','message'=>'Period name is required']);
            }elseif($request->input('date') ==''){
              return response()->json(['date'=>'danger','message'=>'Date created is required']);
            }else{
              $period = protectData($request->input('period'));
              $date = protectData($request->input('date'));
              $userCheck= RegisterPeriod::where('period_name',$period)->first();
              if($userCheck !=null){
                return response()->json(['failure'=>'danger','message'=> ucfirst($period).' has already been created']);
              }else{
                $period_result= new RegisterPeriod;
                $period_result->period_name=$period;
                $period_result->corox_model_id = $userId;
                $period_result->period_date= $date;
                if($period_result->save()){
                  return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->period.' period']);      
                }else{
                  return response()->json(['failure'=>'danger','message'=> $request->period.' period not created, contact the administrator']);     
                }                                                
              }                    

            }
          }
          // show page to assign subject
          public function registerAssignSubject(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            return  view('assign-subject',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Subject']);
          }
          // show page to assign teacher
          public function registerTeacher(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if(RegisterClasses::where("corox_model_id",$userId)->exists()){
                      $classes = RegisterClasses::where("corox_model_id",$userId)->get();
            }else{
              $classes= new RegisterClasses;     
            }
            if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
              $staffInformation = RegisterStaffInformation::where("corox_model_id",$userId)->where("status", NULL)->get();
            }else{
              $staffInformation= new RegisterStaffInformation;     
            }
            if(RegisterStaffTeacher::where("corox_model_id",$userId)->exists()){
              $informations =RegisterStaffTeacher::where("corox_model_id",$userId)->paginate(10);
              $staffs =RegisterStaffInformation::where("corox_model_id",$userId)->where("status", NULL)->get();
              $classes =RegisterClasses::where("corox_model_id",$userId)->get();
              $teacherInformation = array();
              foreach($informations as $teacher){
                $class =RegisterClasses::where("id",$teacher->class_id)->first(); 
                $information =RegisterStaffInformation::where("id",$teacher->staff_id)->first();
                $teacherInformation[]=array('id'=>$information->id, 'staffName'=>$information->staff_firstname.' '.$information->staff_lastname, 'class_id'=>$class->id, 'className'=>$class->class_name, 'teacherRole'=>$teacher->teacher_role );
                  
              }
                      
            }else{
              $teacherInformation= '';
              $informations = new RegisterStaffTeacher;
              $staffs = new RegisterStaffInformation;      
            }
            
            return  view('add-teacher',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=>$staffInformation, 'classes'=>$classes, 'staffs' =>$staffs, 'teacherInformation'=>$teacherInformation, 'paginator'=>$informations, 'classes'=>$classes, 'userId'=>$userId,'teacher', 'title'=>'Add Teacher']);
          }
          // create period for register ajax
          public function registerAddTeacher(Request $request){
            if($request->staffId =='' || $request->staffId =='none' ){     
              return response()->json(['success'=>'danger','message'=> 'Please select staff name']);                                   
            }elseif($request->teacherRole =='' || $request->teacherRole =='none'){
              return response()->json(['success'=>'danger','message'=> 'Please select teacher\'s role']);                                                                 
            }elseif($request->classId =='' || $request->classId =='none'){
              return response()->json(['success'=>'danger','message'=> 'Please select a class']);                                                                 
            }
            
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterStaffTeacher::where(["class_id"=>protectData($request->classId),"corox_model_id"=>$userId])->exists()){
              $teacher =RegisterStaffTeacher::where("class_id",protectData($request->classId))->first();
              $staff =RegisterStaffInformation::where("id",$teacher->staff_id)->first();
              $class =RegisterClasses::where("id",protectData($request->classId))->first();
              if(RegisterStaffTeacher::where(["class_id"=>protectData($request->classId),"teacher_role"=>protectData($request->teacherRole),"corox_model_id"=>$userId])->exists()){
              
                if($request->teacherRole[0] =="subjectteacher"){
                  $newTeacherRole = protectData($request->teacherRole[0]).','.$teacher->teacher_role;
                    $teacher=RegisterStaffTeacher::where(["class_id"=>protectData($request->classId), "teacher_role"=>"classteacher","staff_id"=>protectData($request->staffId)])->first();
                  //$teacherRole =explode(',',$checkRole->teacher_role);
                  if( $teacher->teacher_role == "classteacher"){
                    if(RegisterStaffTeacher::where(["class_id"=>protectData($request->classId), "teacher_role"=>"classteacher","staff_id"=>protectData($request->staffId)])->exists()){
                    
                      if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){

                        $class =RegisterClasses::where("id",protectData($request->classId))->first();
                        if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                          $teacherRole = $request->teacherRole[0]; 
                        }
                        $teacher= new RegisterStaffTeacher;
                        $teacher->staff_id=protectData($request->staffId);
                        $teacher->class_id=protectData($request->classId);
                        $teacher->teacher_role= $teacherRole;                    
                        $teacher->corox_model_id = $userId;
                        if($teacher->save()){
                          if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                            $teacherRole = $request->teacherRole[0];
                            return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                                                      
                          }                     
          
                        }
                      }
                    }elseif(isset($request->teacherRole[1]) && $request->teacherRole[0].','.$request->teacherRole[1] == "subjectteacher,classteacher"){                       
                      
                      return response()->json(['success'=>'danger','message'=> $request->staffName.' has already been assiged as a '.$request->teacherRole[0].' and as a '.$request->teacherRole[1].' to '.$class->class_name.' class']);                                                       
                    } 

                    $teacherRole =explode(',',$teacher->teacher_role);
                    return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                  
                  }elseif(isset($teacherRole[1]) && $request->teacheRole == $teacherRole[1]){
                    $teacherRole =explode(',',$teacher->teacher_role);
                    return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                  }
                  $checkRole = RegisterStaffTeacher::where(["staff_id"=>protectData($request->staffId)])->first();
                  if($checkRole->update(["teacher_role"=>$newTeacherRole])){
                            return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a'.$teacher->teacher_role. ' and  as a '.$request->teacherRole[0]]);      
                  }                                                   
                }                                                   
                return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$request->teacherRole.' to '.$class->class_name.' class']);        
              }elseif($request->classId == $class->id){
                if($request->teacherRole[0] =="subjectteacher"){
                  $newTeacherRole = protectData($request->teacherRole[0]).','.$teacher->teacher_role;
                  //$teacherRole =explode(',',$checkRole->teacher_role);
                  if( $teacher->teacher_role == "subjectteacher,classteacher"){
                    if(RegisterStaffTeacher::where(["class_id"=>protectData($request->classId), "teacher_role"=>"subjectteacher,classteacher"])->exists()){
                      if($request->teacherRole[0] == "subjectteacher"){
                        $class =RegisterClasses::where("id",protectData($request->classId))->first();
                        if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                          $teacherRole = $request->teacherRole[0]; 
                        }
                        $teacher= new RegisterStaffTeacher;
                        $teacher->staff_id=protectData($request->staffId);
                        $teacher->class_id=protectData($request->classId);
                        $teacher->teacher_role= $teacherRole;                    
                        $teacher->corox_model_id = $userId;
                        if($teacher->save()){
                          if($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                            $teacherRole = $request->teacherRole[0];
                            return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                                                      
                          }                     
                        }
                      }
                    }                                                            
                    $teacherRole =explode(',',$teacher->teacher_role);
                    return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                  }elseif(isset($teacherRole[1]) && $request->teacheRole == $teacherRole[1]){
                    $teacherRole =explode(',',$teacher->teacher_role);
                    return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                  }
                  $checkRole = RegisterStaffTeacher::where(["staff_id"=>protectData($request->staffId)])->first();
                  if($checkRole->update(["teacher_role"=>protectData($newTeacherRole)])){
                    return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a'.$teacher->teacher_role. ' and  as a '.$request->teacherRole[0]]);      
                  }                                                   
                }elseif($request->teacherRole[0] =="classteacher"){
                  $newTeacherRole = $teacher->teacher_role.','.$request->teacherRole[0];
                  //$teacherRole =explode(',',$checkRole->teacher_role);
                  if( $teacher->teacher_role == "subjectteacher,classteacher"){
                    $teacherRole =explode(',',$teacher->teacher_role);
                    return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                  }elseif(isset($teacherRole[1]) && $request->teacheRole == $teacherRole[1]){
                    $teacherRole =explode(',',$teacher->teacher_role);
                    return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$teacherRole[0].' and as a '. $teacherRole[1].' you can\'t assign '.$request->staffName.' as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);                           
                  }elseif(RegisterStaffTeacher::where(["staff_id"=>protectData($request->staffId)])->exists()){
                    $newTeacherRole = $request->teacherRole[0].','.$teacher->teacher_role;
                    $checkRole = RegisterStaffTeacher::where(["staff_id"=>protectData($request->staffId)])->first();
                    if($checkRole->update(["teacher_role"=>protectData($newTeacherRole)])){
                      return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a'.$teacher->teacher_role. ' and  as a '.$request->teacherRole[0]]);      
                    }
                  }
                }                                                                            
              }
              //return response()->json(['success'=>'danger','message'=> $staff->staff_firstname.' '.$staff->staff_lastname.' has already been assigned as a '.$request->teacherRole[0].' to '.$class->class_name.' class']);       
            }elseif(RegisterStaffTeacher::where(["staff_id"=>protectData($request->staffId)])->exists()){

              $teacher =RegisterStaffTeacher::where("staff_id",protectData($request->staffId))->first();
              $teacherRole =explode(',',$teacher->teacher_role);
              if(isset($request->teacherRole[1]) && $request->teacherRole[0].','.$request->teacherRole[1] ==  $teacherRole[0].','.$teacherRole[1]){
              }elseif($request->teacherRole[0] == "classteacher"){
              }
            }
            $class =RegisterClasses::where("id",protectData($request->classId))->first();
            if( $request->teacherRole[0] =="classteacher" && !isset($request->teacherRole[1])){
              $teacherRole = $request->teacherRole[0];  
            }elseif($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
              $teacherRole = $request->teacherRole[0]; 
            }elseif( $request->teacherRole[0].','.$request->teacherRole[1] == "subjectteacher,classteacher"){         
              $teacherRole = $request->teacherRole[0].','.$request->teacherRole[1]; 
            }
            $teacher= new RegisterStaffTeacher;
            $teacher->staff_id=protectData($request->staffId);
            $teacher->class_id=protectData($request->classId);
            $teacher->teacher_role= protectData($teacherRole);                    
            $teacher->corox_model_id = $userId;
            if($teacher->save()){
                      
              if( $request->teacherRole[0] =="classteacher" && !isset($request->teacherRole[1])){
                $teacherRole = $request->teacherRole[0];
                return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                           
              }elseif($request->teacherRole[0] == "subjectteacher" && !isset($request->teacherRole[1])){
                $teacherRole = $request->teacherRole[0];
                return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$teacherRole.' '.$class->class_name]);                                                      
              }elseif($request->teacherRole[0].','.$request->teacherRole[1] == "subjectteacher,classteacher"){
                $teacherRole = implode(',',$request->teacherRole);
                return response()->json(['success'=>'success','message'=>'You have successfully assigned staff with a name '.$request->staffName.' as a '.$request->teacherRole[0].' and as a '.$request->teacherRole[1].' to '.$class->class_name.' class']);                                                       
              }                         

            }else{
              return response()->json(['success'=>'danger','message'=> ' Assigning staff with a name '.$request->staffName.' as a teacher is not successful']);     
            }                  
          }
          //delete teacher register ajax
          public function registerDeleteTeacher($id){
            if(RegisterStaffTeacher::where("staff_id",$id)->exists()){
              RegisterStaffTeacher::where("staff_id",$id)->update("status", "delete");
              return response()->json(['success'=>'success','message'=>'Teacher with an id '.$id.' has been deleted successfully']);
            
            }else{
              return response()->json(['success'=>'danger','message'=>'Contact the administrator the teacher with an '.$id.' is not found' ]);  
            }                            
          }
          //update teacher register ajax
          public function registerUpdateTeacher(Request $request){
            if($request->staffId =='' || $request->staffId =='none' ){
              return response()->json(['success'=>'danger','message'=> 'Please select staff name']);                                   
            }elseif($request->teacherRole =='' || $request->teacherRole =='none'){
              return response()->json(['success'=>'danger','message'=> 'Please select teacher\'s role']);                                                                 
            }elseif($request->classId =='' || $request->classId =='none'){
              return response()->json(['success'=>'danger','message'=> 'Please select a class']);                                                                 
            }
            $checkRole = RegisterStaffTeacher::where(["staff_id"=>$request->staffId])->first();
            if(RegisterStaffTeacher::update("staff_id",$request->staffId)){
              return response()->json(['success'=>'success','message'=>'Teacher with an id '.$id.' has been updated successfully']);
            }       
          }
           // show page show staff register list for clock in
          public function registerStaffRegister(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if(RegisterStaffInformation::where("corox_model_id",$userId)->exists()){
              $staffInformation = DB::table('register_staff_informations')->whereNotNull('staff_firstname')->whereNotNull('staff_lastname')->whereNotNull('staff_email')->whereNotNull('staff_gender')->whereNotNull('staff_marital_status')->whereNotNull('staff_phone')->where("status", NULL)->paginate(10);    
            }else{
              $staffInformation= new RegisterStaffInformation;     
            }                 
            if(RegisterStaffRegister::where("corox_model_id",$userId)->orderBy("register_date",'DESC')->exists()){
              $registerInformations =RegisterStaffRegister::where("corox_model_id",$userId)->paginate(10);
                $registerStaffInformation = array();
              foreach($registerInformations as $registerStaff){
                $information =RegisterStaffInformation::where("id",$registerStaff->staff_id)->first();
                $registerStaffInformation[]=array('id'=>$information->id, 'staffName'=>ucfirst($information->staff_firstname).' '.ucfirst($information->staff_lastname), 'registerDate'=>$registerStaff->register_date, 'registerTime'=>$registerStaff->register_time, 'resumptionStatus'=>$registerStaff->register_resumption_status);
                  
              }
                      
            }else{
              $registerStaffInformation= new RegisterStaffInformation;         
            }
            
            return  view('staff-register',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=>$staffInformation, 'registerStaffInformation'=>$registerStaffInformation, 'paginator'=>$registerInformations,'userId'=>$userId, 'title'=>'Staff Register']);
          }
           // show page to for staff register list for clock in
          public function registerStaffTimeRegister(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }   
            //checking staff resumption time if is with resumption time
            $time = explode(' ',$request->registerTime);
            (int)$time_in =  $time[0];  
            if($time_in <= 7){
              $resumption_status ='on-time';
            }else{
              $resumption_status = 'late';
            } 

            if($request->staffName =='' || $request->staffName =='none' ){
              return response()->json(['staff'=>'danger','message'=> 'Please select staff name']);                                   
            }elseif($request->registerTime ==''){
              return response()->json(['time'=>'danger','message'=> 'Please select clock in time']);                                                                 
            }elseif($request->registerDate ==''){
              return response()->json(['date'=>'danger','message'=> 'Please select clock in date']);                                                                 
            }
            if(RegisterStaffRegister::where("corox_model_id",$userId)->exists()){
              if(RegisterStaffRegister::where(["corox_model_id" => $userId, "register_date"=>$request->registerDate, "staff_id"=>$request->staffName])->exists()){
                $staffInformation = RegisterStaffInformation::where("id",$request->staffName)->first();
                $staffName =ucfirst($staffInformation->staff_firstname).' '.ucfirst($staffInformation->staff_lastname);                              
                return response()->json(['success'=>'true','message'=> $staffName.' you can\'t clock in twice']);
              }
            }                    
            if(RegisterStaffInformation::where("id",protectData($request->staffName))->exists()){
              if(RegisterStaffRegister::where(["staff_id"=>protectData($request->staffName), "register_date"=>protectData($request->registerDate)])->exists()){
                        
                $staffRegister = RegisterStaffRegister::where(["staff_id"=>protectData($request->staffName), "register_date"=>protectData($request->registerDate)])->first();
                $staffInformation = RegisterStaffInformation::where("id",$staffRegister->staff_id)->first();
                $staffName =ucfirst($staffInformation->staff_firstname).' '.ucfirst($staffInformation->staff_lastname);
                return response()->json(['success'=>'danger','message'=>$staffName.' you already clock in at '.$staffRegister->register_time.', today clocking in twice a day is not allowed']);      
              
              }                              
            $staffInformation = RegisterStaffInformation::where("id",protectData($request->staffName))->first();
            $staffName =ucfirst($staffInformation->staff_firstname).' '.ucfirst($staffInformation->staff_lastname);
            $staffId = $staffInformation->id;
            
            }else{
              return response()->json(['success'=>'danger','message'=> 'Please contact the administrator, staff with an id' .$request->staffName.'  record can\'t be found']);                                                                                      
            }

            $staffRegister= new RegisterStaffRegister;
            $staffRegister->staff_id=protectData($staffId);
            $staffRegister->corox_model_id =  protectData($userId);
            $staffRegister->register_date= protectData($request->registerDate);
            $staffRegister->register_time= protectData($request->registerTime);
            $staffRegister->register_resumption_status= $resumption_status;
            if($staffRegister->save()){                            
              return response()->json(['success'=>'success','message'=>$staffName.' you clock in at exactly '.$request->registerTime.' today, you can do better tomorrow, do have a nice day at work ']);      
            }else{
              return response()->json(['success'=>'danger','message'=> $staffName.' your clock in time '.$request->registerTime.' not recorded, please contact the administrator']);     
            }                    
          }

           // show page show student register list for clock in
           public function registerStudentRegister(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if(RegisterStudentInformation::where("corox_model_id",$userId)->exists()){
              $studentInformation = DB::table('register_student_informations')->whereNotNull('student_firstname')->whereNotNull('student_lastname')->whereNotNull('student_email')->whereNotNull('student_gender')->whereNotNull('student_phone')->where("status", NULL)->paginate(10);    
            }else{
              $studentInformation= new RegisterStudentInformation;     
            }                 
            if(RegisterStaffRegister::where("corox_model_id",$userId)->orderBy("register_date",'DESC')->exists()){
              $registerInformations =RegisterStudentRegister::where("corox_model_id",$userId)->paginate(10);
                $registerStudentInformation = array();
              foreach($registerInformations as $registerStudent){
                $information =RegisterStudentInformation::where("id",$registerStudent->student_id)->first();
                $registerStudentInformation[]=array('id'=>$information->id, 'studentName'=>ucfirst($information->student_firstname).' '.ucfirst($information->student_lastname), 'registerDate'=>$registerStudent->register_date, 'registerTime'=>$registerStudent->register_time, 'resumptionStatus'=>$registerStudent->register_resumption_status);
                  
              }
                      
            }else{
              $registerStudentInformation= new RegisterStudentInformation;         
            }
            
            return  view('students-register',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'studentInformation'=>$studentInformation, 'registerStudentInformation'=>$registerStudentInformation, 'paginator'=>$registerInformations,'userId'=>$userId, 'title'=>'Student Register']);
          }  
          
           // show page to for student register list for clock in
           public function registerStudentTimeRegister(Request $request){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }   
            //checking staff resumption time if is with resumption time
            $time = explode(' ',$request->registerTime);
            (int)$time_in =  $time[0];  
            if($time_in <= 7){
              $resumption_status ='on-time';
            }else{
              $resumption_status = 'late';
            } 

            if($request->studentName =='' || $request->studentName =='none' ){
              return response()->json(['student'=>'danger','message'=> 'Please select student name']);                                   
            }elseif($request->registerTime ==''){
              return response()->json(['time'=>'danger','message'=> 'Please select clock in time']);                                                                 
            }elseif($request->registerDate ==''){
              return response()->json(['date'=>'danger','message'=> 'Please select clock in date']);                                                                 
            }
            if(RegisterStudentRegister::where("corox_model_id",$userId)->exists()){
              if(RegisterStudentRegister::where(["corox_model_id" => $userId, "register_date"=>$request->registerDate, "student_id"=>$request->studentName])->exists()){
                $studentInformation = RegisterStudentInformation::where("id",$request->studentName)->first();
                $studentName =ucfirst($studentInformation->student_firstname).' '.ucfirst($studentInformation->student_lastname);                              
                return response()->json(['success'=>'true','message'=> $studentName.' you can\'t clock in twice']);
              }
            }                    
            if(RegisterStudentInformation::where("id",protectData($request->studentName))->exists()){
              if(RegisterStudentRegister::where(["student_id"=>protectData($request->studentName), "register_date"=>protectData($request->registerDate)])->exists()){
                        
                $studentRegister = RegisterStudentRegister::where(["student_id"=>protectData($request->studentName), "register_date"=>protectData($request->registerDate)])->first();
                $studentInformation = RegisterStudentInformation::where("id",$studentRegister->student_id)->first();
                $studentName =ucfirst($studentInformation->student_firstname).' '.ucfirst($studentInformation->student_lastname);
                return response()->json(['success'=>'danger','message'=>$studentName.' you already clock in at '.$studentRegister->register_time.', today clocking in twice a day is not allowed']);      
              
              }                              
            $studentInformation = RegisterStudentInformation::where("id",protectData($request->studentName))->first();
            $studentame =ucfirst($studentInformation->student_firstname).' '.ucfirst($studentInformation->student_lastname);
            $studentId = $studentInformation->id;
            
            }else{
              return response()->json(['success'=>'danger','message'=> 'Please contact the administrator, student with an id' .$request->staffName.'  record can\'t be found']);                                                                                      
            }

            $studentRegister= new RegisterStudentRegister;
            $studentRegister->student_id=protectData($studentId);
            $studentRegister->corox_model_id =  protectData($userId);
            $studentRegister->register_date= protectData($request->registerDate);
            $studentRegister->register_time= protectData($request->registerTime);
            $studentRegister->register_resumption_status= $resumption_status;
            if($studentRegister->save()){                            
              return response()->json(['success'=>'success','message'=>$studentName.' you clock in at exactly '.$request->registerTime.' today, you can do better tomorrow, do have a nice day at school']);      
            }else{
              return response()->json(['success'=>'danger','message'=> $studentName.' your clock in time '.$request->registerTime.' not recorded, please contact the administrator']);     
            }                    
          }          
          // show student page
          public function registerStudent(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if(RegisterClasses::where("corox_model_id",$userId)->exists()){
              $classes = RegisterClasses::where("corox_model_id",$userId)->get();
            }else{
              $classes= new RegisterClasses;     
            }
            if(RegisterParentInformation::where("corox_model_id",$userId)->exists()){
              $parents = RegisterParentInformation::where("corox_model_id",$userId)->where("status", NULL)->get();
            }else{
              $parents= new RegisterParentInformation;     
            }                  
            return  view('add-student',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'parents'=>$parents, 'classes'=>$classes,  'userId'=>$userId, 'title'=>'Add Student']);
          }
          //tracking page to post create student details
          public function registerAddStudent(Request $request){
            if(Auth::user()->email){  
              $email= Auth::user()->email;
              $date = date('Y');
            }
            if(RegisterStudentInformation::where("student_email",protectData($request->email))->exists()){
              $request->session()->flash('message', 'Please register this student with another email, '.$request->email.' is not available');
              return redirect()->route('add-student');
            }
            if(RegisterStudentInformation::where("student_registration_number",$request->registerNumber)->exists()){
              $request->session()->flash('message', 'Registration number '.$request->registerNumber.' has been used to by another student');
              return back();
            }
            $disabilityStatus=$request->input('disabilityStatus');
            $listDisability=$request->input('listDisability');
            if($disabilityStatus =='yes'  && $listDisability ==''){
              $request->session()->flash('listDisability', 'List your Disability'); 
              return redirect()->route('edit-staff',['id' => $request->id]);                        
            }                    
        
            $rules=array(
              'firstname'=>'required',
              'middlename'=>'required',
              'lastname'=>'required',
              'email'=>'required|email|unique:register_student_informations,student_email',
              'disabilityStatus'=>'required',
              'dob'=>'required',
              'gender'=>'required',
              'phone'=>'required',
              'city'=>'required',
              'registerNumber'=>'required',
              'className'=>'required',
              'address'=>'required',
              'hobbies'=>'required',
              'session' =>'required',
              'parentName'=>'required',
              'state'=>'required',
              'localG'=>'required',
            );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              return redirect()->route('add-student')->withErrors($validator);
            }else{ 
              $data = array();
              $image = $request->file('profileImage');

              if($image == NULL || $image =='' ){
                $data['student_profile_image']  = 'no image' ; 
              }else{                    
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                $data['student_profile_image'] =$image->getFilename().'.'.$image->getClientOriginalExtension();
              }
                                
              $data['student_firstname']= protectData($request->firstname);
              $data['student_middlename']= protectData($request->middlename);
              $data['student_lastname']= protectData($request->lastname);
              $data['student_email']= protectData($request->email);                    
              $data['student_gender']= protectData($request->gender);            
              $data['student_phone']= protectData($request->phone);
              $data['student_dob']= protectData($request->dob);
              $data['student_disability']= protectData($request->disabilityStatus);
              $data['student_list_disability']= protectData($request->listDisability);
              $data['student_hobbies']= protectData($request->hobbies);
              $data['student_registration_number']= protectData($request->registerNumber);                    
              $data['student_address']= protectData($request->address);
              $data['student_city']= protectData($request->city);
              $data['student_class_id']= protectData($request->className);
              $data['student_session']= protectData($request->session);
              $data['student_parent_id']= protectData($request->parentName);                    
              $data['student_state']= protectData($request->state);
              $data['student_localG']= protectData($request->localG);                 
              $data['user_corox_model_id'] = 0;
              $data['corox_model_id'] =protectData($request->userId);
              $schoolInformation= RegisterStudentInformation::create($data);    
              $request->session()->flash('messageSuccess', 'Student with email, '.$request->email.' is successfully created');                              
              return redirect()->route('add-student');
            }
          }
          //show edit Parent here
          public function registerEditStudent(Request $request, $id){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if( $id == null || $id == '' || !is_numeric($id)){
              $request->session()->flash('message', 'You are not allowed to edit this student');
              return redirect()->route('404');; 
            }             
            if(RegisterStudentInformation::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->exists()){
              $student = RegisterStudentInformation::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->first();
              if(RegisterClasses::where("corox_model_id",$userId)->exists()){
                $classes = RegisterClasses::where("corox_model_id",$userId)->get();
              }else{
                $classes= new RegisterClasses;     
              }
              if(RegisterParentInformation::where("corox_model_id",$userId)->exists()){
                $parentInformation = RegisterParentInformation::where("corox_model_id",$userId)->where("status", NULL)->get();
              }else{
                $parentInformation= new RegisterParentInformation;     
              }                               
              $information = array();
              $parent =RegisterParentInformation::where("id",$student->student_parent_id)->first();
              $class =RegisterClasses::where("id",$student->student_class_id)->first();
              $information[]=array('id'=>$student->id, 'classId'=>$student->student_class_id, 'className'=>$class->class_name, 'parentId'=>$student->student_parent_id, 'parentName'=>$parent->parent_firstname.' '.$parent->parent_lastname, 'gender'=>$parent->parent_gender);
                                          
            }else{
              $request->session()->flash('message', 'You are not allowed to edit this student');                               
              return redirect()->route('404');   
            }                    
            return  view('edit-student',['date'=>$date,'schoolInformation'=> $schoolInformation, 'studentInformation'=> $student, 'information'=> $information, 'parents'=> $parentInformation, 'classes'=> $classes, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Edit Student']);
          }
          //tracking page to post update staff detail
          public function registerUpdateStudent(Request $request){
            if(Auth::user()->isMember()){
              return redirect()->route('dashboard');
            }
            if(Auth::user()->email){  
              $email= Auth::user()->email;
              $date = date('Y');
            }
            if(Corox_model::where("email",protectData($request->email))->exists()){
              $request->session()->flash('message', 'Please register this student with another email, '.$request->email.' is not available');
              return back()->with($request->id);  
            }
            if($request->id == null || $request->id == '' || !is_numeric($request->id)){
              $request->session()->flash('message', 'You are not allowed to update this student record');
              return redirect()->route('404');;  
            }
  
            if( RegisterStudentInformation::where(['id'=>protectData($request->id)])->exists()){
              $image = $request->file('profileImage');
              $studentInformation = RegisterStudentInformation::find(protectData($request->id));                              
              $FileSystem = new Filesystem();
              $directory = public_path().'/uploads/';
              if($image ==NULL || $image =='' ){
                if($studentInformation->student_profile_image !=Null || $studentInformation->student_profile_image !='' ){
                  
                }else{
                  $studentInformation->student_profile_image = $image; 
                }
              }elseif($image->getFilename().'.'.$image->getClientOriginalExtension() != $studentInformation->student_profile_image){
                if($FileSystem->exists($directory.$image->getFilename().'.'.$image->getClientOriginalExtension())){
                  unlink(public_path('uploads/'.$studentInformation->student_profile_image));                              
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $studentInformation->student_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                }
                  //dd($image->getFilename());
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $studentInformation->student_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
                }else{
                  if($FileSystem->exists($directory.$studentInformation->student_profile_image)){
                    unlink(public_path('uploads/'.$studentInformation->student_profile_image));                              
                    Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                    $studentInformation->student_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                  }
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $studentInformation->student_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
                }  
                $disabilityStatus=$request->input('disabilityStatus');
                $listDisability=$request->input('listDisability');
                if($disabilityStatus =='yes'  && $listDisability ==''){
                  $request->session()->flash('listDisability', 'List your Disability'); 
                  return redirect()->route('edit-student',['id' => $request->id]);                        
                }                              
          
                $rules=array(
                  'firstname'=>'required',
                  'middlename'=>'required',
                  'lastname'=>'required',
                  'email'=>'required',
                  'disabilityStatus'=>'required',
                  'dob'=>'required',
                  'gender'=>'required',
                  'phone'=>'required',
                  'city'=>'required',
                  'className'=>'required',
                  'address'=>'required',
                  'hobbies'=>'required',
                  'session' =>'required',
                  'parentName'=>'required',
                  'state'=>'required',
                  'localG'=>'required',
                );
                $validator= Validator::make($request->all(),$rules);
                if($validator->fails()){
                  return redirect()->route('edit-student',['id' => $request->id])->withErrors($validator);
                }else{ 
                  $data = array();                            
                  $studentInformation->student_firstname= protectData($request->firstname);
                  $studentInformation->student_middlename= protectData($request->middlename);
                  $studentInformation->student_lastname= protectData($request->lastname);            
                  $studentInformation->student_email= protectData($request->email);
                  $studentInformation->student_gender= protectData($request->gender);            
                  $studentInformation->student_phone= protectData($request->phone);
                  $studentInformation->student_dob= protectData($request->dob);
                  $studentInformation->student_disability= protectData($request->disabilityStatus);
                  $studentInformation->student_list_disability= protectData($request->listDisability);
                  $studentInformation->student_hobbies= protectData($request->hobbies);                              
                  $studentInformation->student_address= protectData($request->address);
                  $studentInformation->student_city= protectData($request->city);
                  $studentInformation->student_class_id= protectData($request->className);
                  $studentInformation->student_session= protectData($request->session);
                  $studentInformation->student_parent_id= protectData($request->parentName);                              
                  $studentInformation->student_state= protectData($request->state);
                  $studentInformation->student_localG= protectData($request->localG);
                  if($studentInformation->save()){
                    $request->session()->flash('messageSuccess', 'Student with email, '.$request->email.' is successfully updated');                                                           
                  }else{
                    $request->session()->flash('message', 'Student with email, '.$request->email.' is not successfully updated');                       
                  }
                  return back()->with($request->id);  
                }                         
              }else{
                  $request->session()->flash('message', 'You are not allowed to update this Student record');
                  return back()->with($request->id); 
              }
            
            }
          //show students table here
          public function registerViewStudents(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if(RegisterStudentInformation::where("corox_model_id",$userId)->exists()){
                      $studentInformation = DB::table('register_student_informations')->whereNotNull('student_firstname')->whereNotNull('student_lastname')->whereNotNull('student_email')->whereNotNull('student_gender')->whereNotNull('student_phone')->whereNotNull('student_session')->where("status", "delete")->paginate(10);
            }else{
              $studentInformation= new RegisterStudentInformation;     
            }
            $information = array();
            foreach( $studentInformation as $student){
              $parent =RegisterParentInformation::where("id",$student->student_parent_id)->first();
              $class =RegisterClasses::where("id",$student->student_class_id)->first();
              $information['id']=$student->id;
              $information['className']=ucfirst($class->class_name);
              $information['parentNames']=ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname);
              $information['parentGender'] =$parent->parent_gender;
            }
            return  view('view-students-table',['date'=>$date,'schoolInformation'=> $schoolInformation,'studentInformation'=> $studentInformation, 'information'=> $information, 'paginator'=> $studentInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Student View Table']);
          }
          //delete student register ajax
          public function registerDeleteStudent($id){
            if(RegisterStudentInformation::where("id",$id)->exists()){
              //soft delete
              RegisterStudentInformation::where("id",$id)->update('status', 'delete');
              return response()->json(['success'=>'success','message'=>'Student with an id '.$id.' has been deleted successfully']);
            }else{
              return response()->json(['success'=>'danger','message'=>'Contact the administrator the student with an '.$id.' is not found' ]);  
            }                    
          }

          //show table register register ajax
          public function registerStudentRegisterTable(Request $request){
            if($request->teacherName =='' || $request->teacherName =='none' ){
              return response()->json(['success'=>'danger','message'=> 'Please select teacher\'s name']);
            }elseif($request->className =='' || $request->className =='none'){
              return response()->json(['success'=>'danger','message'=> 'Please select  class for all students']);                                                                 
            }elseif($request->week =='' || $request->week =='none'){
              return response()->json(['success'=>'danger','message'=> 'Please select week of the term']);                                                                 
            }

            if(RegisterStaffTeacher::where(["staff_id"=>protectData($request->teacherName),"class_id"=>protectData($request->className)])->exists()){
              $teacher = RegisterStaffTeacher::where(["staff_id"=>protectData($request->teacherName),"class_id"=>protectData($request->className)])->first();
              if($teacher->teacher_role == 'classteacher'){
                $studentInformation =RegisterStudentInformation::where(["student_class_id"=>protectData($teacher->class_id)])->where("status", "delete")->paginate(1);
                $students ='<table class=" table table-bordered  border-bottom-info" id="dataTable" width="100%" cellspacing="0">
                <tr>
                <th>S/N</th>
                  <th>Student Name</th>
                  <th>Monday</th>
                  <th>Tuesday</th>
                  <th>Wednesday</th>
                  <th>Thurday</th>
                  <th>Friday</th>
                </tr>';
                $i=1;
                foreach($studentInformation as $student){
                  $students .='<tr>
                  <td>'.$i.'</td><td>'.ucfirst($student->student_firstname).' '.ucfirst($student->student_lastname).'</td>
                  <td>
                  <label for="gender" class="checkbox-inline text-info">M</label>
                  <input type="checkbox" id="mon_mon" name="gender" >
                  <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                  <input type="checkbox" id="mon_aft" name="gender">
                  </td>
                  <td>
                    <label for="gender" class="checkbox-inline text-info">M</label>
                    <input type="checkbox" id="tue_mon" name="gender" value="male">
                    <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                    <input type="checkbox" id="tue_aft" name="gender">
                  </td>
                  <td>
                    <label for="gender" class="checkbox-inline text-info">M</label>
                    <input type="checkbox" id="wed_mon" name="gender" value="male">
                    <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                    <input type="checkbox" id="wed_aft" name="gender">
                  </td>
                  <td>
                    <label for="gender" class="checkbox-inline text-info">M</label>
                    <input type="checkbox" id="thur_mon" name="gender" value="male">
                    <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                    <input type="checkbox" id="thur_aft" name="gender">
                  </td>
                  <td>
                  <label for="gender" class="checkbox-inline text-info">M</label>
                  <input type="checkbox" id="fri_mon" name="gender" value="male">
                  <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                  <input type="checkbox" id="fri_aft" name="gender">
                  </td>';                                            
                  $students .='</tr>';
                  $i++;
                
                }
                $students .='</table>';
                return response()->json(['success'=>'success','message'=>$students, 'paginator'=>$studentInformation, 'hasPages'=>$studentInformation->hasPages(), 'currentPage'=>$studentInformation->currentPage(), 'perPage'=>$studentInformation->perPage(), 'total'=> $studentInformation->total(), 'lastPage'=>$studentInformation->lastPage()]);     
              }
              return response()->json(['success'=>'danger','message'=>'Contact the administrator no register found' ]);  
            }else{
              return response()->json(['success'=>'danger','message'=>'Contact the administrator no register found' ]);  
            }                    
       
          }          
          // show parent page
          public function registerParent(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
          
            return  view('add-parent',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Parent']);
          }          
          // create parent for register
          public function registerAddParent(Request $request){
            /*if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }*/  
            if(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterParentInformation::where("parent_email",protectData($request->email))->exists()){
              $request->session()->flash('message', 'Please register this parent with another email, '.$request->email.' is not available');
              return redirect()->route('add-parent');
            }

            $firstname=$request->input('firstname');
            $middlename=$request->input('middlename');
            $lastname=$request->input('lastname');
            $maritalStatus=$request->input('maritalStatus');
            $dob=$request->input('dob');
            $gender=$request->input('gender');
            $phone=$request->input('phone');
            $city=$request->input('city');
            $socialMedia=$request->input('socialMedia');
            $address=$request->input('address');
            $state=$request->input('state');
            $hobbies = $request->input('hobbies');
            $disabilityStatus=$request->input('disabilityStatus');
            $listDisability=$request->input('listDisability');
            $localG=protectData($request->input('localG'));

            if(($disabilityStatus =='yes')  && $listDisability ==''){
              $request->session()->flash('listDisability', 'List your Disability'); 
              return redirect()->route('add-parent');                            
            }
            $rules=array(
              'firstname'=>'required',
              'middlename'=>'required',
              'lastname'=>'required',
              'email'=>'required|email|unique:register_parent_informations,parent_email',
              'maritalStatus'=>'required',
              'disabilityStatus'=>'required',
              'dob'=>'required',
              'gender'=>'required',
              'phone'=>'required',
              'city'=>'required',
              'socialMedia'=>'required',
              'address'=>'required',
              'hobbies'=>'required',
              'state'=>'required',
              'localG'=>'required',
            );
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
              return redirect()->route('add-parent')->withErrors($validator);
            }else{ 

              $data = array();
              $image = $request->file('profileImage');
              if($image == NULL || $image =='' ){
                        $data['parent_profile_image']  = $image; 
              }else{                    
                        Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                        $data['parent_profile_image'] =$image->getFilename().'.'.$image->getClientOriginalExtension();
              }                                        
              $data['parent_firstname']= protectData($request->firstname);
              $data['parent_middlename']= protectData($request->middlename);
              $data['parent_lastname']= protectData($request->lastname);            
              $data['parent_email']= protectData($request->email);
              $data['parent_marital_status']= protectData($request->maritalStatus);
              $data['parent_gender']= protectData($request->gender);            
              $data['parent_phone']= protectData($request->phone);
              $data['parent_dob']= protectData($request->dob);
              $data['parent_disability']= protectData($request->disabilityStatus);
              $data['parent_list_disability']= protectData($request->listDisability);
              $data['parent_hobbies']= protectData($request->hobbies);
              $data['parent_address']= protectData($request->address);
              $data['parent_city']= protectData($request->city);
              $data['parent_social_media']= protectData($request->socialMedia);
              $data['parent_state']= protectData($request->state);
              $data['parent_localG']= protectData($request->localG);
              $data['corox_model_id'] = $userId;
              $data['user_corox_model_id'] = 0;
              $parentInformation= RegisterParentInformation::create($data);    
              $request->session()->flash('messageSuccess', 'Parent with email, '.$request->email.' is successfully created');                              
              return redirect()->route('add-parent');
            }
          }
          //show edit Parent here
          public function registerEditParent(Request $request, $id){
            /* if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              //return redirect('/Dregister/dashboard');
            }*/
            if(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if( $id == null || $id == '' || !is_numeric($id)){
              $request->session()->flash('message', 'You are not allowed to edit this parent');
              return redirect()->route('404'); 
            }             
            if(RegisterParentInformation::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->exists()){
              $parentInformation = RegisterParentInformation::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->first();
            }else{
              $request->session()->flash('message', 'You are not allowed to edit this parent');                               
              return redirect()->route('404');    
            }                    
            return  view('edit-parent',['date'=>$date,'schoolInformation'=> $schoolInformation, 'parentInformation'=> $parentInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Edit Parent']);
          }
          //show parents here
          public function registerViewParents(){
            if(Auth::user()->isMember()){
              $roleId =1;
              $roleInformation = Permit::where("role_id",$roleId)->first();
              $userId= $roleInformation->corox_model_id;
              $date = date('Y');
              $adminInformation = Corox_model::where("id",$userId)->first();
              $adminEmail=$adminInformation->email;
              
            }elseif(Auth::user()->isAdmin()){  
              $email= Auth::user()->email;
              $date = date('Y');
              $userId=Auth::user()->id;
              $adminEmail=Auth::user()->email;
            }
            if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
            }else{
              $schoolInformation= new RegisterSchoolInformation;     
            }
            if(RegisterParentInformation::where("corox_model_id",$userId)->exists()){
              $parentInformation = DB::table('register_parent_informations')->whereNotNull('parent_firstname')->whereNotNull('parent_lastname')->whereNotNull('parent_email')->whereNotNull('parent_gender')->whereNotNull('parent_marital_status')->whereNotNull('parent_phone')->where("status","delete")->paginate(10);    
            }else{
              $parentInformation= new RegisterParentInformation;     
            }                    
            return  view('view-parents-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'parentInformation'=> $parentInformation, 'paginator'=> $parentInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=> 'View Parents Table']);
          }
          //delete parent register ajax
          public function registerDeleteParent($id){
            if(RegisterParentInformation::where("id",$id)->exists()){
              //soft delete
              RegisterParentInformation::where("id",$id)->update('status', 'delete');
              return response()->json(['success'=>'success','message'=>'Parent with an id '.$id.' has been deleted successfully']);
            
            }else{
             return response()->json(['success'=>'danger','message'=>'Contact the administrator the parent with an '.$id.' is not found' ]);  
            }                    
       
          }
          //tracking page to post update staff detail
          public function registerUpdateParent(Request $request){
            // if(Auth::user()->isMember()){
            //  return redirect()->route('dashboard');
            // }
            if(Auth::user()->email){  
              $email= Auth::user()->email;
              $date = date('Y');
            }
            if(Corox_model::where("email",protectData($request->email))->exists()){
              $request->session()->flash('message', 'Please register this parent with another email, '.$request->email.' is not available');
              return back()->with($request->id);  
            }
            if($request->id == null || $request->id == '' || !is_numeric($request->id)){
              $request->session()->flash('message', 'You are not allowed to update this parent record');
              return redirect()->route('404'); 
            }
  
            if( RegisterParentInformation::where(['id'=>protectData($request->id)])->exists()){
              $image = $request->file('profileImage');
              $parentInformation = RegisterParentInformation::find(protectData($request->id));                              
              $FileSystem = new Filesystem();
              $directory = public_path().'/uploads/';

              if($image ==NULL || $image =='' ){
                if($parentInformation->parent_profile_image !=Null || $parentInformation->parent_profile_image !='' ){
                  
                }else{
                  $parentInformation->parent_profile_image = $image; 
                }
              }elseif($image->getFilename().'.'.$image->getClientOriginalExtension() != $parentInformation->parent_profile_image){
                if($FileSystem->exists($directory.$image->getFilename().'.'.$image->getClientOriginalExtension())){
                  unlink(public_path('uploads/'.$parentInformation->parent_profile_image));                              
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $parentInformation->parent_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                }
                //dd($image->getFilename());
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                $parentInformation->parent_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
              }else{
                if($FileSystem->exists($directory.$parentInformation->parent_profile_image)){
                  unlink(public_path('uploads/'.$parentInformation->parent_profile_image));                              
                  Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                  $parentInformation->parent_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
                }
                Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
                $parentInformation->parent_profile_image=$image->getFilename().'.'.$image->getClientOriginalExtension();                              
              }
              $firstname=$request->input('firstname');
              $middlename=$request->input('middlename');
              $lastname=$request->input('lastname');
              $maritalStatus=$request->input('maritalStatus');
              $dob=$request->input('dob');
              $gender=$request->input('gender');
              $phone=$request->input('phone');
              $city=$request->input('city');
              $socialMedia=$request->input('socialMedia');
              $address=$request->input('address');
              $state=$request->input('state');
              $hobbies = $request->input('hobbies');
              $disabilityStatus=$request->input('disabilityStatus');
              $listDisability=$request->input('listDisability');
              $localG=protectData($request->input('localG'));
              if($disabilityStatus =='yes'  && $listDisability ==''){
                $request->session()->flash('listDisability', 'List your Disability'); 
                return redirect()->route('edit-staff',['id' => $request->id]);                        
              }           
              $rules=array(
                'firstname'=>'required',
                'middlename'=>'required',
                'lastname'=>'required',
                'maritalStatus'=>'required',
                'disabilityStatus'=>'required',
                'dob'=>'required',
                'gender'=>'required',
                'phone'=>'required',
                'city'=>'required',
                'socialMedia'=>'required',
                'address'=>'required',
                'hobbies'=>'required',
                'state'=>'required',
                'localG'=>'required',
              );
              $validator= Validator::make($request->all(),$rules);
              if($validator->fails()){ 
                //return redirect()->route('edit-staff', ['id' => $id])->withErrors($validator);
                return redirect()->route('edit-parent',['id' => $request->id])->withErrors($validator);     
              }else{                                                                   
                $parentInformation->parent_firstname= protectData($request->firstname);
                $parentInformation->parent_middlename= protectData($request->middlename);
                $parentInformation->parent_lastname= protectData($request->lastname);            
                $parentInformation->parent_email= protectData($request->email);
                $parentInformation->parent_marital_status= protectData($request->maritalStatus);
                $parentInformation->parent_gender= protectData($request->gender);            
                $parentInformation->parent_phone= protectData($request->phone);
                $parentInformation->parent_dob= protectData($request->dob);
                $parentInformation->parent_disability= protectData($request->disabilityStatus);
                $parentInformation->parent_list_disability= protectData($request->listDisability);
                $parentInformation->parent_hobbies= protectData($request->hobbies);
                $parentInformation->parent_address= protectData($request->address);
                $parentInformation->parent_city= protectData($request->city);
                $parentInformation->parent_social_media= protectData($request->socialMedia);
                $parentInformation->parent_state= protectData($request->state);
                $parentInformation->parent_localG= protectData($request->localG);
                if($parentInformation->save()){
                  $request->session()->flash('messageSuccess', 'Parent with email, '.$request->email.' is successfully updated');                                                           
                }else{
                  $request->session()->flash('message', 'Parent with email, '.$request->email.' is not successfully updated');                       
                }
                return back()->with($request->id); 
              }                          
            }else{
              $request->session()->flash('message', 'You are not allowed to update this Parent record');
              return back()->with($request->id); 
            }
                    
          }          
          //error page here
          public  function registerError404(){                  
            return view('404');
          }      
          //sending mail
          public  function mailOut($id){
            $user=Corox_model::find($id)->toArray();
            $mail=  Mail::send('emails', $user, function($message) use ($user){
              $message->to($user['email']);
              $message->subject('Our Service');
            });
            if($mail){
              $dd('Mail sent successfully');
            }else{
              $dd('Mail not delivered');
            }
         }          
          //logout here
          public  function logout(){
            Auth::logout();
            Session::flush();
            return redirect()->route('login');;
          }

          public function store(Request $request, OrderDetails $order, Paymentgateway $payment){
            if($request->has('credit')){
               echo "credit";
            }else{
              $order = $order->all();
              dd($payment->charge(200));
            }
          }
}
