// GetKey functin
function getKey(val,arr){
    for(key in arr)
    {
        if(arr[key]==val)
            return key
    }
    return null;
}
// Initialize CodeMirror editor
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
	lineNumbers: true,
	lineWrapping: true,
	onChange: function() {
		if (!newFile) {
			modified = true;
		}
	},
onCursorActivity: function() {
    editor.setLineClass(hlLine, null, null);
    hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
  } 
});
var hlLine = editor.setLineClass(0, "activeline")
// Stores what file is currently selected
var selected = '';

// New file loaded state
var newFile = false;

// Stores if current file has been modified
var modified = false;

// Setup valid file extensions
var extensions = Array();

extensions['html'] = 'htmlmixed';
extensions['htm'] = 'htmlmixed';
extensions['js'] = 'javascript';
extensions['json'] = 'javascript';
extensions['cfg'] = 'scheme';
extensions['css'] = 'css';
extensions['php'] = 'php';

// Setup ctrl/cmd function
$.ctrl = function(key, callback, args) {
    var isCtrl = false;
    $(document).keydown(function(e) {
        if (!args) args=[]; // IE barks when args is null

        if (e.ctrlKey || e.metaKey) isCtrl = true;
        if (e.keyCode == key.charCodeAt(0) && isCtrl) {
            callback.apply(this, args);
            return false;
        }
    }).keyup(function(e) {
        if (e.ctrlKey || e.metaKey) isCtrl = false;
    });
};

// Create new Page file using ajax
function createFile(createfile) {
	$.post("admin/ajax.php", { createfile: createfile }, function(data) {
        var msg='';
        switch(data){
            // Unacceptable filename extension : failure!
            case '-2': msg='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Unacceptable (or non-existent) filename extension! Only one of *.htm, *.html, *.php is allowed</h4></div>';
                    break;
            // File exists already : failure!
            case '-1': msg='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">A file with same name already exists!</h4></div>';
                    break;
            // Couldn't create file : failure!
            case '0': msg='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">The new file could not be created.</h4></div>';
                    break;
            // SUCCESS!!!
            case '1': msg='<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">File successfully Created.</h4>You will need to refresh this page to see the new file listed below.</div>';
                    break;    
        }
        $('#alerts').append(msg);
	});
}

// Gets file contents using ajax and loads into editor
function getFile(file) {
	$.post("admin/ajax.php", { file: file }, function(data) {
		selected = file;
		newFile = true;
		editor.setValue(data);
		newFile = false;
	});
}

// Save file contents in editor using ajax
function saveFile(){
	$.post("admin/ajax.php", { file: selected, code: editor.getValue() }, function(data) {
		if (data === 'success') {
			// Reset modified state
			modified = false;
			// Output success message
			$('#alerts').append('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">File successfully saved.</h4></div>');
		}
		else {
			// Output error message
			$('#alerts').append('<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">The file could not be saved.</h4></div>');
		}
	});
}

// Document ready function
$(function() {
    // Tooltips
    $("#logout").tooltip();
    $("#visit_site").tooltip();
    
    // Create new file
    $('#createnew').click(function(e){
        var createfile=prompt("Enter filename of new Page file to be created (Allowed extensions are *.htm, *.html, *.php)");
        if(createfile!=null && createfile!='')
            createFile("../sys/gui/pages/"+createfile);
    });
    
	// Prevent default form submit
	$("#editor-form").submit(function(e){
    	return false;
    });
    
    // Add click event to save button
	$('#save-file').click(function() {
		saveFile();
	});
	
	// Add click event for selecting file
	$('#file-tree .file-item').click(function() {
		var confirmed = false;
		var file = $(this).attr('path');
		var ext = file.substr(file.lastIndexOf('.') + 1);
        // Show route for selected page file
        var page=file.replace(/\\/g,'/').replace( /.*\//, '' );
        if (getKey(page,routes)) {
            var route=siteurl+getKey(page,routes)
            $('#filename').html("Route: <a class='siteurl' href='"+route+"' title='Click to go to URL in new tab/window' target='_blank'>"+route+"</a>");
        }
        else
            $('#filename').html('');
		
		// If file extension is valid for editor
		if (extensions[ext] != null) {
			if (modified) {
				confirmed = confirm("There are unsaved changes to this file. Are you sure you want to open another and lose the changes you made to this one?");
			}
			else {
				confirmed = true;
			}
			if (confirmed) {
				// Set CodeMirror mode for file
				editor.setOption('mode', extensions[ext]);
				// Set file active
				$('#file-tree li').removeClass('active');
				$(this).parent().addClass('active');
				// Load file
				getFile(file);
				// Reset modified state
				modified = false;
			}
		}
			
		return false;
	});
	// Visit site button
    $("#visit_site").click( function(){
        window.open(siteurl); //N.B: var siteurl defined within index.php
    });
    // Logout button
    $("#logout").click( function(){
        window.location.href=siteurl+"logout"; //N.B: var siteurl defined within index.php
    });    
	// Setup keyboard shortcuts
	$.ctrl('S', function() {
	    saveFile();
	});
});
