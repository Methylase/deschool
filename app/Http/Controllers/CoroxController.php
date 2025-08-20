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
use Deschool\Models\RegisterTeacherSubject;
use Deschool\Models\RegisterStudentSubject;
use Deschool\Models\RegisterStationeries;
use Deschool\Models\RegisterAssignBook;
use Deschool\Models\RegisterAcademicSession;
use Deschool\Models\RegisterResultEstimator;
use Deschool\Models\RegisterSalesRecord;
use Deschool\Models\RegisterClassRegisterStatus;
use Deschool\Models\RegisterStudentClassStatus;
use Deschool\Models\RegisterResultAggregator;
use Deschool\Models\Role;
use Deschool\Models\RegisterTransaction;
use Deschool\Models\Permit;
use Deschool\Models\Blog;
use Deschool\Models\Comment;
use Deschool\Models\Booked;

use Validator;
class CoroxController extends Controller {

  public function __construct(){
    $this->middleware('preventBackHistory');
  }


  //show landing page
  public function index(){
    $blogs = Blog::query()->paginate('10');
    $classes = RegisterClasses::get();
    return view('app.index',['title'=>'Home', 'blogs' => $blogs, 'classes' => $classes]);
    
  }

  //showing testimony
  public function testimony(){
    return view('app.testimony',['title'=>'Testimony']);
    
  }

  //showing about us
  public function aboutUs(){
    return view('app.about-us',['title'=>'About Us']);
    
  }

  //showing privacy policy
  public function privacyPolicy(){
    return view('app.privacy-policy',['title'=>'Privacy Policy']);
    
  }

  //showing vision
  public function vision(){
    return view('app.vision',['title'=>'Vision']);
    
  }

    //showing mission
  public function mission(){
    return view('app.mission',['title'=>'Mission']);
    
  }

