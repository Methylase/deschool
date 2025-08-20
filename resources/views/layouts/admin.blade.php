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
  <link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{asset('admin/img/icon.jpg')}}"  sizes ="25x25"> 
  <!-- Custom styles for this template-->
  <link href="{{asset('jqueryTimePicker/jquery.timepicker.min.css')}}" rel="stylesheet"> 
  <link href="{{asset('admin/css/jquery.dataTables.min.css')}}" rel="stylesheet"> 
  <link href="{{asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{asset('admin/css/bootstrap-multiselect.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
  <script src="{{asset('jqueryTimePicker/jquery.timepicker.min.js')}}"></script> 
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script> 


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
        $('#registerTime').timepicker({
          interval:1,
          dropdown: true,
          defaultTime: '12',
          scrollbar: true
        });
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
              url: "/add-teacher",
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
          var token =$("meta[name='csrf-token']").attr('content');
          var staffId = $('#staffId').attr('val-id');
          var staffName = $('#staffId').text();
          var classA = $('.classNameA').val();
          var teacherRole= $('.teacherRole').val();
          var values = {
            "staffId" : staffId,
            "staffName" : staffName,
            "classId": classA,
            "teacherRole": teacherRole,
            "_token": token,
          }
          $.ajax({
              type: "POST",
              url: "/update-teacher",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $('#confirm-update').modal('hide');
              $(".teacher-update").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.failure=='danger'){
                $(".teacher-update").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
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
              url: "/delete-teacher/"+delTeacher[1],
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
          $('.help-block').remove(); 
          $('.class-subject-group').removeClass('text-danger');
          $('.class-department-group').removeClass('text-danger');
          $('.date-group').removeClass('text-danger');            
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
              url: "/add-subject",
              data: values,
          }).done(function(result){
            
              if (result.success=='success'){
                $("#subject-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
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
              url: "/add-subject",
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
        
        $('#createClass').on('click', function(){
          $('.help-block').remove(); 
          $('.class-group').removeClass('text-danger');
          $('.class-date-group').removeClass('text-danger');            
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
              url: "/add-class",
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
        $('#createPeriod').on('click', function(){
          $('.help-block').remove(); 
          $('.period-group').removeClass('text-danger');
          $('.period-date-group').removeClass('text-danger');             
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
              url: "/add-period",
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
        $('#privilege').on('click', function(){
          $('.help-block').remove(); 
          $('.privilege-group').removeClass('text-danger');
          $('.staff-group').removeClass('text-danger');          
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
              url: "/privilege",
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



        //creating of academic calender terms
        $('#createTerm').on('click', function(){
          $('.help-block').remove(); 
          $('.term-group').removeClass('text-danger');
          $('.session-group').removeClass('text-danger');          
          $('.yesTerm').on('click', function(){
          $('.term-group').removeClass('text-danger');
          $('.session-group').removeClass('text-danger');
          $('.help-block').remove();            
          var token =$("meta[name='csrf-token']").attr("content");
          var term = $('#term option:selected').val();
          var term_name = $('#term option:selected').text();
          var session= $('#session').val();
          var values = {
            "term" : term,
            "term_name" : term_name,
            "session": session,
            "_token": token,
          }
          $.ajax({
              type: "POST",
              url: "/academic_session",
              data: values,
          }).done(function(result){
              if (result.success=='success'){
                $('#academic_session').hide('fast');
                $("#academic-session").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
                setTimeout(function(){
                location.reload();
                }, 6000);
              }else if(result.term=='danger'){
                  $('.term-group').addClass('text-danger');
                  $('.term-group').append("<div class='help-block'>" +result.message+"</div>");
                  setTimeout(function(){
                      location.reload();
                  }, 3000);
              }else if(result.session=='danger'){
                  $('.session-group').addClass('text-danger');
                  $(".session-group").append("<div class='help-block'>" +result.message+"</div>");
                  setTimeout(function(){
                      location.reload();
                    }, 3000);   
              }else if(result.failure=='danger'){
                $('#academic_session').hide('fast');
                $("#academic-session").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
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
                  url: "/Enable/settings-information",
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
                  url: "/Enable/settings-information",
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
              url: "/staff-register",
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
              url: "/students-register",
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
                url: "/students-registers",
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
              url: "/send-memo",
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
              url: "/delete-parent/"+delParent[1],
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
              url: "/delete-staff/"+delStaff[1],
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
              url: "/delete-student/"+delStudent[1],
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

        // assign subject
        $('#assignSubject').on('click', function(){
          $('.help-block').remove(); 
          $('.teacher-name-group').removeClass('text-danger');
          $('.subject-name-group').removeClass('text-danger');            
            var token =$("meta[name='csrf-token']").attr("content");
          var teacher = $('#teacher-name').val();
          var teacher_name = $('#teacher-name option:selected').text();
          var subject= $('#subject-name').val();
          var subject_name= $('#subject-name option:selected').text();
          var values = {
            "teacher" : teacher,
            "teacher_name" : teacher_name,
            "subject" : subject,
            "subject_name" : subject_name,
            "_token": token,
          }
          
          $.ajax({
              type: "POST",
              url: "/assign-subject",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#subject-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.teacher=='danger'){
              $(".teacher-name-group").addClass('text-danger');
              $('.teacher-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.subject=='danger'){
                $(".subject-name-group").addClass('text-danger');
                $('.subject-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#subject-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });   

        // toggle select subject view table
        $('#selectSubjectToggle').click(function(){
          $('#select-subject-body').toggle();
        });
        $('#condition').click(function(){
          if($('#condition').prop('checked') ==true){
            $('.senior').css('display','block');
            //$('.not-senior').css('display','hidden');
          }else{
            //$('.not-senior').css('display','block');
            $('.senior').css('display','none');
          }
        });
         
        $('#selectSubject').on('click', function(){
          $('.help-block').remove(); 
          $('.class-name-group').removeClass('text-danger');
          $('.student-name-group').removeClass('text-danger');
          $('.subject-name-group').removeClass('text-danger'); 
          $('.department-name-group').removeClass('text-danger');  
            
            var token =$("meta[name='csrf-token']").attr("content");
            var class_id = $('#class-name option:selected').val();
            var class_name = $('#class-name option:selected').text();            
            var student = $('#student-name option:selected').val();
            var student_name = $('#student-name option:selected').text();
            var subject= $('#subject-name option:selected').val();
            var subject_name= $('#subject-name option:selected').text();
            var condition = $('#condition').val();
            if(condition == 'on'){
              var department = $('#student-name option:selected').val();
              var department_name = $('#department-name option:selected').text();              
            }else{
              condition == '';
              var department = '';
              var department_name = ''; 
            }


          var values = {
            "class" : class_id,
            "class_name" : class_name,            
            "student" : student,
            "student_name" : student_name,
            "subject" : subject,
            "subject_name" : subject_name,
            "condition" : condition,
            "department" : department,
            "department_name" : department_name,
            "_token": token,
          }
              
          $.ajax({
              type: "POST",
              url: "/select-subject",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#select-subject-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.class=='danger'){
              $(".class-name-group").addClass('text-danger');
              $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.subject=='danger'){
                $(".subject-name-group").addClass('text-danger');
                $('.subject-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.department=='danger'){
                $(".class-department-group").addClass('text-danger');
                $('.class-department-group').append("<div class='help-block'>" +result.message+"</div>");
              }else if(result.failure=='danger'){
              $("#select-subject-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });   

        // toggle add stationeries table
        $('#stationaryToggle').click(function(){
          $('#stationary-body').toggle();
        });

        $('#addStationary').on('click', function(){
          $('.help-block').remove(); 
          $('.stationary-group').removeClass('text-danger');
          $('.status-group').removeClass('text-danger');   
          $('.quantity-group').removeClass('text-danger');
          $('.amount-group').removeClass('text-danger'); 
            var token =$("meta[name='csrf-token']").attr("content");
            var name = $('#stationary').val();
            var status = $('#status option:selected').val();
            var quantity= $('#quantity').val();
            var amount= $('#amount').val();
            var values = {
              "name" : name,
              "status" : status,
              "quantity" : quantity,
              "amount" : amount,
              "_token": token,
            }
            
          $.ajax({
              type: "POST",
              url: "/stationeries",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#stationary-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.stationary=='danger'){
              $(".stationary-group").addClass('text-danger');
              $('.stationary-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.status=='danger'){
                $(".status-group").addClass('text-danger');
                $('.status-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.quantity=='danger'){
                $(".quantity-group").addClass('text-danger');
                $('.quantity-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.amount=='danger'){
                $(".amount-group").addClass('text-danger');
                $('.amount-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#stationary-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });         

        // toggle assign book 
        $('#assignBookToggle').click(function(){
          $('#assign-book-body').toggle();
        });

        $('#assignBook').on('click', function(){
          $('.help-block').remove(); 
          $('.student-name-group').removeClass('text-danger');
          $('.book-name-group').removeClass('text-danger');     
          $('.condition-group').removeClass('text-danger');      
            var token =$("meta[name='csrf-token']").attr("content");
            var student = $('#student-name').val();
            var student_name = $('#student-name option:selected').text();
            var book= $('#book-name').val();
            var book_condition= $('#book-condition').val();
            var book_name= $('#book-name option:selected').text();
          var values = {
            "student" : student,
            "student_name" : student_name,
            "book" : book,
            "book_condition" : book_condition,
            "book_name" : book_name,
            "_token": token,
          }
              
          $.ajax({
              type: "POST",
              url: "/assign-book",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#assign-book-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.book=='danger'){
                $(".book-name-group").addClass('text-danger');
                $('.book-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.condition=='danger'){
                $(".condition-group").addClass('text-danger');
                $('.condition-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#assign-book-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });  
      
        //change status of the assign book
        $('.book-status').on('change', function(){
          var token =$("meta[name='csrf-token']").attr("content");
          var book_assigned_id = $(this).attr('id');
          var status = $('#'+book_assigned_id +  ' option:selected').val();
          values= {
            "book_id": book_assigned_id,
            "status": status,
            "_token": token
          }
          $.ajax({
              type: "POST",
              url: "/assign-status",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.failure=='danger'){
                $(".book").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });

        //submit book condition
        $('.book-condition').on('click', function(){

          var token =$("meta[name='csrf-token']").attr("content");
          var assign_id = $(this).find('input').attr('id');
          var condition_id = $(this).find('span').attr('id');
          var assign_id = $(this).find('input').attr('id');
          $('#'+condition_id).css('display','none');
          $('#'+assign_id).css('display','block');
          $('#'+assign_id).on('keypress', function(event){
            if (event.key === "Enter") {
              var book_condition = $('#'+assign_id).val();
              var book_assigned_id = assign_id.split("-",);
              book_assigned_id  = book_assigned_id[1];
              //var book_name = $('#name-'+book_assigned_id).text();
              values= {
                "book_id": book_assigned_id,
                "book_condition": book_condition,
                //"book_name" : book_name,
                "_token": token
              }
              $.ajax({
                  type: "POST",
                  url: "/book-condition",
                  data: values,
              }).done(function(result){
                if (result.success=='success'){
                  $('#'+condition_id).css('display','block');
                  $('#'+assign_id).css('display','none');                  
                  setTimeout(function(){
                  location.reload();
                  }, 6000);
                }else if(result.failure=='danger'){
                    $(".book").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
                  setTimeout(function(){
                  location.reload();
                  }, 6000);                  
                }
              });
            }
          });
        });


        // toggle assign book 
        $('#classStatusToggle').click(function(){
          $('#class-status-body').toggle();
        }); 

        //onchange of class to select student
        $('#class-name').on('change', function(){
          $("#student-name").empty().append('<option value="">Select-Student-Name</option>');
          var token =$("meta[name='csrf-token']").attr("content");
          var class_id = $('#class-name option:selected').val();;
          values= {
            "class_id": class_id,
            "_token": token
          }
          $.ajax({
              type: "POST",
              url: "/change-class",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
                 $("#student-name").append(result.options);
            }else if(result.failure=='danger'){
                $(".class-status-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });

        //onchange of class to select student
        $('#present-class').on('change', function(){
          $(".promotion").empty();
          $("#student").empty().append('<option value="">Select-Student-Name</option>');
          var token =$("meta[name='csrf-token']").attr("content");
          var class_id = $('#present-class option:selected').val();;
          values= {
            "class_id": class_id,
            "_token": token
          }
          $.ajax({
              type: "POST",
              url: "/change-class",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
                 $("#student").append(result.options);
            }else if(result.failure=='danger'){
                $(".promotion").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });        

        $('#saveStatus').on('click', function(){
          $('.help-block').remove(); 
          $('.student-name-group').removeClass('text-danger');
          $('.class-name-group').removeClass('text-danger');       
          $('.term-name-group').removeClass('text-danger');
          $('.year-group').removeClass('text-danger');                
            var token =$("meta[name='csrf-token']").attr("content");
            var student = $('#student-name option:selected').val();
            var student_name = $('#student-name option:selected').text();
            var class_id = $('#class-name option:selected').val();
            var class_name = $('#class-name option:selected').text();
            var term = $('#term-name option:selected').val();
            var term_name = $('#term-name option:selected').text()
            var year= $('#year').val();
          var values = {
            "student" : student,
            "student_name" : student_name,
            "class" : class_id,
            "class_name" : class_name,
            "term" : term,
            "term_name" : term_name,   
            "year" : year,
            "_token": token,
          }
              
          $.ajax({
              type: "POST",
              url: "/class-status",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#class-status-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.class=='danger'){
                $(".class-name-group").addClass('text-danger');
                $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.term=='danger'){
              $(".term-name-group").addClass('text-danger');
              $('.term-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.year=='danger'){
                $(".year-group").addClass('text-danger');
                $('.year-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#class-status-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });     


        $('#promoteStudent').on('click', function(){
          $('.help-block').remove(); 
          $('.student-group').removeClass('text-danger');
          $('.present-group').removeClass('text-danger');       
          $('.promote-group').removeClass('text-danger');                
            var token =$("meta[name='csrf-token']").attr("content");
            var student = $('#student option:selected').val();
            var student_name = $('#student option:selected').text();
            var class_present_id = $('#present-class option:selected').val();
            var class_present_name = $('#present-class option:selected').text();
            var class_promotion_id = $('#promote-class option:selected').val();
            var class_promotion_name = $('#promote-class option:selected').text();
          var values = {
            "student" : student,
            "student_name" : student_name,
            "class_present_id" : class_present_id,
            "class_present_name" : class_present_name,
            "class_promotion_id" : class_promotion_id,
            "class_promotion_name" : class_promotion_name,
            "_token": token,
          }
              
          $.ajax({
              type: "POST",
              url: "/student-promotion",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $(".promotion").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.class_present=='danger'){
                $(".present-group").addClass('text-danger');
                $('.present-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-group").addClass('text-danger');
              $('.student-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.class_promotion=='danger'){
              $(".promote-group").addClass('text-danger');
              $('.promote-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $(".promotion").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });                

        // toggle result estimator
        $('#resultEstimatorToggle').click(function(){
          $('#result-estimator-body').toggle();
        });     
        
        $('#add-estimator').on('click', function(){
          $('.help-block').remove(); 
          $('.estimator-group').removeClass('text-danger');
          $('.value-group').removeClass('text-danger');   
            var token =$("meta[name='csrf-token']").attr("content");
            var estimator_value = $('#estimator-value').val();
            var estimator_type = $('#estimator-type option:selected').val();
            var estimator_name = $('#estimator-type option:selected').text();
            var values = {
              "estimator_type" : estimator_type,
              "estimator_name" : estimator_name,
              "estimator_value" : estimator_value,
              "_token": token,
            }
            
          $.ajax({
              type: "POST",
              url: "/result-estimator",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#result-estimator-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.estimator=='danger'){
              $(".estimator-group").addClass('text-danger');
              $('.estimator-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.value=='danger'){
                $(".value-group").addClass('text-danger');
                $('.value-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#result-estimator-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });  
        
        // toggle record sales
        $('#recordSalesToggle').click(function(){
          $('#record-sales-body').toggle();
        });     
        
        $('#record-sales').on('click', function(){
          $('.help-block').remove(); 
          $('.student-group').removeClass('text-danger');
          $('.stationary-group').removeClass('text-danger'); 
          $('.quantity-group').removeClass('text-danger');
          $('.transaction-group').removeClass('text-danger');            
            var token =$("meta[name='csrf-token']").attr("content");
            var student = $('#student option:selected').val();
            var student_name = $('#student option:selected').text();
            var stationary = $('#stationary option:selected').val();
            var stationary_name = $('#stationary option:selected').text();
            var transaction = $('#transaction-type option:selected').val();
            var transaction_name = $('#transaction-type option:selected').text();            
            var quantity = $('#quantity').val();
            var values = {
              "student" : student,
              "student_name" : student_name,
              "stationary" : stationary,
              "stationary_name" : stationary_name,
              "transaction" : transaction,
              "transaction_name" : transaction_name,                            
              "quantity" : quantity,
              "_token": token,
            }
            
          $.ajax({
              type: "POST",
              url: "/record-sales",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#record-sales-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.reload();
              }, 6000);
            }else if(result.student=='danger'){
              $(".student-group").addClass('text-danger');
              $('.student-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.stationary=='danger'){
                $(".stationary-group").addClass('text-danger');
                $('.stationary-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.quantity=='danger'){
              $(".quantity-group").addClass('text-danger');
              $('.quantity-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.transaction=='danger'){
                $(".transaction-group").addClass('text-danger');
                $('.transaction-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#record-sales-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        });          
            
        // toggle sales order
        $('#resultAggregatorToggle').click(function(){
          $('#result-aggregator-body').toggle();
        }); 

        $('#saveResult').on('click', function(){
          $('.help-block').remove(); 
          $('.student-name-group').removeClass('text-danger');
          $('.class-name-group').removeClass('text-danger');       
          $('.term-name-group').removeClass('text-danger');
          $('.year-group').removeClass('text-danger');    
          $('.mark-group').removeClass('text-danger');   
          $('.subject-name-group').removeClass('text-danger'); 
          $('.mark-type-group').removeClass('text-danger');  
            var token =$("meta[name='csrf-token']").attr("content");
            var student_id = $('#student-name option:selected').val();
            var subject_id = $('#subject-name option:selected').val();
            var student_name = $('#student-name option:selected').text();
            var subject_name = $('#subject-name option:selected').text();
            var class_id = $('#class-name option:selected').val();
            var class_name = $('#class-name option:selected').text();
            var term = $('#term-name option:selected').val();
            var term_name = $('#term-name option:selected').text();
            var mark = $('#mark-name').val();
            var mark_type = $('#mark-type option:selected').val();
            var mark_type_name = $('#mark-type option:selected').text();
            var year= $('#year').val();
          var values = {
            "student_id" : student_id,
            "subject_id" : subject_id,
            "student_id" : student_id,
            "subject_name" : subject_name,
            "student_name" : student_name,
            "class_id" : class_id,
            "class_name" : class_name,
            "term" : term,
            "term_name" : term_name, 
            "mark" : mark,
            "mark_type" : mark_type,
            "mark_type_name" : mark_type_name,
            "year" : year,
            "_token": token,
          }
              
          $.ajax({
              type: "POST",
              url: "/result-aggregator",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#result-aggregator-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.redirect('/view-marks');
              }, 6000);
            }else if(result.class=='danger'){
                $(".class-name-group").addClass('text-danger');
                $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.term=='danger'){
              $(".term-name-group").addClass('text-danger');
              $('.term-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.year=='danger'){
                $(".year-group").addClass('text-danger');
                $('.year-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.subject=='danger'){
                $(".subject-name-group").addClass('text-danger');
                $('.subject-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.mark_type=='danger'){
                $(".mark-type-group").addClass('text-danger');
                $('.mark-type-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.mark=='danger'){
                $(".mark-group").addClass('text-danger');
                $('.mark-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
              $("#result-aggregator-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");               
              setTimeout(function(){
              location.reload();
              }, 6000);               
            }
          });
        }); 

        //submit edit and submit mark
        $('.mark').on('click', function(){
          
          $('.message').empty();
          var token =$("meta[name='csrf-token']").attr("content");
          var condition_id = $(this).find('span').attr('id');
          var aggregator_id = $(this).find('input').attr('id');
          $('#'+condition_id).css('display','none');
          $('#'+aggregator_id).css('display','block');
          $('#'+aggregator_id).on('keypress', function(event){
            if (event.key === "Enter") {
              $('.message').empty();
              var aggregator_id = $(this).attr('id');
              $('#'+condition_id).css('display','block');
              $('#'+aggregator_id).css('display','none');
              var mark = $('#'+aggregator_id).val();
              $('#'+condition_id).text(mark);
              aggregator_id = aggregator_id.split("-");
              aggregator_id  = aggregator_id[1];
              values= {
                "aggregator_id": aggregator_id,
                "mark": mark,
                "_token": token,
              }
              $.ajax({
                  type: "POST",
                  url: "/mark",
                  data: values,
              }).done(function(result){
                if (result.success=='success'){
                  $('#'+condition_id).css('display','block');
                  $('#'+aggregator_id).css('display','none');                  
                  setTimeout(function(){
                  location.reload();
                  }, 6000);
                }else if(result.mark=='danger'){
                  $('#'+condition_id).css('display','none');
                  $('#mark-'+aggregator_id).css('display','block');
                  $('.message').empty();
                  $('.mark').prepend("<span class='text-danger message'>"+result.message+"</span>");
                }else if(result.failure=='danger'){
                    $(".mark-result").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
                  setTimeout(function(){
                  location.reload();
                  }, 6000);                  
                }
              });
            }
          });
        });

        //onchange of student to select subject
        $('#student-name').on('change', function(){
          $('.help-block').remove(); 
          $('.student-name-group').removeClass('text-danger');
          $('.class-name-group').removeClass('text-danger');       
          $('.term-name-group').removeClass('text-danger');  
          $('.subject-name-group').removeClass('text-danger'); 
          $("#subject_name").empty().append('<option value="">Select-Subject-Name</option>');
          var token =$("meta[name='csrf-token']").attr("content");
          var student_id = $('#student-name option:selected').val();
          var student_name = $('#student-name option:selected').text();
          var class_id = $('#class-name option:selected').val();
          var term = $('#term-name option:selected').val();
          var year = $('#year').val();
          values= {
            "class_id" : class_id,
            "student_id": student_id,
            "student_name": student_name,
            "term" : term,
            "year" : year,
            "_token": token
          }
          $.ajax({
              type: "POST",
              url: "/change-student",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
                 $("#subject-name").append(result.options);
            }else if(result.class=='danger'){
                $(".class-name-group").addClass('text-danger');
                $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.term=='danger'){
              $(".term-name-group").addClass('text-danger');
              $('.term-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.year=='danger'){
                $(".year-group").addClass('text-danger');
                $('.year-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.subject=='danger'){
              $(".subject-name-group").addClass('text-danger');
              $('.subject-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }
          });
        });    


        //onchange of class to select student
        $('#student_name').on('change', function(){
          var token =$("meta[name='csrf-token']").attr("content");
          var student_id = $('#student_name option:selected').val();;
          values= {
            "student_id": student_id,
            "_token": token
          }
          $.ajax({
              type: "POST",
              url: "/change-student-name",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
                 $("#parent_name").val(result.parent_name);
            }else if(result.failure=='danger'){
                $("#view-results-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });

        //onchange of class to select student
        $('.class_name').on('change', function(){
          $('.help-block').remove(); 
          $('.duration-name-group').removeClass('text-danger');
          $('.class-name-group').removeClass('text-danger');       
          $('.term-name-group').removeClass('text-danger');  
          $('.year-group').removeClass('text-danger');           
          $("#student_name").empty().append('<option value="">Select-Student-Name</option>');
          var token =$("meta[name='csrf-token']").attr("content");
          var class_id = $('#class_name option:selected').val();
          var duration = $('#duration_name option:selected').val();
          var year = $('#year').val();
          var term = $('#term_name option:selected').val();
          values= {
            "class_id": class_id,
            "duration": duration,
            "year" : year,
            "term" : term,
            "_token": token
          }
          $.ajax({
              type: "POST",
              url: "/change-class-name",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
                 $("#student_name").append(result.options);
            }else if(result.class=='danger'){
                $(".class-name-group").addClass('text-danger');
                $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.duration=='danger'){
              $(".duration-name-group").addClass('text-danger');
              $('.duration-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.year=='danger'){
                $(".year-group").addClass('text-danger');
                $('.year-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.term=='danger'){
              $(".term-name-group").addClass('text-danger');
              $('.term-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
                $("#view-results-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });


        //onclick send result to parent
        /*$('#sendResult').on('click', function(){
          $('.help-block').remove(); 
          $('.duration-name-group').removeClass('text-danger');
          $('.class-name-group').removeClass('text-danger');       
          $('.term-name-group').removeClass('text-danger');  
          $('.student-name-group').removeClass('text-danger');  
          $('.year-group').removeClass('text-danger');   
          $('.result-type-group').removeClass('text-danger');    
          var token =$("meta[name='csrf-token']").attr("content");
          var class_id = $('#class_name option:selected').val();
          var class_name = $('#class_name option:selected').text();
          var duration = $('#duration_name option:selected').val();
          var year = $('#year').val();
          var term = $('#term_name option:selected').val();
          var term_name = $('#term_name option:selected').text();
          var student = $('#student_name option:selected').val();
          var student_name = $('#student_name option:selected').text();
          var result_type = $('#result_type option:selected').val();
          values= {
            "class": class_id,
            "class_name": class_name,
            "duration": duration,
            "year" : year,
            "term" : term,
            "term_name" : term_name,
            "student" : student,
            "student_name" : student_name,            
            "result_type" : result_type,
            "_token": token,
          }
          $.ajax({
              type: "POST",
              url: "/send-result",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#view-results-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
              location.redirect('/view-marks');
              }, 6000);
            }else if(result.class=='danger'){
                $(".class-name-group").addClass('text-danger');
                $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.duration=='danger'){
              $(".duration-name-group").addClass('text-danger');
              $('.duration-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.year=='danger'){
                $(".year-group").addClass('text-danger');
                $('.year-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.term=='danger'){
              $(".term-name-group").addClass('text-danger');
              $('.term-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.result_type=='danger'){
              $(".result-type-group").addClass('text-danger');
              $('.result-type-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
                $("#view-results-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });*/

        // toggle sales order
        $('#paymentToggle').click(function(){
          $('#payment-body').toggle();
        });         

        //onclick make payment 
        $('#savePayment').on('click', function(){
          $('.help-block').remove(); 
          $('.amount-group').removeClass('text-danger');
          $('.class-name-group').removeClass('text-danger');       
          $('.term-name-group').removeClass('text-danger');  
          $('.student-name-group').removeClass('text-danger');  
          $('.year-group').removeClass('text-danger');   
          $('.transaction-group').removeClass('text-danger');    
          var token =$("meta[name='csrf-token']").attr("content");
          var class_id = $('#class-name option:selected').val();
          var class_name = $('#class-name option:selected').text();
          var year = $('#year').val();
          var term = $('#term-name option:selected').val();
          var term_name = $('#term-name option:selected').text();
          var student = $('#student-name option:selected').val();
          var student_name = $('#student-name option:selected').text();
          var transaction = $('#transaction-name option:selected').val();
          var transaction_name = $('#transaction-name option:selected').text();
          var amount = $('#amount').val();
          values= {
            "class": class_id,
            "class_name": class_name,
            "amount": amount,
            "year" : year,
            "term" : term,
            "term_name" : term_name,
            "student" : student,
            "student_name" : student_name,            
            "transaction" : transaction,
            "transaction_name" : transaction_name, 
            "_token": token,
          }
          $.ajax({
              type: "POST",
              url: "/payments",
              data: values,
          }).done(function(result){
            if (result.success=='success'){
              $("#payment-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
              setTimeout(function(){
                location.reload();
              }, 6000);
            }else if(result.class=='danger'){
              $(".class-name-group").addClass('text-danger');
              $('.class-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.student=='danger'){
              $(".student-name-group").addClass('text-danger');
              $('.student-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.year=='danger'){
                $(".year-group").addClass('text-danger');
                $('.year-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.term=='danger'){
              $(".term-name-group").addClass('text-danger');
              $('.term-name-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.transaction=='danger'){
              $(".transaction-group").addClass('text-danger');
              $('.transaction-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.amount=='danger'){
              $(".amount-group").addClass('text-danger');
              $('.amount-group').append("<div class='help-block'>" +result.message+"</div>");
            }else if(result.failure=='danger'){
                $("#payment-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
              setTimeout(function(){
              location.reload();
              }, 6000);                  
            }
          });
        });    
        
       $('.deleteBlog').on('click', function(){
          var delBlog = $(this).attr('id');
          delBlog = delBlog.split(' ');
          $('.del_blog').attr('id', 'del_blog'+delBlog[1])
          $('#del_blog'+delBlog[1]).on('click', function(){
            var token =$("meta[name='csrf-token']").attr("content");
            values= {
              "BlogId": delBlog[1],
              "_token": token,
            }

            // delete staff
            $.ajax({
                type: "DELETE",
                url: "/delete-blog-post/"+delBlog[1],
                data: values,
            }).done(function(result){
              if (result.success=='success'){
                $('#confirm-delete').modal('hide');
                $("#blog-body").prepend("<div class='status alert alert-success text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
                setTimeout(function(){
                location.reload();
                }, 6000);
              }else if(result.success=='fail'){
                  $("#blog-body").prepend("<div class='status alert alert-danger text-center col-sm-9 offset-sm-1'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>");
                setTimeout(function(){
                location.reload();
                }, 6000);                  
              }
            });
          });
        });           
        
        // toggle result
        $('#viewResultsToggle').click(function(){
          $('#view-results-body').toggle();
        }); 

        //toggle blog edit
        $('#editBlogToggle').click(function(){
          $('#edit-blog-body').toggle();
        }); 
        

        //monthly earnings
        $.get('/earning-monthly', function(data){
          $('.earning-monthly').html(data);
        });

        // annual earnings
        $.get('/earning-annually', function(data){
          $('.earning-annually').html(data);
        });   
        
        //yearly stationeries sales
        $.get('/stationeries-sales', function(data){
          $('.stationeries-sales').html(data);
        }); 
        
        //recovered monthly school fee
        $.get('/recovered-fees', function(data){
          $('.recovered-fees').html(data);
        });         
        
        

        $('#dataTableStaff').DataTable(); 

        $('#dataTableTeacher').DataTable();
        
        $('#dataTableParent').DataTable(); 

        $('#dataTableStaffRegister').DataTable();
        
        $('#dataTableStudent').DataTable();

        $('#dataTableStudentRegister').DataTable();

        $('#dataTableSelectSubject').DataTable(); 

        $('#dataTableAssignSubject').DataTable(); 

        $('#dataTableStationary').DataTable(); 

        $('#dataTableAssignBook').DataTable();      

        $('#dataTableResultEstimator').DataTable();    
        
        $('#dataTableRecordSales').DataTable();   

        $('#dataTableResultAggregator').DataTable({
          dom: 'Bfrtip',
          buttons: [
            'copy', 'excel', 'pdf', 'csv', 'print'
          ]
        }); 

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
          <img src="{{asset('admin/img/icon.jpg')}}" width="25" height="25" style="border-radius:100%;">
        </div>
        <div class="sidebar-brand-text mx-3"> The School </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
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
          <span>Settings</span>
        </a>
        <div id="collapseSchool" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Settings:</h6>

              @if(Auth::user()->isAdmin())
                <a class="collapse-item" href="/profile">Profile</a> 
                <a class="collapse-item" href="/info-settings">Information Update</a>                  
                <a class="collapse-item" href="/setting-privilege">Setting Privilege</a>            
                <a class="collapse-item" href="/send-memo">Send Memo</a>
             @endif  

             @if(Auth::user()->isMember())
             <a class="collapse-item" href="/reset-password">Reset Password</a>
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
              <a class="collapse-item" href="/add-staff">Add New Staff</a>
              <a class="collapse-item" href="/view-staffs">View Staffs Table</a>
              <a class="collapse-item" href="/staff-register"> Staffs Register</a> 
  
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Teachers</span>
        </a>
        <div id="collapseTeachers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Teachers</h6>
            <a class="collapse-item" href="/teacher"> Add Teacher</a>
            <a class="collapse-item" href="/assign-subject">Assign Subject</a>
            <div class="collapse-divider"></div>
            <!--<h6 class="collapse-header">Others:</h6>-->
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-handshake text-gray-400"></i>
          <span>Parents</span>
        </a>
        <div id="collapseParents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Parents</h6>
            <a class="collapse-item" href="/add-parent">Add New Parent</a>          
            <a class="collapse-item" href="/view-parents">View Parent Table</a>
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
            <a class="collapse-item" href="/add-student"> Add New Student</a>
            <a class="collapse-item" href="/view-students">View Students Table</a>
            <a class="collapse-item" href="/select-subject">Select Subject</a> 
            <a class="collapse-item" href="/students-register"> Students Register</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Class Setup:</h6> 
            <a class="collapse-item" href="/class-setup">Class Setup</a>    
            <a class="collapse-item" href="/class-status">Student Class Status</a>                    
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseBlogPost" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Blog Post</span>
        </a>
        <div id="collpaseBlogPost" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Blog Post:</h6>
            <a class="collapse-item" href="/post"> Add Blog Post</a>
            <a class="collapse-item" href="/posts">View Blog Posts</a>                  
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
          <i class="fas fa-fw fa-book text-gray-400"></i>
          <span>Result Aggregator</span>
        </a>
        <div id="collpaseResult" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Result Aggregator:</h6>
            <a class="collapse-item" href="/result-aggregator">Result Aggregator</a>
            <a class="collapse-item" href="/result-estimator">Result Estimator</a>       
            <a class="collapse-item" href="/view-marks">Student Marks</a>         
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
            <a class="collapse-item" href="/payments">Payment</a>           
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
          <i class="fa fa-book text-gray-400"></i>
          <span>Library</span>
        </a>
        <div id="collpaseLibrary" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Library:</h6>           
            <a class="collapse-item" href="assign-book">Assign Book</a>            
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseStationeries" aria-expanded="true" aria-controls="collapsePages">
          <i class="fa fa-book text-gray-400"></i>
          <span>Stationeries</span>
        </a>
        <div id="collpaseStationeries" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"> Stationeries:</h6>
            <a class="collapse-item" href="/stationeries"> Stationeries </a>            
            <a class="collapse-item" href="/record-sales">Record Sales</a>             
          </div>
        </div>
      </li>        
      
    @endif    

      <li class="nav-item">
        <a class="nav-link" href="{{url('/logout')}}" onclick="event.preventDefault();
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
                <a class="dropdown-item" href="/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="/info-settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/logout')}}" onclick="event.preventDefault();
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
  <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>
   <script> window.onload=dateTime();</script>    
  <!-- Page level plugins -->
  <script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('jqueryTimePicker/jquery.timepicker.min.js')}}"></script>
  <!-- Page level custom scripts -->
  <script src="{{asset('admin/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('admin/js/demo/chart-pie-demo.js')}}"></script>
  <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script> 
  <script src="{{asset('admin/js/bootstrap-multiselect.min.js')}}"></script> 
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
    <form id='logout-form' action="{{url('/logout')}}"
    method="POST" style='display:none'>
        {{csrf_field()}}
    </form>
</body>

</html>
