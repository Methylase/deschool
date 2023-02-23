<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="">
  <meta name="csrf-token" content="{{csrf_token()}}">   
  <meta name="author" content="">

  <title>The School - {{$title}}</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('my-register/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{asset('my-register/img/icon.jpg')}}"  sizes ="25x25"> 
  <!-- Custom styles for this template-->
  <link href="{{asset('my-register/css/jquery.dataTables.min.css')}}" rel="stylesheet"> 
  <link href="{{asset('my-register/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{asset('my-register/css/bootstrap-multiselect.min.css')}}" rel="stylesheet">
  <script src="{{asset('my-register/vendor/jquery/jquery.min.js')}}"></script> 

  <script>
      function dateTime(){
        var date = new Date();
        var h = date.getHours();
        var m = date.getMinutes();
        if (h > 12) {
          h -= 12;
        }else if (h ===0){
          h = 12
        }
        var s =date.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        var  result = h+':'+ m +':'+s;
        document.getElementById('time').innerHTML = result;
        var t =setTimeout(dateTime,1000);
      }
      function checkTime(i) {
        if (i < 10) {
           i = "0" + i;
        }
        return i;
      }
      $(document).ready(function(){
       //updateToggle
       $('#parentToggle').click(function(){
         $('#parent-body').toggle();
       });       
        // json to get state and local government to fill state and local goverment dropdown
        $.getJSON("{{asset('states-localgovts/states-localgovts.json')}}",function(states){
          $.each(states.states, function(key, value){
            $('#state').append($("<option></option>").attr('value', states.states[key].state).text(value.state));
            $('#state').on('change', function(){
              var state =$(this).val();
              if (states.states[key].state == state){
                //$('#state').find("option:gt(0)").remove();
                $('#localG').children("option").not(':first').remove();
                $.each(states.states[key].local, function(key, value){
                  $('#localG').append($("<option></option>").attr('value', value).text(value));
                });
              }
            })
          });                
        });
        // staff toggle
        $('#staffToggle').click(function(){
         $('#staff-body').toggle();
       });
       // student toggle
       $('#studentToggle').click(function(){
         $('#student-body').toggle();
       });
        //teacher toggle
       $('#teacherToggle').click(function(){
           $('#teacher-body').toggle();
         });
          
         //adding teacher
          $('#assignTeacher').on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var staffId = $('#staffName').val();
            var staffName = $('#staffName option:selected').text();
            var classId = $('#className').val();
            var teacherRole= $('#teacherRole').val();
            var value = {
             "staffId" : staffId,
             "classId": classId,
             "staffName": staffName,
             "teacherRole": teacherRole,
             "_token": token,
            }
            $.ajax({
               type: "POST",
               url: "/deschool/add-teacher",
               data: value,
            }).done(function(result){
              if (result.success=='success'){
                $("#teacher-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.success=='danger'){
                $("#teacher-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
               setTimeout(function(){
                location.reload();
               }, 6000);               
              }
            });
          });
          
          //updating teacher
          $('.updateTeacher').on('click', function(){
          var updatTeacher = $(this).attr('id');
            updatTeacher = updatTeacher.split(' ');
           $('.updat_teacher').attr('id', 'updat_teacher'+updatTeacher[1])
           $('#updat_teacher'+updatTeacher[1]).on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var staffId = $('#staffId').text();
            var classA = $('.classNameA').val();
            var teacherRole= $('.teacherRole').val();
            alert(classA);
            var values = {
             "staffId" : staffId,
             "classId": classA,
             "teacherRole": teacherRole,
             "_token": token,
            }
            $.ajax({
               type: "POST",
               url: "/deschool/update-teacher",
               data: values,
            }).done(function(result){
              if (result.success=='success'){
                $('#confirm-delete').modal('hide');
                $("#teacher-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.success=='fail'){
                  $("#teacher-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
               setTimeout(function(){
                location.reload();
               }, 6000);                  
              }
            });
           });
          });
          
          //deleting teacher
          $('.deleteTeacher').on('click', function(){
          var delTeacher = $(this).attr('id');
            delTeacher = delTeacher.split(' ');
           $('.del_teacher').attr('id', 'del_teacher'+delTeacher[1])
           $('#del_teacher'+delTeacher[1]).on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            value= {
             "teacherId": delTeacher[1],
             "_token": token,
            }
            $.ajax({
               type: "DELETE",
               url: "/deschool/delete-teacher/"+delTeacher[1],
               data: value,
            }).done(function(result){
              if (result.success=='success'){
                $('#confirm-delete').modal('hide');
                $("#teacher-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.success=='fail'){
                  $("#teacher-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
               setTimeout(function(){
                location.reload();
               }, 6000);                  
              }
            });
           });
          }); 

          //subject toggle
          $('#subjectToggle').click(function(){
           $('#subject-body').toggle();
         });      
          $('#createSubject').on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var subject = $('#subject').val();
            var date= $('#date').val();
            var values = {
             "subject" : subject,
             "date": date,
             "_token": token,
            }
            
            $.ajax({
               type: "POST",
               url: "/deschool/add-subject",
               data: values,
            }).done(function(result){
              if (result.success=='success'){
                $("#subject-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.success=='danger'){
                $("#subject-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
               setTimeout(function(){
                location.reload();
               }, 6000);               
              }
            });
          });

          // edit parent toggle
          $('#editParentToggle').click(function(){
            $('#edit-parent-body').toggle();
          }); 
       
        // edit staff toggle
        $('#editStaffToggle').click(function(){
          $('#edit-staff-body').toggle();
        });  

        //edit student toggle
        $('#editStudentToggle').click(function(){
         $('#edit-student-body').toggle();
       }); 
       
       // toggle general settings

       $('#settingsToggle').click(function(){
           $('#settings-body').toggle();
         }); 
         // Create subject
          $('.help-block').remove(); 
          $('.class-subject-group').removeClass('text-danger');
          $('.date-group').removeClass('text-danger');
          $('#createSubject').on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var subject = $('#subject').val();
            var date= $('#date').val();
            var value = {
             "subject" : subject,
             "date": date,
             "_token": token,
            }
            
            $.ajax({
               type: "POST",
               url: "/deschool/add-subject",
               data: value,
            }).done(function(result){
              if (result.success=='success'){
                $("#settings-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.subject=='danger'){
               $(".class-subject-group").addClass('text-danger');
               $('.class-subject-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.date=='danger'){
                  $(".date-group").addClass('text-danger');
                  $('.date-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.failure=='danger'){
                $("#settings-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
               setTimeout(function(){
                location.reload();
               }, 6000);               
              }
            });
          })

          //create class
          $('.help-block').remove(); 
          $('.class-group').removeClass('text-danger');
          $('.class-date-group').removeClass('text-danger');          
          $('#createClass').on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var classes = $('#class').val();
            var date= $('#classDate').val();
            var value = {
             "class" : classes,
             "date": date,
             "_token": token,
            }
            $.ajax({
               type: "POST",
               url: "/deschool/add-class",
               data: value,
            }).done(function(result){
              if (result.success=='success'){
                $("#settings-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.class=='danger'){
               $(".class-group").addClass('text-danger');
               $('.class-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.date=='danger'){
                  $(".class-date-group").addClass('text-danger');
                  $('.class-date-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.failure=='danger'){
                $("#settings-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
               setTimeout(function(){
                location.reload();
               }, 6000);               
              }
            });
          })

          // number of periods
          $('.help-block').remove(); 
          $('.period-group').removeClass('text-danger');
          $('.period-date-group').removeClass('text-danger');          
          $('#createPeriod').on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            var period = $('#period').val();
            var date= $('#periodDate').val();
            var values = {
             "period" : period,
             "date": date,
             "_token": token,
            }
            
            $.ajax({
               type: "POST",
               url: "/deschool/add-period",
               data: values,
            }).done(function(result){
              if (result.success=='success'){
                $("#settings-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
               setTimeout(function(){
                location.reload();
               }, 6000);
              }else if(result.period=='danger'){
               $(".period-group").addClass('text-danger');
               $('.period-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.date=='danger'){
                  $(".period-date-group").addClass('text-danger');
                  $('.period-date-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.failure=='danger'){
                $("#settings-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
               setTimeout(function(){
                location.reload();
               }, 6000);               
              }
            });
          });   
           
          //memo toggle
          $('#memoToggle').click(function(){
            $('#memo-body').toggle();
          });
          $('#settingsInformationToggle').click(function(){
            $('#settings-information-body').toggle();
          }); 

       // setting privilege toggle
       $('#settingsPrivilegeToggle').click(function(){
         $('#settings-privilege-body').toggle();
       });
         
        //setting of privilege
        $('.help-block').remove(); 
        $('.privilege-group').removeClass('text-danger');
        $('.staff-group').removeClass('text-danger');
           
        $('#privilege').on('click', function(){
         
          $('.yesPrivilege').on('click', function(){
          $('.privilege-group').removeClass('text-danger');
          $('.staff-group').removeClass('text-danger');
          $('.help-block').remove();            
          var token =$("meta[name='csrf-token']").attr("content");
          var privilege = $('#privilegeType').val();
          var staffEmail= $('#staffName').val();
          var values = {
            "privilege" : privilege,
            "staffEmail": staffEmail,
            "_token": token,
          }
          $.ajax({
              type: "POST",
              url: "/deschool/privilege",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $('#privilegeRegister').hide('fast');
              $("#settings-privilege-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.staff=='danger'){
                $('.staff-group').addClass('text-danger');
                $('.staff-group').append("<div class='help-block'>" +result.message+"</div>");
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }else if(result.privilege=='danger'){
                $('.privilege-group').addClass('text-danger');
                $(".privilege-group").append("<div class='help-block'>" +result.message+"</div>");
                setTimeout(function(){
                    location.reload();
                  }, 3000);   
            }else if(result.success=='danger'){
              $('#privilegeRegister').hide('fast');
              $("#settings-privilege-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 3000);               
            }
          });
        });      
      });       
      $('.setRead').on('change', function(){
        var token =$("meta[name='csrf-token']").attr("content");
        var read;
        if ($(this).prop("checked")== true) {
              read = $(this).val();
            if ( $('.setRead').attr('data-target') =="#enable") {
              $('.setRead').attr('data-target','#disable');
            }
            
            $('.disable').on('click', function(){
              
              var values = {
                "read" : read,
                "_token": token,
              }
              
              $.ajax({
                  type: "POST",
                  url: "/deschool/Enable/settings-information",
                  data: values,
              }).done(function(result){
                if (result.success=='success'){
                  $('#disable').hide('fast')
                  $("#settings-privilege-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
                  setTimeout(function(){
                  location.reload();
                  }, 6000);
                }else if(result.success=='danger'){
                  $('#disable').hide('fast')
                  $("#settings-privilege-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
                  setTimeout(function(){
                  location.reload();
                  }, 6000);               
                }
              });
            });
        }else if($(this).prop("checked")== false){
            if ( $('.setRead').attr('data-target') =="#disable") {
              $('.setRead').attr('data-target','#enable');
            }
            $('.enable').on('click', function(){  
              read ="off";
              var values = {
                "read" : read,
                "_token": token,
              }
              $.ajax({
                  type: "POST",
                  url: "/deschool/Enable/settings-information",
                  data: values,
              }).done(function(result){
                if (result.success=='success'){
                $('#enable').hide('fast');
                  $("#settings-privilege-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
                  setTimeout(function(){
                  location.reload();
                  }, 6000);
                }else if(result.success=='danger'){
                  $('#enable').hide('fast')
                  $("#settings-privilege-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
                  setTimeout(function(){
                  location.reload();
                  }, 6000);               
                }
              });
            });
        }
      });

      // staff register toggle
      $('#staffRegisterToggle').click(function(){
         $('#staff-register-body').toggle();
       });

       //register staff
      $('#registerStaff').on('click', function(e){
        $('.staff-group').removeClass('text-danger');
        $('.time-group').removeClass('text-danger');
        $('.date-group').removeClass('text-danger');
        $('.help-block').remove();
        e.preventDefault();
        var token =$("meta[name='csrf-token']").attr("content");
        var staffName = $('#staffName').val();
        var registerDate= $('#registerDate').val();
        var registerTime= $('#registerTime').val();
        var values = {
          "staffName" : staffName,
          "registerDate" : registerDate,
          "registerTime" : registerTime,
          "_token": token,
        }
        
        $.ajax({
            type: "POST",
            url: "/deschool/staff-register",
            data: values,
        }).done(function(result){
          if (result.success=='success'){
            $("#staff-register-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
            setTimeout(function(){
            location.reload();
            }, 6000);
          }else if(result.staff=='danger'){
              $('.staff-group').addClass('text-danger');
              $('.staff-group').append("<div class='help-block'>" +result.message+"</div>");                              
          }else if(result.time=='danger'){
              $('.time-group').addClass('text-danger');
              $(".time-group").append("<div class='help-block'>" +result.message+"</div>");                              
          }else if(result.date=='danger'){
              $('.date-group').addClass('text');
              $(".date-group").append("<div class='help-block'>" +result.message+"</div>");                              
          }else if(result.success=='true'){
              $("#registerStaff").attr("disable");
              $("#staff-register-body").prepend("<div class='status alert alert-danger text-center col-sm-12 '><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
            setTimeout(function(){
            location.reload();
            }, 6000);                  
          }
        });
      });

       // student register toggle
       $('#studentRegisterToggle').click(function(){
         $('#student-register-body').toggle();
       });     
       //register student
       $('#registerStudent').on('click', function(e){
        $('.student-group').removeClass('text-danger');
        $('.time-group').removeClass('text-danger');
        $('.date-group').removeClass('text-danger');
        $('.help-block').remove();
        e.preventDefault();
        var token =$("meta[name='csrf-token']").attr("content");
        var studentName = $('#studentName').val();
        var registerDate= $('#registerDate').val();
        var registerTime= $('#registerTime').val();
        var values = {
          "studentName" : studentName,
          "registerDate" : registerDate,
          "registerTime" : registerTime,
          "_token": token,
        }
        
        $.ajax({
            type: "POST",
            url: "/deschool/students-register",
            data: values,
        }).done(function(result){
          if (result.success=='success'){
            $("#student-register-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
            setTimeout(function(){
            location.reload();
            }, 6000);
          }else if(result.student=='danger'){
              $('.student-group').addClass('text-danger');
              $('.student-group').append("<div class='help-block'>" +result.message+"</div>");                              
          }else if(result.time=='danger'){
              $('.time-group').addClass('text-danger');
              $(".time-group").append("<div class='help-block'>" +result.message+"</div>");                              
          }else if(result.date=='danger'){
              $('.date-group').addClass('text');
              $(".date-group").append("<div class='help-block'>" +result.message+"</div>");                              
          }else if(result.success=='true'){
              $("#registerStudent").attr("disable");
              $("#student-register-body").prepend("<div class='status alert alert-danger text-center col-sm-12 '><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
            setTimeout(function(){
            location.reload();
            }, 6000);                  
          }
        });
      });      
        // toggle student
      $('#updateToggle').click(function(){
        $('#update-body').toggle();
      });
      $('.register').on('click', function(e){
        // e.preventDefault();
        var token =$("meta[name='csrf-token']").attr("content");
        var read;
        var id =$(this).attr('id');
        //alert(id);
        //document.getElementById(id).checked ='checked';            
        $('input.register:checkbox:checked').each(function(){
          //alert($(this).attr('id'));
          var id =$(this).attr('id');
          alert(id);
          alert($(this).val());
          //$('#'+id).attr('checked', 'checked')
        });
        //read = $('.register').attr('id');
        //alert( read);
        $('.disable').on('click', function(){
          var values = {
            "read" : read,
            "_token": token,
          }
          
          $.ajax({
              type: "POST",
              url: "/deschool/students-registers",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $('#disable').hide('fast')
              $("#update-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.success=='danger'){
              $('#disable').hide('fast')
              $("#update-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });

         
        }); 
      });

        //send memo;
          $('.memo-message').hide('fast');
          $('.sender-group').hide('fast');
          $('.subject-group').hide('fast');
          $('.email-group').hide('fast');
          $('.message-group').hide('fast');
          $('.memo-message').empty();
          $('.sender-group').empty();
          $('.subject-group').empty();
          $('.email-group').empty();
          $('.message-group').empty();          
        $('#send-memo').on('click', function(){
        
          var token =$("meta[name='csrf-token']").attr("content");
          var sender = $('#sender').val();
          var subject = $('#subject').val();
          var message = $('#message').val();
          var email = $('#staffEmail').val();
          var values = {
            "sender" : sender,
            "subject" : subject,
            'message' : message,
            "email" : email,
            "_token": token,
          }
          
          $.ajax({
              type: "POST",
              url: "/deschool/send-memo",
              data: values,
          }).done(function(result){
            if (result.sender=='danger'){
              $('.sender-group').show('fast')
              $('.sender-group').prepend(result.sender_message); 
            }else if (result.subject=='danger'){
              $('.subject-group').show('fast')
              $('.subject-group').prepend(result.subject_message); 
            }else if(result.email=='danger'){
              $('.email-group').show('fast')
              $('.email-group').prepend(result.email_message);                              
            }else if(result.mess=='danger'){
              $('.message-group').show('fast')
              $('.message-group').prepend(result.mess_message);               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }else if (result.result=='success'){
              $('.memo-message').show('fast')
              $('.memo-message').prepend("<div class='offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert alert-success alert-dismissable text-center success-message' style='margin-top:20px'><a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a><strong> success </strong>"+result.message+"</div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if (result.result=='danger'){
              $('.memo-message').show('fast')
              $('.memo-message').prepend("<div class='offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert alert-danger alert-dismissable text-center success-message' style='margin-top:20px'><a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a><strong> Danger </strong>"+result.message+"</div>");
              setTimeout(function(){
              location.reload();
              }, 6000); 
            }
          });

         
        });      
      // toggle for parent table
      $('#viewParentsToggle').click(function(){
           $('#view-parents-body').toggle();
      });
      // delete of parent
      $('.deleteParent').on('click', function(){
      var delParent = $(this).attr('id');
        delParent = delParent.split(' ');
        $('.del_parent').attr('id', 'del_parent'+delParent[1])
        $('#del_parent'+delParent[1]).on('click', function(){
        var token =$("meta[name='csrf-token']").attr("content");
        values= {
          "parentId": delParent[1],
          "_token": token,
        }
        $.ajax({
            type: "DELETE",
            url: "/deschool/delete-parent/"+delParent[1],
            data: values,
        }).done(function(result){
          if (result.success=='success'){
            $('#confirm-delete').modal('hide');
            $("#view-parents-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
            setTimeout(function(){
            location.reload();
            }, 6000);
          }else if(result.success=='fail'){
              $("#view-parents-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
            setTimeout(function(){
            location.reload();
            }, 6000);                  
          }
        });
        });
      });
      
      // toggle staff view table
      $('#viewStaffsToggle').click(function(){
           $('#view-staffs-body').toggle();
      });      
      $('.deleteStaff').on('click', function(){
      var delStaff = $(this).attr('id');
        delStaff = delStaff.split(' ');
        $('.del_staff').attr('id', 'del_staff'+delStaff[1])
        $('#del_staff'+delStaff[1]).on('click', function(){
        var token =$("meta[name='csrf-token']").attr("content");
        values= {
          "staffId": delStaff[1],
          "_token": token,
        }

        // delete staff
        $.ajax({
            type: "DELETE",
            url: "/deschool/delete-staff/"+delStaff[1],
            data: values,
        }).done(function(result){
          if (result.success=='success'){
            $('#confirm-delete').modal('hide');
            $("#view-staffs-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
            setTimeout(function(){
            location.reload();
            }, 6000);
          }else if(result.success=='fail'){
              $("#view-staffs-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
            setTimeout(function(){
            location.reload();
            }, 6000);                  
          }
        });
        });
      });
      
      //toggle student view table
      $('#viewStudentsToggle').click(function(){
           $('#view-students-body').toggle();
      });    
      
      //delete student 
      $('.deleteStudent').on('click', function(){
      var delStudent = $(this).attr('id');
        delStudent = delStudent.split(' ');
        $('.del_student').attr('id', 'del_student'+delStudent[1]);
        $('#del_student'+delStudent[1]).on('click', function(){
        var token =$("meta[name='csrf-token']").attr("content");
        values= {
          "studentId": delStudent[1],
          "_token": token
        }
        $.ajax({
            type: "DELETE",
            url: "/deschool/delete-student/"+delStudent[1],
            data: values,
        }).done(function(result){
          if (result.success=='success'){
            $('#confirm-delete').modal('hide');
            $("#view-students-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
            setTimeout(function(){
            location.reload();
            }, 6000);
          }else if(result.success=='fail'){
              $('#confirm-delete').modal('hide');
              $("#view-students-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
            setTimeout(function(){
            location.reload();
            }, 6000);                  
          }
        });
        });
      });  
    
      $('#dataTableStaff').DataTable(); 

      $('#dataTableTeacher').DataTable();
      
      $('#dataTableParent').DataTable(); 

      $('#dataTableStaffRegister').DataTable();
      
      $('#dataTableStudent').DataTable();

      $('#dataTableStudentRegister').DataTable();

      $('#staffEmail').multiselect({
        enableHTML: true
      });
   }); 
     
   
  </script>
    <style>
     i#close, #time{
      display: inline-block;
      border-radius: 60px;
      box-shadow: 1px 1px 1px #888;
      padding: 0.5em 0.6em;
     }
     label, btn{
      display: inline-block;
      border-radius: 6px;
      box-shadow: 1px 1px rgb(0, 0, 0, 0.1);
      padding: 0.5em 0.6em;
     }
     th{
      border-top: 6px solid #36b9cc !important;
      border-bottom: 2px solid #36b9cc !important;
      font-weight: 600 !important;
      text-align:center;
      }
      td{
         font-size: .85rem !important;
      }
      tr:hover{
        color: #36b9cc;
      }      
      .table-redesign{
        border-radius: 20px !important;
        border-bottom: 2px solid #36b9cc !important;
      }
     .paginate-btn{
        margin: 2px;
      }
     .paginate-btn{
        margin: 2px;
      }
      .img-rounded{
     border: 1px solid #E74A3B;
     border-left: 10px solid #E74A3B;
     border-right: 10px solid #E74A3B;
     /*background-color: #E74A3B;*/
      border-radius: 5px !important;   
     }   
     .services{
         margin-left: 5px;
      }    
      @media (max-width: 986px) {
        .d-form {
            text-align: center !important; 
            width:70% !important; 
            margin:auto !important; 
            background-color:red !important; 
        }
    }
 /* @media (min-width: 600px) and (max-width: 986px) {
    .d-form  {
      background-color:red !important;
    }
}*/
    </style>  
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/deschool/dashboard">
        <div class="sidebar-brand-icon">
          <img src="{{asset('my-register/img/icon.jpg')}}" width="25" height="25" style="border-radius:100%;">
        </div>
        <div class="sidebar-brand-text mx-3"> The School </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/deschool/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSchool" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog fa-spin text-gray-400"></i>
          <span>School Settings</span>
        </a>
        <div id="collapseSchool" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">School Settings:</h6>
              @if(Auth::user()->isAdmin())
                <a class="collapse-item" href="/deschool/info-settings">Information Update</a>
                <a class="collapse-item" href="/deschool/profile">Profile</a>                   
                <a class="collapse-item" href="/deschool/priv-settings">Privilege</a>            
                <a class="collapse-item" href="/deschool/send-memo">Send Memo</a>
             @elseif(Auth::user()->isMember())
              <a class="collapse-item" href="/deschool/profile">Profile</a> 
             @endif                
          </div>
        </div>
      </li>
      <!-- Divider -->
    @if(Auth::user()->isAdmin())  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Staffs</span>
        </a>
        <div id="collapseStaff" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Staffs:</h6>
            <a class="collapse-item" href="/deschool/add-staff">Add New Staff</a>
            <a class="collapse-item" href="/deschool/view-staffs">View Staffs Table</a>
            <a class="collapse-item" href="/deschool/staff-register"> Staffs Register</a>       
          </div>
        </div>
      </li>
    @endif    
  <!-- Divider -->
     
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Teachers</span>
        </a>
        <div id="collapseTeachers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Teachers</h6>
            @if(Auth::user()->isMember())
            <a class="collapse-item" href="/deschool/teacher">Teacher Register</a>
            @elseif(Auth::user()->isAdmin())
            <a class="collapse-item" href="/deschool/teacher"> Add Teacher</a>
            <div class="collapse-divider"></div>
            <!--<h6 class="collapse-header">Others:</h6>-->
            @endif    
          </div>
        </div>
      </li>
      <!-- Divider -->
    @if(Auth::user()->isAdmin())  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-handshake text-gray-400"></i>
          <span>Parents</span>
        </a>
        <div id="collapseParents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Parents</h6>
            <a class="collapse-item" href="/deschool/add-parent">Add New Parent</a>          
            <a class="collapse-item" href="/deschool/view-parents">View Parent Table</a>
          </div>
        </div>
      </li>
       
      <!-- Divider -->  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseStudents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Students</span>
        </a>
        <div id="collpaseStudents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Students:</h6>
            <a class="collapse-item" href="/deschool/add-student"> Add New Student</a>
            <a class="collapse-item" href="/deschool/view-students">View Students Table</a>
            <a class="collapse-item" href="/deschool/students-register"> Students Register</a>                                          
          </div>
        </div>
      </li> 
      <!-- Divider -->  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseSubject" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Subject</span>
        </a>
        <div id="collpaseSubject" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Subject:</h6>
            <a class="collapse-item" href="/deschool/add-subject"> Add Subject</a>
            <a class="collapse-item" href="/deschool/select-subject">Select Subject</a> 
          </div>
        </div>
      </li>
      <!-- Divider -->  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseResult" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Result Aggregator</span>
        </a>
        <div id="collpaseResult" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Result Aggregator:</h6>
            <a class="collapse-item" href="/deschool/add-student"> Aggregate Result</a>
            <a class="collapse-item" href="/deschool/view-students">Result Table</a>  
            <a class="collapse-item" href="/deschool/view-students">Check Result</a>                       
          </div>
        </div>
      </li> 
      <!-- Divider -->
      
     <hr class="sidebar-divider">

      <!-- Heading -->
     <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinances" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-credit-card text-gray-400"></i>
          <span>Payment</span>
        </a>
        <div id="collapseFinances" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Payment:</h6>
            <a class="collapse-item" href="buttons.html">Payment</a>           
          </div>
        </div>
      </li>
      <!-- Divider -->  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseLibrary" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Library</span>
        </a>
        <div id="collpaseLibrary" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Library:</h6>
            <a class="collapse-item" href="404.html">Books</a>            
            <a class="collapse-item" href="404.html">Assign Book</a>
            <a class="collapse-item" href="blank.html">Book Assign To Students</a>              
          </div>
        </div>
      </li>       
      <!-- Divider -->
      <!--<hr class="sidebar-divider">-->

      <!-- Heading -->
      <!--<div class="sidebar-heading">
        Addons
      </div> -->   
      <!-- Nav Item - Pages Collapse Menu -->
      <!--<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-credit-card text-gray-400"></i>
          <span>Make Payment</span>
        </a>
        <div id="collapsePayment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Make Payment:</h6>
            <a class="collapse-item" href="buttons.html"> School Fees</a>
            <a class="collapse-item" href="cards.html">School Bus</a>
            <a class="collapse-item" href="cards.html">Stationaries</a>
            <a class="collapse-item" href="cards.html">Party And Excusion</a>
            <a class="collapse-item" href="cards.html">View Payment Table</a>            
          </div>
        </div>
      </li>-->
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubject" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book text-gray-400"></i>
          <span>General Settings</span>
        </a>
        <div id="collapseSubject" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">General Settings:</h6>
            <a class="collapse-item" href="/deschool/general-settings">General Settings</a>
            <a class="collapse-item" href="/deschool/assign-subject">Assign Subject</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <!--<hr class="sidebar-divider">-->

      <!-- Heading -->
      <!--<div class="sidebar-heading">
        Addons
      </div>-->      
      <!-- Nav Item - Pages Collapse Menu -->
      <!--<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLibrary" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-building text-gray-400"></i>
          <span>Library</span>
        </a>
        <div id="collapseLibrary" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Library:</h6>
            <a class="collapse-item" href="buttons.html">Add New books</a>
            <a class="collapse-item" href="cards.html">View Books</a>
            <a class="collapse-item" href="cards.html"> Assign Book</a>            
          </div>
        </div>
      </li>-->
      <!-- Divider -->
      <!-- <hr class="sidebar-divider">-->

      <!-- Heading -->
      <!--<div class="sidebar-heading">
        Addons
      </div>-->     
      <!-- Nav Item - Pages Collapse Menu -->
      <!--<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKitchen" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-briefcase text-gray-400"></i>
          <span>Others</span>
        </a>
        <div id="collapseKitchen" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kitchen:</h6>
            <a class="collapse-item" href="buttons.html">Add Material</a>
            <a class="collapse-item" href="cards.html">View Material</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Equipment:</h6>
            <a class="collapse-item" href="404.html">Add Equipment</a>
            <a class="collapse-item" href="blank.html">View Equipment</a>         
          </div>
        </div>
      </li>-->
    @endif    
      <!-- Nav Item - Charts -->
      <!--<li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>-->

      <!-- Nav Item - Tables -->
      <!--<li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link" href="{{url('/deschool/logout')}}" onclick="event.preventDefault();
       document.getElementById('logout-form').submit()">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Logout</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <span class="bg-danger" id="time" style="padding:8px;color:white;border-radius:3px"></span>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
                
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     @if(Auth::user()->isAdmin())
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$schoolInformation->school_name !== null || $schoolInformation->school_name != '' ? ucfirst($schoolInformation->school_name) : ucfirst($userEmail) }}</span>
             @elseif(Auth::user()->isMember())
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucfirst($userEmail) }}</span>
             @endif
                  
                <img class="img-profile rounded-circle" src="{{$schoolInformation->school_profile_image !== null || $schoolInformation->school_profile_image !='' ? url('uploads/'.$schoolInformation->school_profile_image) : asset('my-register/img/The-Register.jpg') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/deschool/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="/deschool/info-settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/deschool/logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        @yield('content')

     <!-- Footer -->
     <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; The School {{$date}}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('my-register/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('my-register/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('my-register/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('my-register/js/sb-admin-2.min.js')}}"></script>
   <script> window.onload=dateTime();</script>    
  <!-- Page level plugins -->
  <script src="{{asset('my-register/vendor/chart.js/Chart.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('jqueryTimePicker/jquery.timepicker.min.js')}}"></script>
  <!-- Page level custom scripts -->
  <script src="{{asset('my-register/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('my-register/js/demo/chart-pie-demo.js')}}"></script>
  <script src="{{asset('my-register/js/jquery.dataTables.min.js')}}"></script> 
  <script src="{{asset('my-register/js/bootstrap-multiselect.min.js')}}"></script> 
    <form id='logout-form' action="{{url('/deschool/logout')}}"
    method="POST" style='display:none'>
        {{csrf_field()}}
    </form>
</body>

</html>
