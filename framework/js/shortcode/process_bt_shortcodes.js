tinyMCEPopup.requireLangPack();

var ed;

function init(){

	ed = tinyMCEPopup.editor;

	tinyMCEPopup.resizeToInnerSize();
	shf = document.forms[0];
}


function insertShortcode(){
	var fe, shf = document.forms[0], hs;

	tinyMCEPopup.restoreSelection();
	
	shf.shortcode.value = shf.shortcode.value == "" ? '' : shf.shortcode.value;
	shf.url.value = shf.url.value == "" ? '#' : shf.url.value;
	shf.text.value = shf.text.value == "" ? 'Text Button' : shf.text.value;
	shf.bg_color.value = shf.bg_color.value == "" ? '009ab6' : shf.bg_color.value;
	shf.font_color.value = shf.font_color.value == "" ? 'FFFFFF' : shf.font_color.value;
	
	if(shf.shortcode.value != null){
		switch (shf.shortcode.value) {
			
			case "small":
				
				hs = '[button size="small" href="'+shf.url.value+'" bgcolor="#'+shf.bg_color.value+'" fontcolor="#'+shf.font_color.value+'" text="'+shf.text.value+'"]';
				
			break;
			
			case "medium":
				
				hs = '[button size="medium" href="'+shf.url.value+'" bgcolor="#'+shf.bg_color.value+'" fontcolor="#'+shf.font_color.value+'" text="'+shf.text.value+'"]';
				
			break;
			
			case "big":
				
				hs = '[button size="big" href="'+shf.url.value+'" bgcolor="#'+shf.bg_color.value+'" fontcolor="#'+shf.font_color.value+'" text="'+shf.text.value+'"]';
				
			break;

		
		}

		ed.execCommand('mceInsertContent', false, hs);
		tinyMCEPopup.close();
	}
}

tinyMCEPopup.onInit.add(init);