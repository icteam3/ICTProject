function _gmwfb_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_gmwfb_display.action="options-general.php?page=google-map-with-fancybox-popup&ac=del&did="+id;
		document.frm_gmwfb_display.submit();
	}
}

function _gmwfb_submit()
{
	if(document.gmwfb_form.gmwfb_heading.value == "")
	{
		alert("Enter heading for your google map.")
		document.gmwfb_form.gmwfb_heading.focus();
		return false;
	}
	else if(document.gmwfb_form.googlemap_address.value == "")
	{
		alert("Enter map address. Google auto suggest helps you to choose one.")
		document.gmwfb_form.googlemap_address.focus();
		return false;
	}
	else if(document.gmwfb_form.googlemap_latitude.value == "")
	{
		alert("Enter map latitude (Or) Click Geocode button to get latitude.")
		document.gmwfb_form.googlemap_latitude.focus();
		return false;
	}
	else if(document.gmwfb_form.googlemap_longitude.value == "")
	{
		alert("Enter map longitude (Or) Click Geocode button to get longitude.")
		document.gmwfb_form.googlemap_longitude.focus();
		return false;
	}
}

function _gmwfb_redirect()
{
	window.location = "options-general.php?page=google-map-with-fancybox-popup";
}

function _gmwfb_help()
{
	window.open("http://www.gopiplus.com/work/2014/04/26/google-map-with-fancybox-popup-wordpress-plugin/");
}