$(document).ready(function () {
    contacts_table = initDatatble();
    $('#add_new').on('click',function(){
       addEdit(0); 
    })
});
function addEdit(id,that){
        
        html = `<form id="contactForm">
                <input type="hidden"  id="con_id" name="con_id" value="0">
            <div class="form-group row">
                <label for="colFormLabel" class="col-sm-4 col-form-label">phone</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control" name="phone" id="phone" >
                </div>
              </div>
              <p class="error_help" id="phone_help"> </p>
              <div class="form-group row">
                <label for="colFormLabel" class="col-sm-4 col-form-label">first name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="first_name" id="first_name" >
                </div>
              </div>
      <p class="error_help" id="first_name_help"> </p>
       <div class="form-group row">
                <label for="colFormLabel" class="col-sm-4 col-form-label">last name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="last_name" id="last_name" >
                </div>
              </div>
       <p class="error_help" id="last_name_help"> </p>
               <div class="form-group row">
                <label for="colFormLabel" class="col-sm-4 col-form-label">age</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control" name="age" id="age" >
                </div>
              </div>
         <p class="error_help" id="age_help"> </p>
               <div class="form-group row">
                <label for="colFormLabel" class="col-sm-4 col-form-label">email</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" name="email" id="email" >
                </div>
              </div>
      <p class="error_help" id="email_help"> </p>
               <div class="form-group row">
                <label for="colFormLabel" class="col-sm-4 col-form-label">gender</label>
                <div class="col-sm-8">
                  <select class="form-control" id="gender" name="gender">
                  <option value="m">male</option>
                  <option value="f">female</option>
                </select>
                </div>
              </div>
              </div>
              <div class="form-group row">
                <input class="btn btn-info" id="add_btn" value="Add/Update">
       
        <input class="btn btn-danger" id="close_btn" value="Close">
        </div>
  <p class="success_help"> </p>
       
            </form>`;

        popup=Swal.fire({
            title: 'add/update contact',
            html: html,
            showCancelButton: false,
            showConfirmButton:false,
          
            onOpen:function(){
                if(id>0){
                    var phone=that.parent().parent().children().eq(0).text();
                    var email=that.parent().parent().children().eq(1).text();
                    var first_name=that.parent().parent().children().eq(2).text();
                    var last_name=that.parent().parent().children().eq(3).text();
                    var age=that.parent().parent().children().eq(4).text();
                    var gender=that.parent().parent().children().eq(5).text();
                    $('#con_id').val(id);
                    $('#phone').val(phone);
                    $('#email').val(email);
                    $('#first_name').val(first_name);
                    $('#last_name').val(last_name);
                    $('#age').val(age);
                    $('#gender').val(gender);
                }
                $('#add_btn').unbind().on('click',function(){
                     $.ajax({
                    dataType: "json",
                    type: "POST",
                    data: {
                        contactForm: $('#contactForm').serializeArray(),
                        action: 'addUpdateContact',
                    },
                    url: "index.php",
                    success: function (data) {
                          $('.error_help').text('');
                        if (data['status'] == 'success') {
                          $('.success_help').text('added succesfully');
                          $('#contactForm input').val('');
                          setTimeout(function(){
                               Swal.close();
                               contacts_table.ajax.reload();
                          },1000)
                         
                            
                        } else {
                         
                            $.each( data['msg'], function( k,v ) {
                                   $('#'+k+'_help').text(v);
                                  });
                        }
                    }
                });
                })
                 $('#close_btn').unbind().on('click',function(){
                   Swal.close() 
                 });
                   
                
            }
        });
   
}
function initDatatble() {
    buttonsArray = [];

   
    var table = $("#contacts_table")
        .on('draw.dt', function () {
                $('.delete_action').unbind().on('click',function(){
                     $.ajax({
                    dataType: "json",
                    type: "POST",
                    data: {
                        id: $(this).attr('contact_id'),
                        action: 'deleteContact',
                    },
                    url: "index.php",
                    success: function (data) {
                         
                        if (data['status'] == 'success') {
                         contacts_table.ajax.reload();
                            
                        } else {
                         
                            
                        }
                    }
                });
                })
        $('.edit_action').unbind().on('click',function(){
                addEdit($(this).attr('contact_id'),$(this));
              })
        })
        .on('preXhr.dt', function (e, settings, data) {
           
          })
        .DataTable({
            processing: false,
            serverSide: true,
            "lengthMenu": [[20, 30, 40, 50, 100], [20, 30, 40, 50, 100]],
            "aaSorting": [],
            dom: 'lfBrtip',
            buttons: buttonsArray,
            width: "100%",
            "searching": true,
            ajax: {
                "url": 'index.php',
                "type": "POST",
                "dataType": "json",
                "data": function (data) {
                    data.action = 'getContacts';
                    return data;
                }
            }
        });
    return table;
}