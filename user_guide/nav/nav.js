function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<ul>' +
		'<li><a href="'+base+'index.html">User Guide Home</a></li>' +
		'<li><a href="'+base+'toc.html">Table of Contents Page</a></li>' +
		'</ul>' +

		'<h3>Basic Info</h3>' +
		'<ul>' +
			'<li><a href="'+base+'general/requirements.html">Server Requirements</a></li>' +
		'</ul>' +

		'<h3>Installation</h3>' +
		'<ul>' +
			'<li><a href="'+base+'installation/downloads.html">Downloading NipIgniter</a></li>' +
			'<li><a href="'+base+'installation/index.html">Installation Instructions</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Tutorial</h3>' +
		'<ul>' +
			'<li><a href="'+base+'tutorial/index.html">Introduction</a></li>' +
			'<li><a href="'+base+'tutorial/generate_crud.html">Generate CRUD</a></li>' +
			'<li><a href="'+base+'tutorial/create_table.html">Create Table</a></li>' +
		'</ul>' +
		
		'</td><td class="td_sep" valign="top">' +

		'<h3>General Topics</h3>' +
		'<ul>' +
			'<li><a href="'+base+'general/urls.html">NipIgniter URLs</a></li>' +
			'<li><a href="'+base+'general/controllers.html">Controllers</a></li>' +
			'<li><a href="'+base+'general/views.html">Views</a></li>' +
			'<li><a href="'+base+'general/models.html">Models</a></li>' +
		'</ul>' +
		
		'</td><td class="td_sep" valign="top">' +

		'<h3>Additional</h3>' +
		'<ul>' +
			'<li><a href="'+base+'general/auth.html">Authentication</a></li>' +
		'</ul>' +
		
		'</td></tr></table>');
}