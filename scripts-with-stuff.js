jQuery(document).ready(function($){
	$('.my-color-field').wpColorPicker();
});

(function($){
    $(function(){
        if( $('.code_editor_here_please').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2
                }
            );
            var editor = wp.codeEditor.initialize( $('.code_editor_here_please'), editorSettings );
        }
    });
})(jQuery);

function eraseCookie(name) {
	document.cookie = name+'=; Max-Age=-99999999;';
}