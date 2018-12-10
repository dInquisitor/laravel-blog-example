function pty(id)
{
	return document.getElementById(id);
}
function insert(f, e, id)
{
	var scroll = pty(id).scrollTop;
	if(document.selection)
	{
            
            
		pty(id).focus();
		sel = document.selection.createRange();
		sel.text = f+sel.text+e;
	}
	else if(pty(id).selectionStart || pty(id).selectionStart == '0')
	{
		var startPos = pty(id).selectionStart;
		var endPos = pty(id).selectionEnd;
		pty(id).value = pty(id).value.substring(0, startPos)+f+pty(id).value.substring(startPos, endPos)+e+pty(id).value.substring(endPos, pty(id).value.length);
		pty(id).selectionStart = startPos+f.length;
		pty(id).selectionEnd = startPos+f.length+(endPos-startPos);
	}
	else
	{
		pty(id).value += msg; 
	}
	pty(id).scrollTop = scroll;
	pty(id).focus();
}