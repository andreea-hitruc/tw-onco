Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}

NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = 0, len = this.length; i < len; i++) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}


function upload(url,response){
	//var url = 'upload.php';
	var iframeId = 'iframeFormUpload';
	var iframe = document.createElement("iframe");
	iframe.setAttribute('id',iframeId);
	iframe.setAttribute('name',iframeId);
	iframe.style.display = 'none';
	document.getElementsByTagName('body')[0].appendChild(iframe);
	var form = document.getElementById("formUpload");
	form.setAttribute("action", url);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("encoding", "multipart/form-data");
    form.setAttribute("target", iframeId);
    form.submit();
	
	iframe.onload = function(){
		response(eval('('+document.getElementById(iframeId).contentWindow.document.body.innerHTML+')'));
		iframe.remove();
	}
	//iframe.remove();
}

function serialize(obj, prefix) {
  var str = [];
  for(var p in obj) {
    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
    str.push(typeof v == "object" ?
      serialize(v, k) :
      encodeURIComponent(k) + "=" + encodeURIComponent(v));
  }
  return str.join("&");
}

function request(method,url,data,response){


	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(response)
				response(xmlhttp.responseText);
		}
	  }
	  
	params = serialize(data);
	
	if(method == 'GET'){
		url = url+'?'+params;
	}
	  
	xmlhttp.open(method,url,true);
	
	
	if(method == 'POST' && data){
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(params);
	}else{
		xmlhttp.send();
	}

}

function get(url,data,response){
	request('GET',url,data,response);
}

function post(url,data,response){
	request('POST',url,data,response);
}

function deleteContact(uid){
	var r=confirm("Sunteti sigur ca doriti sa stergeti contactul?");
	if (r==true){
	  var url = BASE_URL+'delete.php';
	  post(url,{'uid':uid},function(data){
		data = eval('('+data+')');
		if(data['succes']){
			window.location.reload(true);
		}
	  });
	}else{
		return false;
	}
}

