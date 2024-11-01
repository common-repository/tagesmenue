(function() {
	tinymce.create('tinymce.plugins.tagesmenue', {
		init : function(ed, url) {
			jQuery( '#insert_TAGESMENUE_pdf' ).live( "click", function( e ) {
				e.preventDefault();
				
				ed.execCommand(
					'mceInsertContent',
					false,
					tagesmenue_create_shortcode(url)
				);
				
				tb_remove();
			} );
			ed.addButton('TAGESMENUE', {
				title : 'TAGESMENUE',
				image : url+'/../images/tagesmenue.jpg',
				onclick : function() {
					tb_show('TAGESMENUE', ajaxurl+'?action=TAGESMENUE_shortcodePrinter&width=600&height=700');
				}
			});
		},
	});
	tinymce.PluginManager.add('TAGESMENUE', tinymce.plugins.tagesmenue);
})();

function tagesmenue_create_shortcode(url) {	
	var inputs = jQuery('#TAGESMENUE_shortcode_generator').serializeArray();	
	var tagesmenue_key = '';
	var tagesmenue_design = '';
	var tagesmenue_showmenu_full = 'false';
	var tagesmenue_showmenu = 'false';
	var tagesmenue_showpdfbutton = 'false';
	var tagesmenue_katalogbutton = 'false';
	var tagesmenue_pdf_id = '';
	var tagesmenue_thumbnail = ''; 
	var tagesmenue_3speisekarten = '';
	for( var a in inputs ) {
		console.log(inputs[a]);
		if (inputs[a].name == "tagesmenue_design") {
			tagesmenue_design = inputs[a].value;
		}
		if (inputs[a].name == "TAGESMENUE_showmenu_FULL") {
			tagesmenue_showmenu_full = inputs[a].value;
		}
		if (inputs[a].name == "TAGESMENUE_showmenu") {
			tagesmenue_showmenu = inputs[a].value;
		}
		if (inputs[a].name == "TAGESMENUE_showpdfbutton") {
			tagesmenue_showpdfbutton = inputs[a].value;
		}
		if (inputs[a].name == "TAGESMENUE_key") {
			tagesmenue_key = inputs[a].value;
		}
		if (inputs[a].name == "TAGESMENUE_showkatalogbutton") {
			tagesmenue_katalogbutton = inputs[a].value;
		}
		if (inputs[a].name == "tagesmenue_pdf_id") {
			tagesmenue_pdf_id = inputs[a].value;
		}
		if( inputs[a].name == "tagesmenue_thumbnail") { 
			if (inputs[a].value) tagesmenue_thumbnail = inputs[a].value;
		}
		if( inputs[a].name == "TAGESMENUE_3speisekarten") { 
			if (inputs[a].value) tagesmenue_3speisekarten = inputs[a].value;
		}
		
	}	
	
	if (tagesmenue_thumbnail) {
	} else if (tagesmenue_pdf_id == 1) {
		tagesmenue_thumbnail = url + '/../images/speisekarte.png';
	} else if (tagesmenue_pdf_id == 2) {
		tagesmenue_thumbnail = url + '/../images/weinkarte.png';
	} else if (tagesmenue_pdf_id == 3) {
		tagesmenue_thumbnail = url + '/../images/dessertkarte.png';
	} else {
		tagesmenue_thumbnail = url + '/../images/kp_logo.png';
	}
	
	var shortcode = '';
	if (tagesmenue_key === undefined) {
	} else {
		if (tagesmenue_showmenu_full == 'true') {
			shortcode += '<div class="'+tagesmenue_design+'">';
			shortcode += '<div id="tagesmenue" class="tagesmenue"><span id="tagesmenuelogo">[Tagesmenue Full]</span></div>&nbsp;';
			shortcode += '<div id="tagesmenuebo" class="tagesmenuebo" ><span id="tagesmenuelogo">[Tagesmenue PDF Button]</span></div>&nbsp;';
			
			shortcode += '<div class="tagesmenue-menucard"><a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m=1"><img src="'+url + '/../images/speisekarte.png'+'" style="border: 0; width: 150px; height: auto;"><br>Speisekarte</a></div>';
			shortcode += '<div class="tagesmenue-menucard"><a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m=2"><img src="'+url + '/../images/weinkarte.png'+'" style="border: 0; width: 150px; height: auto;"><br>Weinkarte</a></div>';
			shortcode += '<div class="tagesmenue-menucard"><a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m=3"><img src="'+url + '/../images/dessertkarte.png'+'" style="border: 0; width: 150px; height: auto;"><br>Dessertkarte</a></div>';
			shortcode += '<div style="clear: both;"></div>';
			shortcode += '</div>';
		}
		if (tagesmenue_showmenu == 'true') {
			shortcode += '<div class="'+tagesmenue_design+'">';
			shortcode += '<div id="tagesmenue" class="tagesmenue"><span id="tagesmenuelogo">[Tagesmenue Full]</span></div>&nbsp;';
			shortcode += '</div>';
		}
		if (tagesmenue_3speisekarten == 'true') {
			shortcode += '<div class="tagesmenue-menucard"><a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m=1"><img src="'+url + '/../images/speisekarte.png'+'" style="border: 0; width: 150px; height: auto;"><br>Speisekarte</a></div>';
			shortcode += '<div class="tagesmenue-menucard"><a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m=2"><img src="'+url + '/../images/weinkarte.png'+'" style="border: 0; width: 150px; height: auto;"><br>Weinkarte</a></div>';
			shortcode += '<div class="tagesmenue-menucard"><a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m=3"><img src="'+url + '/../images/dessertkarte.png'+'" style="border: 0; width: 150px; height: auto;"><br>Dessertkarte</a></div>';
			shortcode += '<div style="clear: both;"></div>';
		}
		
		if ( tagesmenue_showpdfbutton == 'true') {
			shortcode += '<div id="tagesmenuebo" class="tagesmenuebo" ><span id="tagesmenuelogo">[Tagesmenue PDF Button]</span></div>&nbsp;';
		}
		if ( tagesmenue_katalogbutton == 'true') {
			shortcode += '<a class="iframe first last item" href="http://www.tagesmenue.ch/book.aspx?id='+tagesmenue_key+'&m='+tagesmenue_pdf_id+'"><img src="'+tagesmenue_thumbnail+'" style="border: 0; width: 100px; height: auto;"><br>Katalog'+tagesmenue_pdf_id+'</a>';
		}
	}

	return shortcode;
}