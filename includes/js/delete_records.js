<script type="text/javascript">
	function send_query(sendto_page)
	{
	    var xmlHttp=GetXmlHttpObject();
	    if (xmlHttp==null)
	    {
	        alert ("Browser does not support AJAX - Please update");
	        return;
	    }
	    
	    var url="http://localhost/oaf/ajax/"+sendto_page;
	    var query_tail = deleteRow();
	    url=url+"?query= "+query_tail;
	    xmlHttp.onreadystatechange = function()
	    {	     
			if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
			{
				document.getElementById("test").innerHTML=xmlHttp.responseText;
			}
		}
		
		if(xmlHttp.open("GET",url,true)) alert('Done');
	    if(xmlHttp.send(null)) alert('Done2');
	}
	 
	function stateChanged() {
	     
	    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
	        document.getElementById("test").innerHTML=xmlHttp.responseText;
	    }
	}

	function GetXmlHttpObject(){
	    var xmlHttp=null;
	    try{
	    // Firefox, Opera 8.0+, Safari
	        xmlHttp=new XMLHttpRequest();
	    }
	    catch (e){
	    //Internet Explorer
	        try {
	            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	        }
	        catch (e){
	            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	        }
	    }
	    return xmlHttp;
	}

function deleteRow() 
{
var rows=document.getElementById('table2').getElementsByTagName('tr');
var i=rows.length;
var box; 
var srno_del = [];
while(i--)
 {
	box = rows[i].getElementsByTagName('input')[0];

	if(box != null && box.checked == true)
     {
		 srno_del.push(rows[i].getAttribute('id'));
		 rows[i].parentNode.removeChild(rows[i]);
      }
  }
  var query = "Sr_No = ";
  for(i=0; i<srno_del.length; i++)
  {
    if(i==0)
    {
      query += " "+srno_del[i];
    }
    else
    {
      query += " OR Sr_No = "+srno_del[i];
    }
  }
  return query;
}
</script>
