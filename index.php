<!DOCTYPE HTML>
<html>
<head>
<link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css' />
<link rel='stylesheet' type='text/css' href='http://www.trirand.com/blog/jqgrid/themes/ui.jqgrid.css' />

<script type='text/javascript' src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type='text/javascript' src='http://www.trirand.com/blog/jqgrid/js/jquery-ui-custom.min.js'></script>        
<script type='text/javascript' src='http://www.trirand.com/blog/jqgrid/js/i18n/grid.locale-en.js'></script>
<script type='text/javascript' src='http://www.trirand.com/blog/jqgrid/js/jquery.jqGrid.js'></script>

<script>
$(document).ready(function () {

	var mydata = [
               { id: "1", name: "test"},
               { id: "2", name: "test2" },
        ];

   	$("#list2").jqGrid({
		url:'GetData.php', 
		datatype: "json",
		// datatype: "local",
		// data: mydata,
		colNames:['ID','Category NAME','Count'], 
		colModel:[ {name:'id',index:'id', width:250,classes: 'cvteste'}, 
		   {name:'name',index:'name', width:290,classes: 'cvteste'}, 
		   {name:'count',index:'count', width:290,classes: 'cvteste'},    
		],
		rowNum:2, 
		//rowList:[10,20,30], 
		rowList:[2,4,6,8], 
		pager: '#pager2', 
		sortname: 'id', 
		//recordpos: 'left', 
		viewrecords: true, 
		sortorder: "asc", 
		height: '100%'
   });
});
</script>
<title>jqGrid Demo</title>
</head>
<body>
	<table id="list2"></table> 
	<div id="pager2" ></div>	
</body>
</html>