    //submit booked class
  public function booked(Request $request){

      if($_SERVER['REQUEST_METHOD'] =='POST'){
        
        $data = array();
      
        $name = $request->input('name');
        $email = $request->input('email');
        $class = $request->input('class');
        $rules=array(
          'name' => 'required',
          'email' => 'required|max:255',
          'class' => 'required'
        );


        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
          return redirect()->route('home')->withErrors($validator);
        }else{


            $data['name'] = protectData($name);
            $data['email'] = protectData($email);
            $data['class_id'] = protectData($class);
            
            $contact= Booked::create($data);

            if($contact){
              $request->session()->flash('successMessage', 'Seat successfully booked');
            }else{
              $request->session()->flash('errorMessage', 'Oop something went wrong'); 
            }

            return redirect()->route('home');

        }          

      }
      
  } 
  
  //showing contact us
  public function contactUs(Request $request){

      if($_SERVER['REQUEST_METHOD'] =='POST'){
        
        $data = array();
      
        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');
        $rules=array(
          'name' => 'required',
          'email' => 'required|max:255',
          'subject' => 'required',
          'message' => 'required'
        );


        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
          return redirect()->route('contact')->withErrors($validator);
        }else{


            $data['name'] = protectData($name);
            $data['email'] = protectData($email);
            $data['subject'] = protectData($subject);
            $data['message'] = protectData($message);
            
            $contact= Contact::create($data);

            if($contact){
              $request->session()->flash('successMessage', 'Feedback successfully submitted');
            }else{
              $request->session()->flash('errorMessage', 'Oop something went wrong'); 
            }

            return redirect()->route('contact');

        }          

      }else{
          return view('app.contact-us',['title' => 'Contact Us']);
      }
      
  } 

    //submit newsletter
  public function newsletter(Request $request){

      if($_SERVER['REQUEST_METHOD'] =='POST'){
        
        $data = array();
      
        $name = $request->input('name');
        $email = $request->input('email');
        $rules=array(
          'name' => 'required',
          'email' => 'required|max:255'
        );


        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
          return redirect()->route('home')->withErrors($validator);
        }else{


            $data['name'] = protectData($name);
            $data['email'] = protectData($email);
            
            $contact= Newsletter::create($data);

            if($contact){
              $request->session()->flash('successMessage', 'Successfully subscribed to our newsletter');
            }else{
              $request->session()->flash('errorMessage', 'Oop something went wrong'); 
            }

            return redirect()->route('contact');

        }          

      }
      
  } 
  //showing blog
  public function blog(){

    $blogs = Blog::query()->paginate('10');
    return view('app.blog',['title' => 'Blog', 'blogs' => $blogs]);
    
  }

    //showing blog post
  public function blogPost(Request $request){
    $id = $request->id;
    $blog = Blog::findOrFail(protectData($id));

    return view('app.blog-post',['title' => 'Blog Post', 'blog' =>$blog]);
    
  }


    //create new blog post
    public function registerBlogPost(Request $request)
    {

      $userId = Auth::user()->id;
      $adminEmail = Auth::user()->email;
      $date = date('Y');
      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();

      }else{
        $schoolInformation= new RegisterSchoolInformation;
      } 
           
      if($_SERVER['REQUEST_METHOD'] =='POST'){
        $rules=array(
            'image' => 'required',
            'type' => 'required',
            'title' => 'required|max:255',
            'description' => 'required',
        );

        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){

          return redirect()->route('post')->withErrors($validator);
        }else{  
            $image = $request->file('image');
            $blog = Blog::create([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $image->getFilename().'.'.$image->getClientOriginalExtension(),
                'user_id' => $userId,
            ]);
        
            $FileSystem = new Filesystem();
            $directory_images = public_path().'/blog_images/'.$blog->id.'/';
            
            if(in_array($image->getClientOriginalExtension(),array('png','jpg','jpeg'))){
                $image->move($directory_images,$image->getFilename().'.'.$image->getClientOriginalExtension());
                
            }else{
                $request->session()->flash('image_error', 'Upload the right image format');
                return redirect()->route('post');
            }


            return redirect()->route('post')->with('successMessage', 'Blog post created successfully.');
        }
      }else{


        return view('admin.blog-post',['date'=>$date,'schoolInformation'=>$schoolInformation,'userEmail'=>$adminEmail, 'userId'=>$userId,  'title'=>' New Blog Post']);
      }

    }


  //List all blog post
  public function registerPosts(){

    $userId = Auth::user()->id;
    $adminEmail = Auth::user()->email;
    $date = date('Y');
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();

    }else{
      $schoolInformation= new RegisterSchoolInformation;
    }
    $blogs = Blog::where(['user_id'=>$userId])->paginate(10);

    return view('admin.list-blog-post',['date'=>$date,'schoolInformation'=>$schoolInformation,'blogs'=>$blogs,'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'List Blog Post']);

  }

    public function registerComment(Request $request, Blog $blog)
  {
    $rules=array(
        'name' => 'required|max:255',
        'email' => 'required',
        'message' => 'required',
        'parent_id' => 'nullable|exists:comments,id',
    );

    $validator= Validator::make($request->all(),$rules);
    if($validator->fails()){
        return redirect()->route('blog-post',$request->blog_id)->withErrors($validator);
    }else{ 
      $comment = new Comment;
      $comment->name = $request->name;
      $comment->email = $request->email;
      $comment->content = $request->message;
      $comment->blog_id = $request->blog_id;
      $comment->save();

      return redirect()->back()->with('success', 'Comment added!');
    }
  }


  //edit blog post
  public function registerEditBlogPost(Blog $blog){

    $userId = Auth::user()->id;
    $adminEmail = Auth::user()->email;
    $date = date('Y');
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();

    }else{
      $schoolInformation= new RegisterSchoolInformation;
    }
    
    $blog = Blog::where(["id"=>protectData($blog->id)])->first(); 

    return view('admin.edit-blog-post',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'blog'=>$blog, 'title'=>'Edit Blog Post']);

  }  

  //update blog post
  public function registerUpdateBlogPost(Request $request){
            
    if($request->id == null || $request->id == '' || !is_numeric($request->id)){
      $request->session()->flash('message', 'You are not allowed to update this blog');
      return redirect()->route('404'); 
    }

    if( Blog::where(['id'=>protectData($request->id)])->exists()){
      $image = $request->file('image');
      $title = $request->input('title');
      $type = $request->input('type');
      $description = $request->input('description');
        $rules=array(
          'type' => 'required',
          'title' => 'required',
          'description' => 'required'
        );
        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
           return redirect()->route('edit-blog-post',['blog' => $request->id])->withErrors($validator);
        }else{  

        $blog = Blog::find(protectData($request->id));

                     
        $FileSystem = new Filesystem();
        $directory = public_path().'/blog_images/';
        if($image ==NULL || $image =='' ){
          
          if($blog->image !=Null || $blog->image !='' ){
            
          }else{
            $blog->image = $image->getFilename().'.'.$image->getClientOriginalExtension();  
          }
        
        }elseif($image->getFilename().'.'.$image->getClientOriginalExtension() != $blog->image){
          if(file_exists($directory.$blog->id.'/'.$image->getFilename().'.'.$image->getClientOriginalExtension())){
            unlink($directory.$blog->id.'/'.$blog->image);                                
            $image->move($directory.$blog->id,$image->getFilename().'.'.$image->getClientOriginalExtension());
            $blog->image=$image->getFilename().'.'.$image->getClientOriginalExtension();                                          
          }else{

            unlink($directory.$blog->id.'/'.$blog->image);                                
            $image->move($directory.$blog->id,$image->getFilename().'.'.$image->getClientOriginalExtension());
            $blog->image=$image->getFilename().'.'.$image->getClientOriginalExtension();   
          }
                              
        }
                                     
        $blog->type= protectData($type);
        $blog->title= protectData($title);
        $blog->description= protectData($description);            
        
        if($blog->save()){
          $request->session()->flash('successMessage', 'Blog post is successfully updated');                                                           
        }else{
          $request->session()->flash('errorMessage', 'Blog post is not successfully updated');                       
        }
        return back()->with($request->id);  
      }                         
    }else{
      $request->session()->flash('errorMessage', 'You are not allowed to update this blog post');
      return back()->with($request->id); 
    }
            
  }

    // delete blog post here
  public function registerDeleteBlogPost(Blog $blog){
    Blog::where("id",$blog->id)->update(['status' => 'delete']);
    return response()->json(['success'=>'success','message'=>'blog with an '.$blog->id.' has been deleted successfully']);
  }    
  

  //show login here
  public function login(){
    return view('app.login',['title'=>'Login']);
    
  }

  // show info settings page
  public function registerInfoSettings(){

    if(Auth::user()->isAdmin()){  
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
    
    
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

      return view('admin.settings-information',['date'=>$date, 'schoolInformation'=> $schoolInformation, 'numberOfStaffs'=> $numberOfStaffs, 'userId'=>$userId, 'userEmail'=>$adminEmail, 'services'=>$services, 'schoolServices'=>$schoolServices, 'title'=>'Information Update']);
    }
  }
  
  //get memo page
  public function getSendMemo(){
    if(Auth::user()->isAdmin()){
      $userId= Auth::user()->id;
      $date = date('Y');
      $adminEmail=Auth::user()->email;
    }elseif(Auth::user()->isMember()){  
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
                        
    return view('admin.memo',['date'=>$date,'schoolInformation'=> $schoolInformation, 'staffInformation'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Send Memo']);       
  }

  public function postSendMemo(Request $request){
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php'; 
    if(Auth::user()->isAdmin()){
      $userId= Auth::user()->id;
    }elseif(Auth::user()->isMember()){  
      $userId=Auth::user()->id;
    }            
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    } 

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
          $mail->Username = "";
          $mail->Password = "";                               //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
          //Recipients
          $mail->setFrom($request->sender, 'Memo From '.$schoolInformation->school_name);
          foreach($request->email as $email){
             $mail->addAddress($email);     //Add a recipient    
             $mail->addEmbeddedImage(public_path().'/my-register/img/school.jpeg','cover');
            //Content
            $body = '<html><body><h2 style="color:white;font-size:14px;">Hello, '.$email.'</h2>';
            $body .= '<p><img src="cid:cover" alt="'.$schoolInformation->school_name.'" /></p>';
            $body .= '<table rules="all" style="border-color: #666; color:white:background-color:#5be9ff" cellpadding="10">';
            $body .= '<div style="background-color:#5be9ff;padding:30px;color:white"><p>'.$request->message.'</p><br<p>Thank you to all the staff who received this mail, kindly comply</p></div>';
            $body .= "</table>";
            $body .= "</body></html>";

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $request->subject;
            $mail->Body  = $body;
            $mail->send();
            $data['sender_email'] =protectData($request->sender); 
            $data['subject'] =protectData($request->subject);                    
            $data['message'] =protectData($request->message);
            $data['receiver_email'] =$email;
            $data['corox_model_id'] =protectData($userId);
            $memo= Memo::create($data);                            
          }  
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
        //Storage::disk('public')->put($image->getFilename().'.'.$image->getClientOriginalExtension(), File::get($image));
        $directory = public_path().'/uploads/';
        $image->move($directory,$image->getFilename().'.'.$image->getClientOriginalExtension());
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
            return view('app.signup',['title'=>'Signup']);
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
 
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
              $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
              $services = array();
              $schoolServices = array();
              $schoolInformation= new RegisterSchoolInformation;     
    } 
    
    if(RegisterStationeries::where("corox_model_id",$userId)->exists()){              
      $stationeries =  RegisterStationeries::where("corox_model_id",$userId)->get();  
    }else{
      $stationeries = new RegisterStationeries;      
    }

    if(RegisterTransaction::where("corox_model_id",$userId)->exists()){
      $payments = array();
      $payment_results = RegisterTransaction::where("corox_model_id",$userId)->get();
      foreach($payment_results as $payment_result){
        $class = RegisterClasses::where("id",$payment_result->class_id)->first();
        $student = RegisterStudentInformation::where("id",$payment_result->student_id)->first();
        $payments[] = array('class_name'=>$class->class_name, 'student_name'=>$student->student_firstname.' '.$student->student_lastname, 'amount'=>$payment_result->amount, 'term'=>$payment_result->term, 'year'=>$payment_result->year, 'transaction_type'=>$payment_result->transaction_type, 'time'=>$payment_result->transaction_time, 'date'=>$payment_result->transaction_date);
      }
    }else{
      $payments='';
    }

    if(RegisterAssignBook::where("corox_model_id",$userId)->exists()){               
      $assignedBooks = array();
      $books = RegisterAssignBook::where(array("corox_model_id"=>$userId))->get();
      foreach($books as $book){
        $stationary_result = RegisterStationeries::where(array("id" => $book->book_id, "stationary_status"=>"library"))->first();
        $student = RegisterStudentInformation::where("id", $book->student_id)->first();
        $class = RegisterClasses::where("id", $book->class_id)->first();
        $assignedBooks[] = array("id"=>$book->id, "fullname"=>$student->student_firstname." ".$student->student_lastname, "book"=>$stationary_result->stationary_name, "class_name"=>$class->class_name, "condition"=>$book->book_condition, "status"=>$book->book_status, "time_assigned"=>$book->assign_time, "time_returned"=>$book->return_time, "date"=>$book->assign_date);         
      }
        
    }else{
      $assignedBooks= "";     
      
    }
    $staff_count = RegisterStaffInformation::count();
    $teacher_count = RegisterStaffTeacher::count();
    $parent_count = RegisterParentInformation::count();
    $student_count = RegisterStudentInformation::count();

    return view('admin.dashboard',['userEmail'=>$adminEmail, 'date'=>$date, 'staff_count' => $staff_count,'teacher_count' => $teacher_count, 'parent_count' => $parent_count, 'student_count' => $student_count, 'payments' =>$payments, 'stationeries' => $stationeries, 'assignedBooks' =>$assignedBooks,  'schoolInformation'=> $schoolInformation, 'title'=>'Dashboard']);
  }


  public function get_pie_chart(){
    $pie_chart_data = [
        'stationeries' => RegisterStationeries::where(array('stationary_status'=>'for-sale'))->sum('stationary_amount'),
        'school_fees' => RegisterTransaction::where('transaction_type', 'schoolfees')->sum('amount'),
        'party_excursion' => RegisterTransaction::where('transaction_type', 'schoolparty')->sum('amount'),
    ];

    echo json_encode($pie_chart_data);
  }


  public function getChartData() {

        $transactions = DB::table('register_transaction')
            ->select(DB::raw("
                MONTHNAME(transaction_date) as month,
                SUM(CASE WHEN transaction_type = 'schoolfees' THEN amount ELSE 0 END) as school_fees,
                SUM(CASE WHEN transaction_type = 'schoolparty' THEN amount ELSE 0 END) as party_excursion
            "))
            ->groupBy(DB::raw("MONTH(transaction_date), MONTHNAME(transaction_date)"))
            ->get();  

            
        $stationaries = DB::table('register_stationeries')
            ->select(DB::raw("
              MONTHNAME(stationary_date) as month,
              SUM(stationary_amount) as stationaries
            "))
            ->groupBy(DB::raw("MONTH(stationary_date), MONTHNAME(stationary_date)"))
            ->get();   
            
        $monthlyData = [];

        // Add transactions data
        foreach ($transactions as $row) {
            $monthlyData[] = [
                'month' => $row->month,
                'school_fees' => $row->school_fees,
                'party_excursion' => $row->party_excursion,
                'stationaries' => 0
            ];
        }
         

        // Add stationaries data
        foreach ($stationaries as $row) {
            if (!isset($monthlyData[$row->month])) {
                $monthlyData[] = [
                    'month' => $row->month,
                    'school_fees' => 0,
                    'party_excursion' => 0,
                    'stationaries' => $row->stationaries
                ];
            } else {
            
                $monthlyData[]['stationaries'] = $row->stationaries;
            }
        }            
        

      echo json_encode($monthlyData);
    
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
    if(Auth::user()->isAdmin()){
      $userId= Auth::user()->id;
      $date = date('Y');
      $adminEmail=Auth::user()->email;
    }elseif(Auth::user()->isMember()){  
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
    }                  

    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    }                    
    return view('admin.profile',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Profile']);
  }                    
  //tracking page to show add staff page
  public function registerStaff(Request $request){
    if(Auth::user()->isAdmin()){
      $userId= Auth::user()->id;
      $date = date('Y');
      $adminEmail=Auth::user()->email;
    }elseif(Auth::user()->isMember()){  
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
    }

    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
     $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{

     $schoolInformation= new RegisterSchoolInformation;     
    }
    return view('admin.add-staff',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Staff']);
  }          
  //tracking page to post create staff details
  public function registerAddStaff(Request $request){

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
    if(Auth::user()->isAdmin()){
      $userId= Auth::user()->id;
      $date = date('Y');
      $adminEmail=Auth::user()->email;
    }elseif(Auth::user()->isMember()){  
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
    return view('admin.settings-privilege',['date'=>$date,'schoolInformation'=> $schoolInformation, 'allSchoolInformation'=> $allSchoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=> $staffInformation, 'staffPrivilegeInformation'=> $staffPrivilegeInformation, 'roleIdSInformation'=>$roleIdSInformation, 'paginator'=> $staffPrivilegeInformation, 'userId'=>$userId, 'title'=>'Setting Privilege']);
    
  }
  
  public function registerPrivilege(Request $request){
    $userId= Auth::user()->id;
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
            $remove = Permit::where("corox_model_id",$reg_id->id)->update(['status' => 'delete']);
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

  public function registerAcademicSession(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      $term = protectData($request->input('term'));
      $session = protectData($request->input('session'));
      $term_name = protectData($request->input('term_name'));

      if($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term for the '.$session]);            
      }elseif($request->input('session') ==''){
        return response()->json(['session'=>'danger','message'=>'Academic session is required']);
      }else{

        $check_academic_session= RegisterAcademicSession::where(array('term'=>$term, 'session'=>$session))->first();
        if($check_academic_session){
          
          return response()->json(['failure'=>'danger','message'=> ucfirst($term_name).' of the '.$session.' academic session has already been created']);
        }else{
              
          $check_academic_session= new RegisterAcademicSession;
          $check_academic_session->term=$term;
          $check_academic_session->corox_model_id = $userId;
          $check_academic_session->session= $session;
          if($check_academic_session->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully created '.$term_name.' for '.$session.' academic session']);      
          }else{
            return response()->json(['failure'=>'danger','message'=> $term_name.' for the '.$session.' academic session is not created, contact the administrator']);     
          }                                                
        }
      } 
    }else{
      return redirect()->route('setting-privilege');
    }
    
  }

  public function registerPrivilegeEnableSettings(Request $request){

    $userId=Auth::user()->id;
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

    $userId= Auth::user()->id;
    $date = date('Y');
    $adminEmail=Auth::user()->email;

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
    return  view('admin.view-staffs-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'staffInformation'=> $staffInformation, 'paginator'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'View Staff Table']);
  }
  public function registerViewStaff($id){

    $userId= Auth::user()->id;
    $date = date('Y');
    $adminEmail=Auth::user()->email;
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    }
    $staffInformation = DB::table('register_staff_informations')->where('id', $id)->get();           
    return  view('admin.view-staffs-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'staffInformation'=> $staffInformation, 'paginator'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId]);
  }          
  //show general page here
  public function registerClassSetup(){
 
    $email= Auth::user()->email;
    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    }
    return view('admin.class-setup',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Class Setup']);
  } 

  //show edit staff here
  public function registerEditStaff(Request $request, $id){ 

    
    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
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
    
                   
    return  view('admin.edit-staff',['date'=>$date,'schoolInformation'=> $schoolInformation, 'staffInformation'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Eidt Staff']);
  }
  //show delete staff here
  public function registerDeleteStaff($id){
 
    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
    if($id == null || $id == '' || is_nan($id)){
      return response()->json(['success'=>'fail','message'=>'You are not allowed to delete this staff']);                   
    }
    if(RegisterStaffInformation::where("id",protectData($id))->exists()){
      $staffInformation = RegisterStaffInformation::where("id",protectData($id))->first();
      if(Corox_model::where("id",$staffInformation->user_corox_model_id)->exists()){
        if(Corox_model::where("id",$staffInformation->user_corox_model_id)->update(['status' => 'delete'])){
          if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->exists()){
            if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->update("status", "delete")){
              if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
                  if(RegisterStaffTeacher::where("staff_id",protectData($id))->update(['status' => 'delete'])){
                    if(RegisterStaffInformation::where("id",protectData($id))->update(['status' => 'delete'])){
                      return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                    }
                  }                                
              }else{
                //soft delete
                if(RegisterStaffInformation::where(protectData($id))->update(['status' => 'delete'])){
                  return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                }                                                                      
              }
            }                                                               
          }else{
            if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
              
              if(RegisterStaffTeacher::where("staff_id",protectData($id))->update(['status' => 'delete'])){
                if(RegisterStaffInformation::where(protectData($id))->update(['status' => 'delete'])){
                  return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                }
              }                                
            }else{
              if(RegisterStaffInformation::where(protectData($id))->update(['status' => 'delete'])){
                return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
              }                                                                      
            }                                                            
          }
        }                                                  
      }else{
        if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->exists()){
          if(Permit::where("corox_model_id",$staffInformation->user_corox_model_id)->update(['status' => 'delete'])){
            if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
              if(RegisterStaffTeacher::where("staff_id",protectData($id))->update(['status' => 'delete'])){
                if(RegisterStaffInformation::where("id",protectData($id))->update(['status' => 'delete'])){
                  return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
                }
              }                                
            }else{
              if(RegisterStaffInformation::where("id",protectData($id))->update(['status' => 'delete'])){
                return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
              }                                                                      
            }
          }                                                               
        }else{
          if(RegisterStaffTeacher::where("staff_id",protectData($id))->exists()){
            if(RegisterStaffTeacher::where("staff_id",protectData($id))->update(['status' => 'delete'])){
              if(RegisterStaffInformation::where("id",protectData($id))->update(['status' => 'delete'])){
                return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
              }
            }                                
          }else{
            if(RegisterStaffInformation::where("id",protectData($id))->update(['status' => 'delete'])){
              return response()->json(['success'=>'success','message'=>'Staff with an '.$id.' has been deleted successfully']);
            }                                                                      
          }                                                            
        }                                                  
      }                                             
    }else{
      return response()->json(['success'=>'danger','message'=> 'No current staff record']);                                   
    } 

  }
  //create class for register ajax
  public function registerAddClass(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class') == ''){
        return response()->json(['class'=>'danger','message'=>'Class name is required']);
      }elseif($request->input('date') ==''){
        return response()->json(['date'=>'danger','message'=>'Date created is required']);
      }else{
        $class = protectData($request->input('class'));
        $date = protectData($request->input('date'));
        $userCheck= RegisterClasses::where('class_name',$class)->first();
        if($userCheck){
          return response()->json(['failure'=>'danger','message'=> ucfirst($class).' has already been created']);
        }else{
          $class_result= new RegisterClasses;
          $class_result->class_name=$class;
          $class_result->corox_model_id = $userId;
          $class_result->class_date= $date;
          if($class_result->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully created '.$request->class.' class']);      
          }else{
            return response()->json(['failure'=>'danger','message'=> $request->class.' class not created, contact the administrator']);     
          }                                                
        }
      } 
    }else{
      return redirect()->route('class-setup');
    }           
  }
  // create subject for register ajax
  public function registerAddSubject(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('subject') ==''){
        return response()->json(['subject'=>'danger','message'=>'Subject name is required']);
      }elseif($request->input('date') ==''){
        return response()->json(['date'=>'danger','message'=>'Date created is required']);
      }else{
        $subject = protectData($request->input('subject'));
        $date = protectData($request->input('date'));
        $userCheck= RegisterSubject::where('subject_name',$subject)->first();
        if($userCheck){
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
    }else{
      return redirect()->route('class-setup');
    }
  }
  // create period for register ajax
  public function registerAddPeriod(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('period') == ''){
        return response()->json(['period'=>'danger','message'=>'Period name is required']);
      }elseif($request->input('date') ==''){
        return response()->json(['date'=>'danger','message'=>'Date created is required']);
      }else{
        $period = protectData($request->input('period'));
        $date = protectData($request->input('date'));
        $userCheck= RegisterPeriod::where('period_name',$period)->first();
        if($userCheck){
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
    }else{
      return redirect()->route('class-setup');
    }
  }
  // show page to assign subject
  public function registerAssignSubject(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('teacher') == ''){
        return response()->json(['teacher'=>'danger','message'=>'Select teacher\'s name']);
      }elseif($request->input('subject') ==''){
        return response()->json(['subject'=>'danger','message'=>'Select subject']);
      }else{
        $teacher = protectData($request->input('teacher'));
        $subject= protectData($request->input('subject'));
        $teacher_name = protectData($request->input('teacher_name'));
        $subject_name= protectData($request->input('subject_name'));
        $teacher_subject= RegisterTeacherSubject::where(array('teacher_id'=>$teacher, 'subject_id'=> $subject ))->first();
        if($teacher_subject){
          return response()->json(['failure'=>'danger','message'=> $subject_name.' subject has already been assigned to '.ucfirst($teacher_name)]);     
        }else{
          $teacher_subject= new RegisterTeacherSubject;
          $teacher_subject->teacher_id=$teacher;
          $teacher_subject->corox_model_id = $userId;
          $teacher_subject->subject_id= $subject;
          if($teacher_subject->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully assigned '.$subject_name.' subject to '.ucfirst($teacher_name)]);      
          }else{
            return response()->json(['failure'=>'danger','message'=> $subject_name.' subject is not successfully assigned to '.ucfirst($teacher_name)]);     
          }  
        }                                              
      }
    }else{

      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;

      if(RegisterStaffTeacher::where("corox_model_id",$userId)->exists()){               
         
          $teachers = RegisterStaffTeacher::where(array("corox_model_id"=>$userId, 'teacher_role'=>'subjectteacher'))->get();
          if($teachers){
            $teacher_result = array();
            $teacherResult = array();
            foreach($teachers as $teacher){
              if(isset($teacherResult['id']) && $teacherResult['id'] == $teacher->staff_id && in_array($teacherResult['id'], $teacherResult)){
                $teacherResult = RegisterStaffInformation::where("id", $teacher->staff_id)->first();
                $teacher_result[]= array("id"=>$teacherResult->id, "fullname"=>$teacherResult->staff_firstname." ".$teacherResult->staff_lastname);    
              }else{
                $teacherResult['id'] =$teacher->staff_id;

              }
            }
          }else{
            $teacher_result = "";
          }

          $subjects = RegisterSubject::where("corox_model_id",$userId)->get();

          if($subjects){
           
            $subjects = RegisterSubject::where("corox_model_id",$userId)->get();
          }else{
            $subjects = "";
          }

          $assign_subjects = RegisterTeacherSubject::where(array("corox_model_id"=>$userId))->get();
          if($assign_subjects){
            $teacher_subjects = array();
            foreach($assign_subjects as $assign_subject){
              $teacher = RegisterStaffInformation::where("id", $assign_subject->teacher_id)->first();
              $subject = RegisterSubject::where("id", $assign_subject->subject_id)->first();
              $teacher_subjects[] = array("id"=>$assign_subject->id, "fullname"=>$teacher->staff_firstname." ".$teacher->staff_lastname, "subject"=>$subject->subject_name);         
            }
            
          }else{
            $assign_subjects = "";
          }   
          
      }else{
        $teachers= "";     
        
      }

      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }

      
      return  view('admin.assign-subject',['date'=>$date,'schoolInformation'=> $schoolInformation, "teacher_result"=>$teacher_result, "assignSubjects"=>$teacher_subjects,  "subjects"=>$subjects, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Subject']);
    }
  }
  // show page to assign teacher
  public function registerTeacher(){

    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
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
    
    return  view('admin.add-teacher',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=>$staffInformation, 'classes'=>$classes, 'staffs' =>$staffs, 'teacherInformation'=>$teacherInformation, 'paginator'=>$informations, 'classes'=>$classes, 'userId'=>$userId,'teacher', 'title'=>'Add Teacher']);
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

    $userId=Auth::user()->id;
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
      RegisterStaffTeacher::where("staff_id",$id)->update(['status' => 'delete']);
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
    if($checkRole){
      $class = RegisterClasses::where(["id"=>$request->classId])->first();
      return response()->json(['success'=>'success','message'=>'Teacher with a name '.$request->staffName.' has been successfully updated with role '.$request->teacherRole.' to '.$class->class_name.' class']);
    }else{
      $class = RegisterClasses::where(["id"=>$request->classId])->first();  
      return response()->json(['failure'=>'danger','message'=>'Teacher with a name '.$request->staffName.' and assigned role '.$request->teacherRole.' to a class '.$class->class_name.' is not successfully updated']);
    }       
  }
   // show page show staff register list for clock in
  public function registerStaffRegister(){
 
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
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
    
    return  view('admin.staff-register',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'staffInformation'=>$staffInformation, 'registerStaffInformation'=>$registerStaffInformation, 'paginator'=>$registerInformations,'userId'=>$userId, 'title'=>'Staff Register']);
  }
   // show page to for staff register list for clock in
  public function registerStaffTimeRegister(Request $request){

    $userId= $roleInformation->corox_model_id;
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
    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
    
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
    
    if(RegisterStudentRegister::where("corox_model_id",$userId)->orderBy("register_date",'DESC')->exists()){
      $registerInformations =RegisterStudentRegister::where("corox_model_id",$userId)->paginate(10);
        $registerStudentInformation = array();
      foreach($registerInformations as $registerStudent){
        $information =RegisterStudentInformation::where("id",$registerStudent->student_id)->first();
        $class =RegisterClasses::where("id",$registerStudent->class_id)->first();
        $registerStudentInformation[]=array('id'=>$information->id, 'studentName'=>ucfirst($information->student_firstname).' '.ucfirst($information->student_lastname), 'registerDate'=>$registerStudent->register_date, 'registerTime'=>$registerStudent->register_time, 'class'=>$class->class_name, 'resumptionStatus'=>$registerStudent->register_resumption_status);  
      }
              
    }else{
      $registerStudentInformation= new RegisterStudentInformation;         
    }
  
    return  view('admin.students-register',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'studentInformation'=>$studentInformation, 'registerStudentInformation'=>$registerStudentInformation, 'paginator'=>$registerInformations,'userId'=>$userId, 'title'=>'Student Register']);
  }  
  
   //ajax for student register clock in
   public function registerStudentTimeRegister(Request $request){
    $userId= Auth::user()->id;
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
    $student= RegisterStudentClassStatus::where("student_id",$studentId)->where("status","present")->first();
    $class= RegisterClasses::where("id",$student->class_id)->first();
    $studentRegister= new RegisterStudentRegister;
    $studentRegister->student_id=protectData($studentId);
    $studentRegister->class_id=protectData($class->id);
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
    $userId= Auth::user()->id;
    $date = date('Y');
    $adminEmail=Auth::user()->email;
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
    return  view('admin.add-student',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'parents'=>$parents, 'classes'=>$classes,  'userId'=>$userId, 'title'=>'Add Student']);
  }

  //tracking page to post create student details
  public function registerAddStudent(Request $request){

    $userId=Auth::user()->id;
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
      $student_class = new RegisterStudentClassStatus;
      $student_class->student_id = $schoolInformation->id;
      $student_class->class_id = protectData($request->className);
      $student_class->status = "present";
      $student_class->corox_model_id = $userId;
      $student_class->year = date('Y').'-'.(date('Y')+1);
      $student_class->date = date("Y-m-d");
       
      $request->session()->flash('messageSuccess', 'Student with email, '.$request->email.' is successfully created');                              
      return redirect()->route('add-student');
    }
  }
  //show edit Parent here
  public function registerEditStudent(Request $request, $id){

    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
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
    return  view('admin.edit-student',['date'=>$date,'schoolInformation'=> $schoolInformation, 'studentInformation'=> $student, 'information'=> $information, 'parents'=> $parentInformation, 'classes'=> $classes, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Edit Student']);
  }
  //tracking page to post update staff detail
  public function registerUpdateStudent(Request $request){

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

    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    }
    if(RegisterStudentClassStatus::where("corox_model_id",$userId)->exists()){
      $studentInformation = array();
      $students= RegisterStudentClassStatus::where("corox_model_id",$userId)->where("status","present")->get();
      foreach($students as $student){
        $student_result= RegisterStudentInformation::where("id",$student->student_id)->get();
        foreach($student_result as $result){
          $studentInformation[] = array('id'=>$student->student_id, 'student_class_id'=>$student->class_id, 'student_firstname'=>$result->student_firstname,'student_lastname'=>$result->student_lastname, 'student_email'=>$result->student_email, 'student_gender'=>$result->student_gender, 'student_phone'=>$result->student_phone, 'student_parent_id'=>$result->student_parent_id);
        } 
      }
    }else{
      $studentInformation= "";     
    }

    $information = array();
    foreach( $studentInformation as $student){
      $parent =RegisterParentInformation::where("id",$student['student_parent_id'])->first();
      $class =RegisterClasses::where("id",$student['student_class_id'])->first();
      $information['id']=$student['id'];
      $information['className']=ucfirst($class->class_name);
      $information['parentNames']=ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname);
      $information['parentGender'] =$parent->parent_gender;
    }
    return  view('admin.view-students-table',['date'=>$date,'schoolInformation'=> $schoolInformation,'studentInformation'=> $studentInformation, 'information'=> $information, 'paginator'=> $studentInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Student View Table']);
  }

  //delete student register ajax
  public function registerDeleteStudent($id){
    if(RegisterStudentInformation::where("id",$id)->exists()){
      //soft delete
      RegisterStudentInformation::where("id",$id)->update(['status' => 'delete']);
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
        $studentInformation =RegisterStudentInformation::where(["student_class_id"=>protectData($teacher->class_id)])->where(['status' => 'delete'])->paginate(1);
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
  
    return  view('admin.add-parent',['date'=>$date,'schoolInformation'=> $schoolInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Parent']);
  }

  // create parent for register
  public function registerAddParent(Request $request){
    $userId=Auth::user()->id;
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
      $adminEmail= Auth::user()->email;
      $date = date('Y');
      $userId=Auth::user()->id;
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
    return  view('admin.edit-parent',['date'=>$date,'schoolInformation'=> $schoolInformation, 'parentInformation'=> $parentInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Edit Parent']);
  }
  //show parents here
  public function registerViewParents(){

    $email= Auth::user()->email;
    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    }
    if(RegisterParentInformation::where("corox_model_id",$userId)->exists()){
      $parentInformation = RegisterParentInformation::whereNotNull('parent_firstname')->whereNotNull('parent_lastname')->whereNotNull('parent_email')->whereNotNull('parent_gender')->whereNotNull('parent_marital_status')->whereNotNull('parent_phone')->where("status",NULL)->paginate(10);    
    }else{
      $parentInformation= new RegisterParentInformation;     
    }                    
    return  view('admin.view-parents-table',['date'=>$date,'schoolInformation'=> $schoolInformation,  'parentInformation'=> $parentInformation, 'paginator'=> $parentInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=> 'View Parents Table']);
  }

  //delete parent register ajax
  public function registerDeleteParent($id){
    if(RegisterParentInformation::where("id",$id)->exists()){
      //soft delete
      RegisterParentInformation::where("id",$id)->update(['status' => 'delete']);
      return response()->json(['success'=>'success','message'=>'Parent with an id '.$id.' has been deleted successfully']);
    
    }else{
     return response()->json(['success'=>'danger','message'=>'Contact the administrator the parent with an '.$id.' is not found' ]);  
    }                    

  }

  //tracking page to post update staff detail
  public function registerUpdateParent(Request $request){
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
  
  //add subject
  public  function registerSelectSubject(Request $request){ 
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class']);
      }elseif($request->input('student') == ''){
        return response()->json(['student'=>'danger','message'=>'Select student\'s name']);
      }elseif($request->input('subject') ==''){
        return response()->json(['subject'=>'danger','message'=>'Select subject']);
      }else{
        $class = protectData($request->input('class'));
        $student = protectData($request->input('student'));
        $subject= protectData($request->input('subject'));
        $class_name = protectData($request->input('class_name'));                
        $student_name = protectData($request->input('student_name'));
        $subject_name= protectData($request->input('subject_name'));
        if($request->input('condition')=='on'){
          if($request->input('department') ==''){
            return response()->json(['department'=>'danger','message'=>'Select student department']);
          }else{
            $department = protectData($request->input('department'));
          }
          
        }else{
          $department = protectData($request->input('department'));
        }                
        $student_result = RegisterStudentClassStatus::where('student_id',$student)->where('class_id',$class)->where('status','present')->first();
        //$class_result = RegisterClassRegisterStatus::where('student_id',$student)->where('class_id',$class)->first();
        $student_subject= RegisterStudentSubject::where(array('student_id'=>$student, 'subject_id'=> $subject, 'class_id'=>$class, 'year'=>$student_result->year ))->first();
        if($student_subject){
          return response()->json(['failure'=>'danger','message'=> $subject_name.' subject has already been selected for '.ucfirst($student_name).' in class '.$class_name]);     
        }else{
          $student_result = RegisterStudentClassStatus::where("student_id",$student)->where("status","present")->first();
          $student_subject= new RegisterStudentSubject;
          $student_subject->student_id=$student;
          $student_subject->corox_model_id = $userId;
          $student_subject->subject_id= $subject;
          $student_subject->class_id= $class;
          $student_subject->department= $department;
          $student_subject->year= $student_result->year;
          $class_result = RegisterClassRegisterStatus::where("student_id",$student)->where("class_id",$class)->first();
          if($class_result){
            $student_subject->term= $class_result->term;
          }else{
            return response()->json(['failure'=>'danger','message'=>'kindly register session term for '.$class_name.' class']);      
          }
          
          if($student_subject->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully selected '.$subject_name.' subject for '.ucfirst($student_name).' in class '.$class_name]);      
          }else{
            return response()->json(['failure'=>'danger','message'=> $subject_name.' subject is not successfully selected for '.ucfirst($student_name).' in class '.$class_name]);     
          }  
        }                                              
      }              
    }else{

      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(RegisterClasses::where("corox_model_id",$userId)->exists()){
        $classes = RegisterClasses::where("corox_model_id",$userId)->get();
      }else{
        $classes= new RegisterClasses;     
      }                    
      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }  

      $subjects = RegisterSubject::where("corox_model_id",$userId)->get();

      if($subjects){
       
        $subjects = RegisterSubject::where("corox_model_id",$userId)->get();
      }else{
        $subjects = "";
      }

      if(RegisterStudentSubject::where("corox_model_id",$userId)->exists()){
         
        $select_subjects = RegisterStudentSubject::where(array("corox_model_id"=>$userId))->get();
        if($select_subjects){
          $student_subjects = array();
          foreach($select_subjects as $select_subject){
            $student = RegisterStudentInformation::where("id", $select_subject->student_id)->first();
            $subject = RegisterSubject::where("id", $select_subject->subject_id)->first();
            $class = RegisterClasses::where("id", $select_subject->class_id)->first();
            $student_subjects[] = array("id"=>$select_subject->id, "fullname"=>$student->student_firstname." ".$student->student_lastname, "subject"=>$subject->subject_name, "class"=>$class->class_name, "term"=>$select_subject->term, "year"=>$select_subject->year);         
          }
        }else{
          $select_subjects = "";
        }

        $subjects = RegisterSubject::where("corox_model_id",$userId)->get();
        if($subjects){
          $subjects = RegisterSubject::where("corox_model_id",$userId)->get();
        }else{
          $subjects = "";
        }
      }else{
        $teachers= "";     
      
      }              
    
      return view('admin.select-subject', ['date'=>$date,  'schoolInformation'=> $schoolInformation, 'classes'=> $classes, 'subjects'=>$subjects, 'studentSubjects'=> $student_subjects, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Select Student Subject']);
    } 
  }  

   // show page to store stationeries
   public function registerStationeries(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('name') == ''){
        return response()->json(['stationary'=>'danger','message'=>'Stationary name is required']);
      }elseif($request->input('status') ==''){
        return response()->json(['status'=>'danger','message'=>'Select Stationary status']);
      }elseif($request->input('quantity') ==''){
        return response()->json(['quantity'=>'danger','message'=>'Quantity is required']);
      }elseif($request->input('amount') ==''){
        return response()->json(['amount'=>'danger','message'=>'Amount is required']);
      }else{
        $name = protectData($request->input('name'));
        $status= protectData($request->input('status'));
        $quantity = protectData($request->input('quantity'));
        $amount= protectData($request->input('amount'));
        $stationary_result= RegisterStationeries::where(array('stationary_name'=>$name, "corox_model_id"=>$userId))->first();
        if(is_null($stationary_result)){
          $stationary_result= new RegisterStationeries;
          $stationary_result->stationary_name=$name;
          $stationary_result->stationary_status = $status;
          $stationary_result->stationary_quantity= $quantity;
          $stationary_result->stationary_amount= $amount;
          $stationary_result->stationary_date= date('Y-m-d');   
          $stationary_result->corox_model_id= $userId;
          if($stationary_result->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully added '.$name.' of an amount '.$amount.' with status '.$status.' of quantity '.$quantity.' to the store']);      
          }else{
            return response()->json(['failure'=>'danger','message'=> $name.' of an amount '.$amount.' with status '.$status.' of quantity '.$quantity.' is not successfully  added to the store']);     
          }  
        }else{
          $quantity = (int)$stationary_result->stationary_quantity + (int)$quantity;
          RegisterStationeries::where(array("stationary_name" => $name, "corox_model_id"=>$userId))->update(['stationary_quantity'=>$quantity, 'stationary_amount'=>$amount]);
          return response()->json(['success'=>'success','message'=> ucfirst($name).' of an amount '.$amount.' with status '.$status.' of quantity '.$quantity.' has successfully been updated']);       
        }                
      }
    }else{  
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(RegisterStationeries::where("corox_model_id",$userId)->exists()){              
        $stationeries =  RegisterStationeries::where("corox_model_id",$userId)->get();  
      }else{
        $stationeries = new RegisterStationeries;      
      }

      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation = new RegisterSchoolInformation;     
      }
      return  view('admin.stationeries',['date'=>$date,'schoolInformation'=> $schoolInformation, 'stationeries'=>$stationeries, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Add Stationeries']);
    }
  }       
  
   // show page to assign book to student
  public function registerAssignBook(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('student') == ''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('book') ==''){
        return response()->json(['book'=>'danger','message'=>'Select book to assign']);
      }elseif($request->input('book_condition') ==''){
        return response()->json(['condition'=>'danger','message'=>'Kindly State the present condition of the book']);
      }else{
        $student= protectData($request->input('student'));
        $book= protectData($request->input('book'));
        $book_condition = protectData($request->input('book_condition'));
        $student_name = protectData($request->input('student_name'));
        $book_name= protectData($request->input('book_name'));
        $assign_book= RegisterAssignBook::where(array('student_id'=>$student, 'book_id'=> $book, "book_status"=>"assigned"))->first();
        if($assign_book){
          return response()->json(['failure'=>'danger','message'=> $book_name.' book has already been assigned to '.$student_name]);     
        }else{
          $student_result= RegisterStudentClassStatus::where("student_id",$student)->where("status","present")->get();
          $book_assign= new RegisterAssignBook;
          $book_assign->student_id=$student;
          $book_assign->book_id = $book;
          $book_assign->class_id = $student_result->class_id;
          $book_assign->corox_model_id= $userId;
          $book_assign->book_condition = $book_condition;
          $book_assign->book_status= "assigned";
          $book_assign->assign_date = date("Y-m-d");
          $book_assign->assign_time = date("H:i:s");
          if($book_assign->save()){
            $stationary_result = RegisterStationeries::where(array("id" => $book, "stationary_status"=>"library"))->first();
            $quantity = (int)$stationary_result->stationary_quantity - 1;
            RegisterStationeries::where(array("id" => $book, "corox_model_id"=>$userId))->update(['stationary_quantity'=>$quantity]);
            return response()->json(['success'=>'success','message'=>'You have successfully assigned '.$book_name.' book '.$student_name]);      
          }else{
            return response()->json(['failure'=>'danger','message'=> $book_name.' book is not successfully  assigned to '.$student_name]);     
          }  
        }                                              
      }
    }else{

      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(RegisterAssignBook::where("corox_model_id",$userId)->exists()){               
        $assignedBooks = array();
        $books = RegisterAssignBook::where(array("corox_model_id"=>$userId))->get();
        foreach($books as $book){
          $stationary_result = RegisterStationeries::where(array("id" => $book->book_id, "stationary_status"=>"library"))->first();
          $student = RegisterStudentInformation::where("id", $book->student_id)->first();
          $class = RegisterClasses::where("id", $book->class_id)->first();
          $assignedBooks[] = array("id"=>$book->id, "fullname"=>$student->student_firstname." ".$student->student_lastname, "book"=>$stationary_result->stationary_name, "class_name"=>$class->class_name, "condition"=>$book->book_condition, "status"=>$book->book_status, "time_assigned"=>$book->assign_time, "time_returned"=>$book->return_time, "date"=>$book->assign_date);         
        }
          
      }else{
        $assignedBooks= "";     
        
      }

      if(RegisterStudentInformation::where("corox_model_id",$userId)->exists()){
        $students = RegisterStudentInformation::where("corox_model_id",$userId)->get();
      }else{
        $students= "";     
      }   
      
      if(registerStationeries::where("corox_model_id", $userId)->exists()){               
        $books = registerStationeries::where(array("stationary_status" =>"library","corox_model_id" => $userId))->get();      
      }else{
        $books= "";     
      }              
      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      return  view('admin.assign-book',['date'=>$date,'schoolInformation'=> $schoolInformation, "students"=>$students, "assignedBooks"=>$assignedBooks, "books"=>$books, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Assign Book']);
    }
  }          
  
   // show page for result computing and estimator of result
   public function registerResultEstimator(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('estimator_type') == ''){
        return response()->json(['estimator'=>'danger','message'=>'Select estimator type']);
      }elseif($request->input('estimator_value') ==''){
        return response()->json(['value'=>'danger','message'=>'Estimator value is required']);
      }else{
        $type= protectData($request->input('estimator_type'));
        $estimator_name= protectData($request->input('estimator_name'));
        $value= protectData($request->input('estimator_value'));

        $result_estimator= RegisterResultEstimator::where(array('estimator_type'=>$type, "corox_model_id"=>$userId))->first();
        if(is_null($result_estimator)){
          $result_estimator= new RegisterResultEstimator;
          $result_estimator->corox_model_id= $userId;
          $result_estimator->estimator_type= $type;
          $result_estimator->estimator_value = $value;
          if($result_estimator->save()){
            return response()->json(['success'=>'success','message'=> ucfirst($estimator_name).' of estimator value '.$value.' has successfully been recorded']);     
          }else{
            return response()->json(['failure'=>'danger','message'=> ucfirst($estimator_name).' of estimator value '.$value.' has not been recorded contact the admin']);     
          }
        }else{
          RegisterResultEstimator::where(array("estimator_type" => $type, "corox_model_id"=>$userId))->update(['estimator_value'=>$value]);
          return response()->json(['success'=>'success','message'=> ucfirst($estimator_name).' of estimator value '.$value.' has successfully been updated']);       
        }                                          
      }
    }else{
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(RegisterResultEstimator::where("corox_model_id",$userId)->exists()){               
        $estimators = RegisterResultEstimator::where(array("corox_model_id"=>$userId))->get();    
      }else{
        $estimators= "";      
      }              

      if(RegisterStudentInformation::where("corox_model_id",$userId)->exists()){
        $students = RegisterStudentInformation::where("corox_model_id",$userId)->get();
      }else{
        $students= "";     
      }   

      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      return  view('admin.result-estimator',['date'=>$date,'schoolInformation'=> $schoolInformation, 'estimators'=>$estimators, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Result Estimator']);           
    }
  }  
  
   // show page for saving mark result
   public function registerResultAggregator(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class_id') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class name']);
      }elseif($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term name']);
      }elseif($request->input('year') ==''){
        return response()->json(['year'=>'danger','message'=>'Select the academic year']);
      }elseif($request->input('student_id') == ''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('subject_id') == ''){
        return response()->json(['subject'=>'danger','message'=>'Select subject name']);
      }elseif($request->input('mark_type') ==''){
        return response()->json(['mark_type'=>'danger','message'=>'Select mark type']);
      }elseif($request->input('mark') ==''){
        return response()->json(['mark'=>'danger','message'=>'Enter required mark']);
      }elseif(!is_numeric($request->input('mark'))){
        return response()->json(['mark'=>'danger','message'=>'Mark must be a number']);
      }else{
        $student_id= protectData($request->input('student_id'));
        $class_id= protectData($request->input('class_id'));
        $subject_id = protectData($request->input('subject_id'));
        $term= protectData($request->input('term'));
        $marks= protectData($request->input('mark'));
        $mark_type= protectData($request->input('mark_type'));
        $mark_type_name= protectData($request->input('mark_type_name'));
        $student_name = protectData($request->input('student_name'));
        $subject_name = protectData($request->input('subject_name'));
        $class_name= protectData($request->input('class_name'));
        $term_name = protectData($request->input('term_name'));
        $year = protectData($request->input('year'));
        $result_aggregator= RegisterResultAggregator::where(array('student_id'=>$student_id, 'class_id'=>$class_id, 'subject_id'=>$subject_id, 'mark_type'=>$mark_type, 'corox_model_id'=>$userId, 'term'=>$term, 'year'=>$year))->first();
        if($result_aggregator){
          return response()->json(['failure'=>'danger','message'=> $subject_name.' '.$mark_type_name.' of '.$marks.' marks for '.ucwords($student_name).' in '.$class_name.' class for '.strtolower($term_name).' of '.$year.' academic session has already been recorded']);     
        }else{
          $result_aggregator = new RegisterResultAggregator;
          $result_aggregator->student_id=$student_id;
          $result_aggregator->class_id = $class_id;
          $result_aggregator->subject_id = $subject_id;
          $result_aggregator->term = $term;
          $result_aggregator->corox_model_id= $userId;
          $result_aggregator->year= $year;
          $result_aggregator->mark = $marks;
          $result_aggregator->status = 'open';
          $result_aggregator->mark_type = $mark_type;
          $result_aggregator->register_date = date("Y-m-d");
          $result_aggregator->register_time = date("H:i:s");
          $result_aggregator->save();
          if($result_aggregator){
            return response()->json(['success'=>'success','message'=> 'You have successfully save '.$subject_name.' '.$mark_type_name.' of '.$marks.' marks for '.ucwords($student_name).' in '.$class_name.' class for '.strtolower($term_name).' of '.$year.' academic session']);     
          }else{
            return response()->json(['failure'=>'danger','message'=> 'Oops something went wrong contact the admin']);     
          }
        }                                          
      }
    }else{

      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(registerAcademicSession::where("corox_model_id",$userId)->exists()){
        $years = registerAcademicSession::where("corox_model_id",$userId)->get();
      }else{
        $years= new registerAcademicSession;     
      }                 

      if(RegisterClasses::where("corox_model_id",$userId)->exists()){
        $classes = RegisterClasses::where("corox_model_id",$userId)->get();
      }else{
        $classes= new RegisterClasses;     
      }             

      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      if(RegisterStudentInformation::where("corox_model_id",$userId)->exists()){
        $studentInformation = DB::table('register_student_informations')->whereNotNull('student_firstname')->whereNotNull('student_lastname')->whereNotNull('student_email')->whereNotNull('student_gender')->whereNotNull('student_phone')->where("status", NULL)->get();    
      }else{
        $studentInformation= new RegisterStudentInformation;     
      }  


      if(RegisterSubject::where("corox_model_id",$userId)->exists()){
        
        $subjects = RegisterSubject::where("corox_model_id",$userId)->get();
      }else{
        $subjects = new RegisterSubject;
      }

      return  view('admin.result-aggregator',['date'=>$date,'schoolInformation'=> $schoolInformation, 'students' => $studentInformation, 'classes'=>$classes, 'subjects'=> $subjects, 'years'=>$years, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Result Aggregator']);
    }
  }            
  
   // show marks  Table
   public function registerViewMarks(Request $request){
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(registerAcademicSession::where("corox_model_id",$userId)->exists()){
        $years = registerAcademicSession::where("corox_model_id",$userId)->get();
      }else{
        $years= new registerAcademicSession;     
      }                 

      if(RegisterClasses::where("corox_model_id",$userId)->exists()){
        $classes = RegisterClasses::where("corox_model_id",$userId)->get();
      }else{
        $classes= new RegisterClasses;     
      }             

      if(RegisterResultAggregator::where('corox_model_id',$userId)->first()){
        $result_aggregators = array();
        $aggregators = RegisterResultAggregator::where(array("corox_model_id"=>$userId))->paginate(10);
        foreach($aggregators as $aggregator){
          $subject = RegisterSubject::where("id",$aggregator->subject_id)->first();
          $student = RegisterStudentInformation::where("id", $aggregator->student_id)->first();
          $class = RegisterClasses::where("id", $aggregator->class_id)->first();
          $result_aggregators[] = array("id"=>$aggregator->id, "fullname"=>$student->student_firstname." ".$student->student_lastname, "subject"=>$subject->subject_name, "class"=>$class->class_name, "mark"=>$aggregator->mark, "mark_type"=>$aggregator->mark_type, "term"=>$aggregator->term, "year"=>$aggregator->year, "status"=>$aggregator->status, "time"=>$aggregator->register_time, "date"=>$aggregator->register_date);         
        }
                      
      }else{
        $result_aggregators ="";
      }              

      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      return  view('admin.view-marks',['date'=>$date,'schoolInformation'=> $schoolInformation, 'classes'=>$classes, 'years'=>$years,  'result_aggregators'=>$result_aggregators, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'View Result']);
    
  } 


  //show edit mark
  public function registerEditMark(Request $request, $id){

    $date = date('Y');
    $userId=Auth::user()->id;
    $adminEmail=Auth::user()->email;
    if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
      $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
    }else{
      $schoolInformation= new RegisterSchoolInformation;     
    }
    if( $id == null || $id == '' || !is_numeric($id)){
      $request->session()->flash('message', 'You are not allowed to edit this mark');
      return redirect()->route('404');; 
    }             
    if(RegisterResultAggregator::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->exists()){
      $mark = RegisterResultAggregator::where(["corox_model_id"=>$userId, "id"=>protectData($id)])->first();

      $student= RegisterStudentInformation::where(["corox_model_id"=>$userId, "id"=>protectData($mark->student_id)])->first();
      
      $class= RegisterClasses::where(["corox_model_id"=>$userId, "id"=>protectData($mark->class_id)])->first();
        
      $subject = RegisterSubject::where(["corox_model_id"=>$userId, "id"=>protectData($mark->subject_id)])->first();
                                   
                       
    }else{
      $request->session()->flash('message', 'You are not allowed to edit this mark');                               
      return redirect()->route('404');   
    }                    
    return  view('admin.edit-mark',['date'=>$date,'schoolInformation'=> $schoolInformation, 'student' => $student, 'mark'=> $mark, 'class'=> $class, 'subject'=> $subject, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Edit Mark']);
  }


  //update mark detail
  public function registerUpdateMark(Request $request){

    if($request->id == null || $request->id == '' || !is_numeric($request->id)){
      $request->session()->flash('message', 'You are not allowed to update this mark');
      return redirect()->route('404');;  
    }

    if(RegisterResultAggregator::where(['id'=>protectData($request->id)])->exists()){
      
      $mark = RegisterResultAggregator::find(protectData($request->id));                                                         
     
        $rule=array(
          'mark_name'=>'required',
        );
        $validator= Validator::make($request->all(),$rule);
        if($validator->fails()){
          return redirect()->route('edit-mark',['id' => $request->id])->withErrors($validator);
        }else{ 
                                    
          $mark->mark= protectData($request->mark_name);
          
          if($mark->save()){
            $request->session()->flash('messageSuccess', 'mark successfully updated');                                                           
          }else{
            $request->session()->flash('message', 'mark is not successfully updated');                       
          }
          return back()->with($request->id);  
        }                         
    }else{
      $request->session()->flash('message', 'You are not allowed to update this mark');
      return back()->with($request->id); 
    }
  }  
  
  
  
   // change student
   public function registerChangeStudent(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      if($request->input('class_id') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class name']);
      }elseif($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term name']);
      }elseif($request->input('year') ==''){
        return response()->json(['year'=>'danger','message'=>'Select the academic year']);
      }elseif($request->input('student_id') == ''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }else{
        $options ="";
        $class_id= protectData($request->input('class_id'));
        $student_id= protectData($request->input('student_id')); 
        $student_name= protectData($request->input('student_name')); 
        $term= protectData($request->input('term')); 
        $year= protectData($request->input('year')); 
        $subjects= RegisterStudentSubject::where(array('student_id'=>$student_id, 'class_id'=>$class_id, 'term'=>$term, 'year'=>$year))->get();             
        if($subjects){
          foreach($subjects as $subject){
            $subject_result= RegisterSubject::where("id",$subject->subject_id)->get();
            foreach($subject_result as $result){
              $options .="<option value='".$result->id."'>".ucfirst($result->subject_name)."</option>";
            }                    
          }
          if($options ==""){
            return response()->json(['subject'=>'danger','message'=>'Kindly select subject(s) name first for '.ucwords($student_name)]);
          }else{
            return response()->json(['success'=>'success', 'options'=> $options]); 
          }  
        }else{
          return response()->json(['failure'=>'danger','message'=> 'Oops Something went wrong']);     
        }                                              
      }
    }else{
      return redirect()->route('class-status');
    }
  } 
   // change the status of book to returned
  public function registerAssignStatus(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      if($request->input('status') == ''){
        return response()->json(['failure'=>'danger','message'=>'Kindly select book status']);
      }else{
        $status= protectData($request->input('status'));
        $book_id= protectData($request->input('book_id'));
        $assign_book= RegisterAssignBook::where("id",$book_id)->update(['book_status'=>$status, 'return_time' => date("H:i:s")]);
        if($assign_book){
          $stationary_result = RegisterStationeries::where(array("stationary_status"=>"library"))->first();
          $quantity = (int)$stationary_result->stationary_quantity + 1;
          RegisterStationeries::where(array("stationary_status"=>"library"))->update(['stationary_quantity'=>$quantity]);
          return response()->json(['success'=>'success']);     
        }else{
          return response()->json(['failure'=>'danger','message'=> ' Book status is not successfully updated']);     
        }                                              
      }
    }else{
      return redirect()->route('assign-book');
    }
  }              

   // update the condition of the book given to the student
   public function registerBookCondition(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $book_condition= protectData($request->input('book_condition'));
      $book_id= protectData($request->input('book_id'));
      //$book_name= protectData($request->input('book_name'));
      RegisterAssignBook::where("id",$book_id)->update(['book_condition'=>$book_condition]);
      return response()->json(['success'=>'success']);                                      
    }else{
      return redirect()->route('assign-book');
    }
  }
  
   // update the mark of the student
   public function registerMark(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      if($request->input('mark')==''){
        return response()->json(['mark'=>'danger','message'=>'empty']);
      }else if(!is_numeric($request->input('mark'))){
        return response()->json(['mark'=>'danger','message'=>'not number']);
      }else{
        $mark= protectData($request->input('mark'));
        $aggregator_id= protectData($request->input('aggregator_id'));
        registerResultAggregator::where("id",$aggregator_id)->update(['mark'=>$mark]);
        return response()->json(['success'=>'success']); 
      }                                     
    }else{
      return redirect()->route('result-aggregator');
    }
  } 

   // show page to set class status for student
   public function registerClassStatus(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class name']);
      }elseif($request->input('student') == ''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term name']);
      }elseif($request->input('year') ==''){
        return response()->json(['year'=>'danger','message'=>'Academic year is required']);
      }else{
        $student= protectData($request->input('student'));
        $class= protectData($request->input('class'));
        $term= protectData($request->input('term'));
        $student_name = protectData($request->input('student_name'));
        $class_name= protectData($request->input('class_name'));
        $term_name = protectData($request->input('term_name'));
        $year = protectData($request->input('year'));

        $class_register= RegisterClassRegisterStatus::where(array('student_id'=>$student, 'class_id'=> $class, 'term' => $term, 'year'=>$year))->first();
        if($class_register){
          return response()->json(['failure'=>'danger','message'=> ucwords($student_name).' in class '.ucfirst($class_name).' has already been registered for '.strtolower($term_name).' of the academic calender '.$year]);     
        }else{
          $class_register= new RegisterClassRegisterStatus;
          $class_register->student_id=$student;
          $class_register->class_id = $class;
          $class_register->term = $term;
          $class_register->corox_model_id= $userId;
          $class_register->year= $year;
          $class_register->register_date = date("Y-m-d");
          if($class_register->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully register '.ucwords($student_name).' of class '.ucfirst($class_name).' to '. strtolower($term_name).' of the academic calender '.$year]);      
          }else{
            return response()->json(['failure'=>'danger','message'=> ucwords($student_name).' is not successfully  register to the academic calender for '.$year]);     
          }  
        }                                              
      }
    }else{
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
      if(RegisterClasses::where("corox_model_id",$userId)->exists()){
        $classes = RegisterClasses::where("corox_model_id",$userId)->get();
      }else{
        $classes= new RegisterClasses;     
      }                      
      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      return  view('admin.class-status',['date'=>$date,'schoolInformation'=> $schoolInformation, "classes"=>$classes, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Student Class Status']);
    }
  }
  
   // ajax post register student promotion
   public function registerStudentPromotion(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class_present_id') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class name']);
      }elseif($request->input('student') == ''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('class_promotion_id') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term name']);
      }else{
        $student= protectData($request->input('student'));
        $class_present_id= protectData($request->input('class_present_id'));
        $class_promotion_id= protectData($request->input('class_promotion_id'));
        $student_name = protectData($request->input('student_name'));
        $class_present_name= protectData($request->input('class_present_name'));
        $class_promotion_name = protectData($request->input('class_promotion_name'));                
        if($class_present_id == $class_promotion_id){
          return response()->json(['failure'=>'danger','message'=> "You can't promote student to the same class"]);     
        }else{
          $class_register_status= RegisterClassRegisterStatus::where(array("student_id" => $student, "class_id"=>$class_present_id, "term"=>"first term", "year"=>date('Y').'-'.(date('Y')+1)))->first();
          $class_student_class= RegisterStudentClassStatus::where(array("student_id" => $student, "class_id"=>$class_present_id, "status"=>"present"))->update(['status'=> "previous"]);
          if($class_student_class){
            $class_student_class= new RegisterStudentClassStatus;
            $class_student_class->student_id=$student;
            $class_student_class->class_id =  $class_promotion_id;
            $class_student_class->status = 'present';
            $class_student_class->corox_model_id= $class_register_status->corox_model_id;
            $class_student_class->year= date('Y').'-'.(date('Y')+1);
            $class_student_class->date = date("Y-m-d");
            if($class_student_class->save()){
              return response()->json(['success'=>'success','message'=>'You have successfully promoted '.ucwords($student_name).' from class '.$class_present_name.' to  class '.$class_promotion_name.' of the academic calender '.date('Y').'-'.(date('Y')+1)]);      
            }else{
              return response()->json(['failure'=>'danger','message'=> ucwords($student_name).' is not successfully   promoted '.ucwords($student_name).' from class '.$class_present_name.' to  class '.$class_promotion_name.' of the academic calender '.date('Y').'-'.(date('Y')+1)]);     
            }                                        
          }else{
            return response()->json(['failure'=>'danger','message'=> ucwords($student_name).' is not successfully   promoted '.ucwords($student_name).' from class '.$class_present_name.' to  class '.$class_promotion_name.' of the academic calender '.date('Y').'-'.(date('Y')+1)]);          
          }
        }                                                
      }
    }else{
      return redirect()->route('class-status');
    }
  }             

   // change class
   public function registerChangeClass(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      if($request->input('class_id') == ''){
        return response()->json(['failure'=>'danger','message'=>'Select student class name']);
      }else{
        $options ="";
        $class_id= protectData($request->input('class_id')); 
        $students= RegisterStudentClassStatus::where('class_id',$class_id)->where("status","present")->get();             
        if($students){
          foreach($students as $student){
            $student_result= RegisterStudentInformation::where("id",$student->student_id)->get();
            foreach($student_result as $result){
              $options .="<option value='".$result->id."'>".ucwords($result->student_firstname.' '.$result->student_lastname)."</option>";
            }                    
          }
          return response()->json(['success'=>'success', 'options'=> $options]);     
        }else{
          return response()->json(['failure'=>'danger','message'=> 'Oops something went wrong']);     
          
        }                                              
      }
    }else{
      return redirect()->route('class-status');
    }
  } 
  
  
   // show page for record sales
  public function registerRecordSales(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('student') ==''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('stationary') ==''){
        return response()->json(['stationary'=>'danger','message'=>'Select stationary name']);
      }elseif($request->input('quantity') ==''){
        return response()->json(['quantity'=>'danger','message'=>'Quantity is required']);
      }elseif($request->input('transaction') ==''){
        return response()->json(['transaction'=>'danger','message'=>'Select transaction type']);
      }else{
        $student_id= protectData($request->input('student'));
        $student_name= protectData($request->input('student_name'));
        $stationary_id= protectData($request->input('stationary'));
        $stationary_name= protectData($request->input('stationary_name'));
        $quantity = protectData($request->input('quantity'));
        $transaction_type= protectData($request->input('transaction'));
        $transaction_name= protectData($request->input('transaction_name'));
        if(RegisterStationeries::where(array("id" => $stationary_id, "corox_model_id" => $userId))->exists()){
          $stationary_result = RegisterStationeries::where(array("id" => $stationary_id, "corox_model_id" => $userId))->first();
          $quantity_result = (int)$stationary_result->stationary_quantity - $quantity;
          RegisterStationeries::where(array("id" => $stationary_id, "corox_model_id"=>$userId))->update(['stationary_quantity'=> $quantity_result]);
          $sales_order = new RegisterSalesRecord;
          $sales_order->stationary_id = $stationary_id;
          $sales_order->student_id = $student_id;
          $sales_order->quantity = $quantity;
          $sales_order->transaction_type = $transaction_type;
          $sales_order->corox_model_id = $userId;
          $sales_order->time = date('H:i:s');
          $sales_order->date = date('Y-m-d');    
          if($sales_order->save()){
            return response()->json(['success'=>'success','message'=> ucfirst($student_name).' bought '.$quantity.' quantity of '.$stationary_name.' payment was made by '.$transaction_name]);     
          }else{
            return response()->json(['failure'=>'danger','message'=> 'Oops something went wrong']);     
          }             
          
        }else{
          return response()->json(['failure'=>'danger','message'=> 'Oops something went wrong']);     
        }                                          
      }
    }else{  
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(RegisterStudentInformation::where("corox_model_id",$userId)->exists()){
        $students = RegisterStudentInformation::where("corox_model_id",$userId)->get();
      }else{
        $students= "";     
      }   

      if(RegisterStationeries::where("corox_model_id",$userId)->exists()){
        $stationeries = RegisterStationeries::where("corox_model_id",$userId)->where("stationary_status", "!=" ,"library")->get();
      }else{
        $stationeries="";     
      }   
      
      if(RegisterSalesRecord::where("corox_model_id",$userId)->exists()){
        $sales_record= RegisterSalesRecord::where("corox_model_id",$userId)->get();
        $sales_result = array();
        foreach($sales_record as $sales){
          $student = RegisterStudentInformation::where("id",$sales->student_id)->first();
          $stationary = RegisterStationeries::where("id", $sales->stationary_id)->first();
          $sales_result[] = array("id"=>$sales->id, "student"=>$student->student_firstname." ".$student->student_lastname, "amount"=>$stationary->stationary_amount, "stationary"=>$stationary->stationary_name, "quantity" =>$sales->quantity, "transaction_type"=>$sales->transaction_type, "time"=>$sales->time, "date"=>$sales->date);         
        }

      }else{
        $sales_result="";     
      } 
      
      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      return  view('admin.record-sales',['date'=>$date, 'schoolInformation'=> $schoolInformation, 'students'=> $students, 'sales_record'=> $sales_result, 'stationeries'=> $stationeries,  'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Record Sales']);
    }
  }            
  
   // change student to get parent of student
  public function registerChangeStudentName(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      if($request->input('student_id') == ''){
        return response()->json(['failure'=>'danger','message'=>'Select student name']);
      }else{
        $options ="";
        $student_id= protectData($request->input('student_id')); 
        $student= RegisterStudentInformation::where("id",$student_id)->first();
        if($student){
          $parent= RegisterParentInformation::where("id",$student->student_parent_id)->first();
          if($parent){
            if($parent->parent_gender=='male'){
              $gender = 'Mr ';
            }else{
              $gender = 'Mrs ';
            }
            return response()->json(['success'=>'success', 'parent_name'=> ucwords($gender.$parent->parent_firstname.' '.$parent->parent_lastname)]);     
          }else{
            return response()->json(['failure'=>'danger', 'message'=> 'Kindly add student parent']);     
          }
         
        }else{
          return response()->json(['failure'=>'danger','message'=> 'Oops something went wrong']);     
        }                                              
      }
    }else{
      return redirect()->route('view-results');
    }
  } 


   // get students 
   public function registerChangeClassName(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class_id') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class name']);
      }elseif($request->input('duration') == ''){
        return response()->json(['duration'=>'danger','message'=>'Select class duration']);
      }elseif($request->input('year') ==''){
        return response()->json(['year'=>'danger','message'=>'Academic year is required']);
      }elseif($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term name']);
      }else{
        $class_id= protectData($request->input('class_id'));
        $term= protectData($request->input('term'));
        $duration= protectData($request->input('duration'));
        $year = protectData($request->input('year'));
        $students= RegisterStudentClassStatus::where(array('class_id'=> $class_id, 'status' => $duration, 'year'=>$year))->get();
        $options ="";
        if($students){
          foreach($students as $student){
            $student_result = RegisterClassRegisterStatus::where(array('student_id'=> $student->student_id, 'class_id'=> $class_id, 'term'=> $term, 'year'=>$year))->first();
            if($student_result){
              if($student->student_id == $student_result->student_id){
                $student = RegisterStudentInformation::where(array('id'=> $student->student_id))->first();
                $options .="<option value='".$student->id."'>".ucfirst($student->student_firstname.' '.$student->student_lastname)."</option>";
              }else{
                continue;
              }
            }else{
              continue;
            }
          }                  
      
          if($options ==""){
            return response()->json(['student'=>'danger','message'=>'No available student']);
          }else{
            return response()->json(['success'=>'success', 'options'=> $options]); 
          }

        }else{
          $class_register= new RegisterClassRegisterStatus;
          $class_register->student_id=$student;
          $class_register->class_id = $class;
          $class_register->term = $term;
          $class_register->corox_model_id= $userId;
          $class_register->year= $year;
          $class_register->register_date = date("Y-m-d");
          if($class_register->save()){
            return response()->json(['success'=>'success','message'=>'You have successfully register '.ucwords($student_name).' of class '.ucfirst($class_name).' to '. strtolower($term_name).' of the academic calender '.$year]);      
          }else{
            return response()->json(['failure'=>'danger','message'=> ucwords($student_name).' is not successfully  register to the academic calender for '.$year]);     
          }  
        }                                              
      }
    }else{
      return redirect()->route('view-marks');
    }
  }

            
  //view send result
  /*public  function registerSendResult(Request $request){ 
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class name']);
      }elseif($request->input('duration') == ''){
        return response()->json(['duration'=>'danger','message'=>'Select class duration']);
      }elseif($request->input('year') ==''){
        return response()->json(['year'=>'danger','message'=>'Academic year is required']);
      }elseif($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select term name']);
      }elseif($request->input('student') ==''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('result_type') ==''){
        return response()->json(['result_type'=>'danger','message'=>'Select result type']);
      }else{  
        $class= protectData($request->input('class'));
        $term= protectData($request->input('term'));
        $duration= protectData($request->input('duration'));
        $year = protectData($request->input('year'));   
        $student = protectData($request->input('student'));    
        $result_type = protectData($request->input('result_type'));    
        $student_result = array();
        $marks = RegisterResultAggregator::where(array('student_id'=>$student, 'class'=>$class, 'term'=>$term, 'duration'=>$duration, 'year'=>$year))->get();
        $tests = 0;
        $exams =
        foreach($marks as $mark){

        }
      }
    }else{
      return redirect()->route('view-marks');
    }
  } */        
            
 
  // make payment
  public function registerPayment(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
      $userId=Auth::user()->id;
      if($request->input('class') ==''){
        return response()->json(['class'=>'danger','message'=>'Select student class']);
      }elseif($request->input('student') ==''){
        return response()->json(['student'=>'danger','message'=>'Select student name']);
      }elseif($request->input('term') ==''){
        return response()->json(['term'=>'danger','message'=>'Select stationary name']);
      }elseif($request->input('year') ==''){
        return response()->json(['year'=>'danger','message'=>'Academic year is required']);
      }elseif($request->input('transaction') ==''){
        return response()->json(['transaction'=>'danger','message'=>'Select transaction type']);
      }elseif($request->input('amount') ==''){
        return response()->json(['amount'=>'danger','message'=>'Amount is required']);
      }else{
        $student_id= protectData($request->input('student'));
        $student_name= protectData($request->input('student_name'));
        $class_id= protectData($request->input('class'));
        $class_name= protectData($request->input('class_name'));
        $term= protectData($request->input('term'));
        $term_name= protectData($request->input('term_name'));
        $year= protectData($request->input('year'));
        $amount = protectData($request->input('amount'));
        $transaction_type= protectData($request->input('transaction'));
        $transaction_name= protectData($request->input('transaction_name'));

        if(RegisterTransaction::where(array("class_id" => $class_id, "student_id" => $student_id, "term"=>$term, "year"=>$year, "transaction_type"=>$transaction_type))->exists()){
          RegisterTransaction::where(array("class_id" => $class_id, "student_id" => $student_id, "term"=>$term, "year"=>$year, "transaction_type"=>$transaction_type))->update(['amount'=>$amount]);
          return response()->json(['success'=>'success','message'=>'You have successfully updated '.$transaction_name.' payment with an amount '.$amount]);                  
          
        }else{
          $transaction_result = new RegisterTransaction;
          $transaction_result->class_id = $class_id;
          $transaction_result->student_id = $student_id;
          $transaction_result->amount = $amount;
          $transaction_result->corox_model_id = $userId;
          $transaction_result->term = $term;
          $transaction_result->year = $year;
          $transaction_result->transaction_type = $transaction_type;
          $transaction_result->transaction_time = date('H:i:s');
          $transaction_result->transaction_date = date('Y-m-d');   
          if($transaction_result->save()){
            return response()->json(['success'=>'success','message'=> ucfirst($student_name).' has a pending amount '.$amount.' of '.$transaction_name.' for '.$term_name]);     
          }else{
            return response()->json(['failure'=>'danger','message'=> 'Oops something went wrong']);     
          }              
        }                                          
      }
    }else{ 
      $date = date('Y');
      $userId=Auth::user()->id;
      $adminEmail=Auth::user()->email;
      if(RegisterClasses::where("corox_model_id",$userId)->exists()){
        $classes = RegisterClasses::where("corox_model_id",$userId)->get();
      }else{
        $classes= new RegisterClasses;     
      }               

      if(RegisterTransaction::where("corox_model_id",$userId)->exists()){
        $payments = array();
        $payment_results = RegisterTransaction::where("corox_model_id",$userId)->get();
        foreach($payment_results as $payment_result){
          $class = RegisterClasses::where("id",$payment_result->class_id)->first();
          $student = RegisterStudentInformation::where("id",$payment_result->student_id)->first();
          $payments[] = array('class_name'=>$class->class_name, 'student_name'=>$student->student_firstname.' '.$student->student_lastname, 'amount'=>$payment_result->amount, 'term'=>$payment_result->term, 'year'=>$payment_result->year, 'transaction_type'=>$payment_result->transaction_type, 'time'=>$payment_result->transaction_time, 'date'=>$payment_result->transaction_date);
        }
      }else{
        $payments='';
      }
      if(RegisterSchoolInformation::where("corox_model_id",$userId)->exists()){
        $schoolInformation = RegisterSchoolInformation::where("corox_model_id",$userId)->first();
      }else{
        $schoolInformation= new RegisterSchoolInformation;     
      }
      return  view('admin.payment',['date'=>$date, 'schoolInformation'=> $schoolInformation, 'classes'=>$classes, 'payments'=>$payments, 'userEmail'=>$adminEmail, 'userId'=>$userId, 'title'=>'Record Sales']);
    }
  }            
  
  //monthly earning
  public  function registerEarningMonthly(){     
    $userId=Auth::user()->id;
    $today =date('m');
    $total = 0;
    $payments = RegisterTransaction::where("corox_model_id",$userId)->get();
    foreach($payments as $payment){
      $date = $payment->transaction_date;
      $date = explode('-', $date);
        if((int)$date[1] == (int)$today){
          $total += (int)$payment->amount;
        }else{
          $total += 0;
        }
    }

    // add stationary sales to total monthly earning
    $sales_orders = RegisterSalesRecord::where("corox_model_id",$userId)->get();
    foreach($sales_orders as $sales_order){
      $date = $sales_order->date;
      $date = explode('-', $date);
      if((int)$date[1] == (int)$today){ 
        $stationary = registerStationeries::where( "id",$sales_order->stationary_id)->first();
        $total += (int)$stationary->stationary_amount;
      }else{
        $total += 0;
      }
    }
    return '&#8358 '.number_format($total,2, '.', ',');

  }  

  //annual earning
  public  function registerEarningAnnually(){     
    $userId=Auth::user()->id;
    $today =date('Y');
    $total = 0;
    $payments = RegisterTransaction::where("corox_model_id",$userId)->get();
    foreach($payments as $payment){
      $date = $payment->transaction_date;
      $date = explode('-', $date);
        if((int)$date[0] == (int)$today){
          $total += (int)$payment->amount;
        }else{
          $total += 0;
        }
    }
    // add stationary sales to total annual earning
    $sales_orders = RegisterSalesRecord::where("corox_model_id",$userId)->get();
    foreach($sales_orders as $sales_order){
      $date = $sales_order->date;
      $date = explode('-', $date);
        if((int)$date[0] == (int)$today){ 
          $stationary = registerStationeries::where( "id",$sales_order->stationary_id)->first();
          $total += (int)$stationary->stationary_amount;
        }else{
          $total += 0;
        }
    }            
    return '&#8358 '.number_format($total,2, '.', ',');

  } 

  //yearly stationeries sales
  public  function registerYearlyStationeries(){     
    $userId=Auth::user()->id;
    $today =date('Y');
    $total = 0;
    $sales_orders = RegisterSalesRecord::where("corox_model_id",$userId)->get();
    foreach($sales_orders as $sales_order){
      $date = $sales_order->date;
      $date = explode('-', $date);
        if((int)$date[0] == (int)$today){ 
          $stationary = registerStationeries::where( "id",$sales_order->stationary_id)->first();
          $total += (int)$stationary->stationary_amount;
        }else{
          $total += 0;
        }
    }
    return '&#8358 '.number_format($total,2, '.', ',');

  } 
  
  //recovered school fees for the month
  public  function registerRecoveredFees(){     
    $userId=Auth::user()->id;
    $today =date('m');
    $total = 0;
    $payments = RegisterTransaction::where(array("corox_model_id"=>$userId, "transaction_type"=>"schoolfees"))->get();
    foreach($payments as $payment){
      $date = $payment->transaction_date;
      $date = explode('-', $date);
        if((int)$date[1] == (int)$today){
          $total += (int)$payment->amount;
        }else{
          $total += 0;
        }
    }

    return '&#8358 '.number_format($total,2, '.', ',');
  }           

  //get chart
  public  function registerGetChart(){     
    $userId=Auth::user()->id;
    $today =date('M');
    $months = array();
    $values = array();
    $jan= 0;
    $apr = 0;
    $payments = RegisterTransaction::where("corox_model_id",$userId)->get();
    foreach($payments as $payment){

      if(in_array(date('M',strtotime($payment->transaction_date)),array('Jan','Feb','Mar','Apr','May'))){
        if(date('M',strtotime($payment->transaction_date)) =="Jan"){
          $jan +=(int)$payment->amount;
          $values[date('M',strtotime($payment->transaction_date))] =$apr;
        }
        if(date('M',strtotime($payment->transaction_date)) =="Apr"){
          $apr +=(int)$payment->amount;
          $values[date('M',strtotime($payment->transaction_date))] =$apr;
        }
        
      }else{
        $total =(int)$payment->amount;
        $values[date('M',strtotime($payment->transaction_date))] =$total; 
      }
     
          
    }
      if(!empty($values)){
        return $values;
      }else{
        return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      }
  } 


  //logout here
  public  function registerResetPassword(Request $request){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
       
      $password=protectData($request->input('password'));
      $rules=array(
        'password'=>'required|confirmed',
      );
      $validator= Validator::make($request->all(),$rules);
      if($validator->fails()){
        return redirect()->route('reset-password')->withErrors($validator);
      }else{
        $userId=Auth::user()->id;
        $user=$result= Corox_model::where("id", $userId)->first();
        if($user !==null){
          $user->password =Hash::make($password);
          $user->save();
          $request->session()->flash('message', 'Password successfully changed');
          return  redirect()->route('reset-password');              
        }else{
          $request->session()->flash('errorMessage', 'Oop something went wrong');
        return  redirect()->route('reset-password');
        }
      }
     }else{ 

      if(Auth::user()->isAdmin()){
        $userId= Auth::user()->id;
        $date = date('Y');
        $adminEmail=Auth::user()->email;
      }elseif(Auth::user()->isMember()){  
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

      return view('admin.reset-password', ['date'=>$date, 'schoolInformation'=>$schoolInformation,  'staffInformation'=> $staffInformation, 'userEmail'=>$adminEmail, 'userId'=>$userId,'title'=>'Forgot Password']);
    }
 
   }  

  //forgot password here
  public  function registerForgotPassword(Request $request){
   if($_SERVER['REQUEST_METHOD'] =='POST'){
      
      $email=protectData($request->input('email'));
      $rules=array(
        'email'=>'required|email',
      );
      $validator= Validator::make($request->all(),$rules);
      if($validator->fails()){
        return redirect()->route('forgot-password')->withErrors($validator);
      }else{
        $emailCheck=$result=DB::table('corox_models')->where('email',$email)->first();
        if($emailCheck !== null){

          $mail = new PHPMailer(true);

          try {
              //Email settings
              //generate random string 
              $checker =randomString(7);
              $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
              $mail->isSMTP();                                            //Send using SMTP
              $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true; // authentication enabled
              $mail->SMTPSecure = 'ssl';
              $mail->Host = "smtp.gmail.com";                    //Set the SMTP server to send through                                  //Enable SMTP authentication
              $mail->Username = "";
              $mail->Password ="";                                //SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
              $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
              //Recipients
              $mail->setFrom("methyl2007@gmail.com", 'The Register');
              $mail->addAddress($email);     //Add a recipient    
              //$mail->addEmbeddedImage(public_path().'/my-register/img/school.jpeg','cover');
              $body = '<html><body><h2 style="color:white;font-size:14px;">Hello, '.$email.'</h2>';
              $body .= '<table rules="all" style="border-color: #666; color:white:background-color:#5be9ff" cellpadding="10">';
              $body .= '<div style="background-color:#5be9ff;padding:30px;color:white"><p>Kindly change your password wih the link below</p><br><p><a href="http://127.0.0.1:8000/change-password/'.$checker.'">change Password</a></p></div>';
              $body .= "</table>";
              $body .= "</body></html>";
              $mail->isHTML(true);                            
              $mail->Subject = 'Forgot Password';
              $mail->Body  = $body;
              $mail->send();
              $user= Corox_model::where("email",$email)->first();
              $user->checker = $checker;
              $user->save();  
              $request->session()->flash('message', 'Check your email, if you have account with us');
              return  redirect()->route('forgot-password');              
          } catch (Exception $e) {
            $request->session()->flash('errorMessage', $e->getMessage());
            return  redirect()->route('forgot-password');             
          }
        }
      }
    }else{
      return view('app.forgot-password',['title'=>'Forgot Password']);
    }
  }
  
  //change password
  public  function registerChangePassword(Request $request){
    $checker = $request->name;
    return view('admin.change-password',['checker'=>$checker,'title'=>'Change Password']);
  }   

  public  function registerPassword(Request $request){ 
    $password=protectData($request->input('password'));
    $rules=array(
      'password'=>'required',
    );
    $validator= Validator::make($request->all(),$rules);
    if($validator->fails()){
      return redirect()->route('change-password',['checker'=>$request->checker])->withErrors($validator);
    }else{
      if($request->checker !==''){
        $checker = protectData($request->checker);
        $checkResult=$result=DB::table('corox_models')->where('checker',$checker)->first();
        if($checkResult !==null){
  
          $user = Corox_model::where("checker", $checker)->first();
          $user->password =Hash::make($password);
          $user->checker =NULL;
          $user->save();
          $request->session()->flash('message', 'Password successfully changed');
          return  redirect()->route('change-password',['checker'=>$checker]);              
        }else{
          $request->session()->flash('errorMessage', 'Oop link has expired');
        return  redirect()->route('change-password',['checker'=>$checker]);
        }
      }else{
        $request->session()->flash('errorMessage', ' Oops not allowed' );
      return  redirect()->route('change-password',['checker'=>$checker]);
      }
    }
  } 


  //error page here
  public  function registerError404(){                  
    return view('admin.404');
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
  public  function registerLogout(){
    Auth::logout();
    Session::flush();
    return redirect()->route('login');;
  }
  
  //test case sample
  /*public function store(Request $request, OrderDetails $order, Paymentgateway $payment){
    if($request->has('credit')){
       echo "credit";
    }else{
      $order = $order->all();
      dd($payment->charge(200));
    }
  }*/
 
}
