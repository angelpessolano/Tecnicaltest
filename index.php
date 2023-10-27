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
        $(document).ready(function() {

            // var mydata = [
            //          { id: "1", name: "test"},
            //          { id: "2", name: "test2" },
            //   ];

            $("#list2").jqGrid({
                url: 'GetData.php',
                datatype: "json",
                colNames: ['ID', 'Category NAME', 'Count'],
                colModel: [{
                        name: 'id_category',
                        index: 'id_category',
                        width: 250,
                        classes: 'cvteste'
                    },
                    {
                        name: 'name',
                        index: 'name',
                        width: 290,
                        classes: 'cvteste'
                    },
                    {
                        name: 'count',
                        index: 'count',
                        width: 290,
                        classes: 'cvteste'
                    },
                ],
                rowNum: 5,
                rowList: [5, 10, 15, 20],
                pager: '#pager2',
                sortname: 'id',
                viewrecords: true,
                sortorder: "asc",
                height: '100%',
                subGrid: true,
                subGridRowExpanded: firstSubGrid
            });

            function firstSubGrid(parentRowId, id_category) {
                console.log('parentRowId = ', parentRowId);
                console.log('id_category = ', id_category);

                let childGridID = parentRowId + "_table";
                let childGridPagerID = parentRowId + "_pager";

                $("#" + parentRowId).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + '></div>');

                $("#" + childGridID).jqGrid({
                    url: 'GetDataCategory.php?id_category=' + id_category,
                    datatype: "json",
                    colNames: ['ID', ' NAME', 'Count'],
                    colModel: [{
                            name: 'id_product',
                            index: 'id_product',
                            width: 250,
                            classes: 'cvteste'
                        },
                        {
                            name: 'name',
                            index: 'name',
                            width: 290,
                            classes: 'cvteste'
                        },
                        {
                            name: 'count',
                            index: 'count',
                            width: 290,
                            classes: 'cvteste'
                        },
                    ],
                    rowNum: 5,
                    rowList: [5, 10, 15, 20],
                    pager: '#' + childGridPagerID,
                    sortname: 'id',
                    viewrecords: true,
                    sortorder: "asc",
                    height: '100%',
                    subGrid: true,
                    subGridRowExpanded: secondSubGrid
                });


                // var selectedRow = $("#list2").jqGrid('getRowData', parentRowId);
                // // Get the selected category ID
                // var categoryId = selectedRow.id_category;
                //  console.log(selectedRow);
                // console.log(categoryId);


                // Deploy another grid based on the selected category ID
                // $("#grid3").jqGrid({
                // 	url:'GetData.php?category_id=' + categoryId, 
                // 	datatype: "json",
                // 	colNames:['Product Name','Price'], 
                // 	colModel:[ {name:'name',index:'name', width:290,classes: 'cvteste'}, 
                // 	   {name:'price',index:'price', width:290,classes: 'cvteste'},    
                // 	],
                // 	rowNum:2, 
                // 	rowList:[2,4,6,8], 
                // 	pager: '#pager3', 
                // 	sortname: 'id', 
                // 	viewrecords: true, 
                // 	sortorder: "asc", 
                // 	height: '100%'
                // });
            }

            function secondSubGrid(parentRowId, id_category) {


                console.log('parentRowId = ', parentRowId);
                console.log('id_category = ', id_category);

                let childGridID = parentRowId + "_table";
                let childGridPagerID = parentRowId + "_pager";

                $("#" + parentRowId).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + '></div>');

                $("#" + childGridID).jqGrid({
                    url: 'GetDataCategory.php?id_category=' + id_category,
                    datatype: "json",
                    colNames: ['ID', ' NAME', 'Count'],
                    colModel: [{
                            name: 'id_product',
                            index: 'id_product',
                            width: 250,
                            classes: 'cvteste'
                        },
                        {
                            name: 'name',
                            index: 'name',
                            width: 290,
                            classes: 'cvteste'
                        },
                        {
                            name: 'count',
                            index: 'count',
                            width: 290,
                            classes: 'cvteste'
                        },
                    ],
                    rowNum: 5,
                    rowList: [5, 10, 15, 20],
                    pager: '#' + childGridPagerID,
                    sortname: 'id',
                    viewrecords: true,
                    sortorder: "asc",
                    height: '100%'
                });


                // var selectedRow = $("#list2").jqGrid('getRowData', parentRowId);
                // // Get the selected category ID
                // var categoryId = selectedRow.id_category;
                //  console.log(selectedRow);
                // console.log(categoryId);


                // Deploy another grid based on the selected category ID
                // $("#grid3").jqGrid({
                // 	url:'GetData.php?category_id=' + categoryId, 
                // 	datatype: "json",
                // 	colNames:['Product Name','Price'], 
                // 	colModel:[ {name:'name',index:'name', width:290,classes: 'cvteste'}, 
                // 	   {name:'price',index:'price', width:290,classes: 'cvteste'},    
                // 	],
                // 	rowNum:2, 
                // 	rowList:[2,4,6,8], 
                // 	pager: '#pager3', 
                // 	sortname: 'id', 
                // 	viewrecords: true, 
                // 	sortorder: "asc", 
                // 	height: '100%'
                // });
            }



        });
    </script>
    <title>jqGrid Demo</title>
</head>

<body>
    <table id="list2"></table>
    <div id="pager2"></div>
</body>

</html>