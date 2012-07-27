<div data-role="header">
		<h1>Contact details</h1>
		<a href="#" id="edit-contact-button" data-role="button" class="ui-btn-right jqm-edit">Edit</a>
		<a style="display:none" href="#" id="save-contact-button" data-role="button" data-icon="check" class="ui-btn-right jqm-save">Save</a>
	</div><!-- /header -->

	<div data-role="content" id="contact-details-content">
		<div id="edit-contact">
		   	<div data-role="fieldcontain">
		        <input type="text" name="first_name" id="first_name" value="" placeholder="First Name" />
		    </div>
		    <div data-role="fieldcontain">
		        <input type="text" name="last_name" id="last_name" value="" placeholder="Last Name"/>
		    </div>
		    <div data-role="fieldcontain">
		        <input type="email" name="email" id="email" value="" placeholder="Email" />
		    </div>    
		    <div data-role="fieldcontain">
		        <input type="tel" name="tel" id="tel" value="" placeholder="Phone" />
		    </div>
		    <div data-role="fieldcontain">
		    	<textarea cols="40" rows="8" name="note" id="note" placeholder="Note"></textarea>
		    </div>
		    <a style="display:none" href="#" id="save-contact" data-role="button" data-theme="b">Save Contact</a> 
	    </div>
   <p><a href="#menu" data-rel="back" data-role="button" data-inline="true" data-icon="back">Back to pervious page</a></p>	
	</div><!-- /content -->
<script>
var contactId = <?php echo $id; ?>;
var contact = <?php echo json_encode($results); ?>;
$( function(){
	$('#edit-contact-button').click(function(){ editContact(); });
	$('#cancel-contact-button').click(function(){ cancelEditContact(); });
	$('#save-contact-button').click(function(){ updateContact(); });
	$('#first_name').val(contact.values[contactId].first_name);
	$('#last_name').val(contact.values[contactId].last_name);
	$('#email').val(contact.values[contactId].email);
	$('#tel').val(contact.values[contactId].phone);
	$("#edit-contact :input").attr("disabled", "disabled");
	hideEmptyFields();
	
});
function editContact(){
	$("#edit-contact :input").removeAttr("disabled");
	$('#edit-contact-button').hide();
	$('#back-contact-button').hide();
	$('#cancel-contact-button').show();
	$('#save-contact-button').show();
}

function cancelEditContact(){
	$("#edit-contact :input").attr("disabled", "disabled");
	$('#cancel-contact-button').hide();
	$('#save-contact-button').hide();
	$('#edit-contact-button').show();
	$('#back-contact-button').show();
	hideEmptyFields();
}

function hideEmptyFields(){
	$("#edit-contact :input").each(function (i) {
		if (!this.value){
			$(this).hide();	
		}
	  });
}
function updateContact() {
      first_name = $('#first_name').val(); 
      last_name = $('#last_name').val(); 
      phone = $('#tel').val(); 
      email = $('#email').val(); 
      note = $('#note').val(); 
   
        $().crmAPI ('Contact','update',{
            'version' :'3',
 			'id' : contactId,
            'contact_type' :'Individual', // only individuals for now
            'first_name' :first_name, 
            'last_name' : last_name, 
            'phone' : phone, 
            'email' : email 			}
          ,{ 
             ajaxURL: crmajaxURL,
             success:function (data){    
			       console.log("this is the returned contact id: " + data.id )
              // create the note if one exists
				if (note){
				$().crmAPI ('Note','create',{
					'version' :'3',
					'entity_id' : data.id,
					'note' : note
					}
				  ,{ success:function (data){    
			      console.log("note created");
				    }
				});}
				else{
					console.log("there was no note");
				} 
             $.mobile.changePage("<?php print url('civicrm/mobile/contact/') ?>"+data.id);
			
            }
        });
}	


</script>