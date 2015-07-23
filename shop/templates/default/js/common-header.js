function drop_mouseover(pos){
 try{window.clearTimeout(timer);}catch(e){}
}
function drop_mouseout(pos){
 var posSel=document.getElementById(pos+"Sel").style.display;
 if(posSel=="block"){
  timer = setTimeout("drop_hide('"+pos+"')", 1000);
 }
}
function drop_hide(pos){
 document.getElementById(pos+"Sel").style.display="none";
}
function search_show(pos,searchType,href){
	document.getElementById("search_act").value = searchType; 
    document.getElementById(pos+"Sel").style.display="none";
    document.getElementById(pos+"Slected").innerHTML=href.innerHTML;
    document.getElementById(pos+'q').focus();
    var sE = document.getElementById("searchExtend");
    if(sE != undefined  &&  searchType == "bar"){
     sE.style.display="block";
    }else if(sE != undefined){
     sE.style.display="none";
    }
 try{window.clearTimeout(timer);}catch(e){}
 return false;
}
function dosearch() {
	var keyword = $("#keyword").val();
	var act = $("act").val();
	var url = "index.php?keyword=" + keyword + "&act" + act;
	window.location.assign(url);
}