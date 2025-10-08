/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			8th October, 2025
	@created		12th August, 2025
	@package		JOFacebook
	@subpackage		jofbkpost.js
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.custom_admin_view.javascript_file.1.$$$$]***/
function insertFacebookPost($, editorName) {
	let editor = parent.Joomla.editors.instances[editorName];
	if (editor) {
		var adminform = document.getElementById("adminForm");
		var Data = new FormData(adminform);
		editor.replaceSelection("{fbkpost profile=" + Data.getAll("jform[profile]") + ";post="+  Data.getAll("jform[post]") + "}");
		$(".btn-close", parent.document).click();
	}
}

function autoResize(iframe) {
	$(iframe).height($(iframe).contents().find('html').height());
}

function filloneNote($, profile, post)
{
	var ajaxField = $('div.note_one');
	if (ajaxField) {
			var url =  'index.php?option=com_jofacebook&view=facebookpost&tmpl=component&profile=' + profile + '&post='+ post;
			ajaxField.html('<iframe  width="640" height="480" src="' + url + '" onload="autoResize(this);"></iframe>');
	}
}
function showFacebookPost($) {
	var adminform = document.getElementById("adminForm");
	var Data = new FormData(adminform);
	var profile =  Data.getAll("jform[profile]");
	var post =  Data.getAll("jform[post]");
	filloneNote($, profile, post);
       return false;
}

function onselectRow($, id) {
	$.ajax({
		url:   'index.php?option=com_jofacebook&view=facebookpost&layout=json&id=' + id,
		type: "POST",
		dataType: "json",
		success: function(data) {
			$('#jform_profile').val(data['profile']);
			 $('#jform_post').val(data['post']);
                        $('#jform_description').val(data['description']);
                        filloneNote($, data['profile'], data['post']);
		},
		error: function(xhr, status, text) {
			var response = $.parseJSON(xhr.responseText);
			console.log('Failure!');
			if (response) {
				console.log(response['data']['error']);
			} else {
				// This would mean an invalid response from the server - maybe the site went down or whatever...
			}
		}
	});
}

$( document ).ready(function() {
	var selectpost = $('#jform_title');
	onselectRow($,  selectpost.find(":selected").val());
	selectpost.on('change', function() {
		onselectRow($, $(this).find(":selected").val());
	});
});

/***[/JCBGUI$$$$]***/
