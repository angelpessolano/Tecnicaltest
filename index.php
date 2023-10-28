<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categor&iacute;as y productos</title>

    <link rel='stylesheet' type='text/css' href='css/jquery-ui.css' />
    <link rel='stylesheet' type='text/css' href='css/ui.jqgrid.css' />

    <script type='text/javascript' src="js/jquery-1.10.1.min.js"></script>
    <script type='text/javascript' src='js/jquery-ui-custom.min.js'></script>
    <script type='text/javascript' src='js/grid.locale-es.js'></script>
    <script type='text/javascript' src='js/jquery.jqGrid.js'></script>

    <script>
        $(document).ready(function() {

            $("#list").jqGrid({
                url: 'src/GetData.php',
                datatype: 'json',
                colNames: ['ID', 'Categor&iacute;a', 'Cantidad de productos'],
                colModel: [{
                        name: 'id_category',
                        index: 'id_category',
                        width: 60,
                        hidden: true,
                        sortable: false
                    },
                    {
                        name: 'name',
                        index: 'name',
                        width: 500,
                        sortable: false
                    },
                    {
                        name: 'count',
                        index: 'count',
                        width: 200,
                        sortable: false,
                        align: 'center'
                    },
                ],
                rowNum: 50,
                rowList: [5, 10, 25, 50, 100],
                pager: '#pager',
                viewrecords: true,
                height: '100%',
                subGrid: true,
                subGridRowExpanded: firstSubGrid
            });

            function firstSubGrid(parentRowId, id_category) {
                let childGridID = parentRowId + "_table";
                let childGridPagerID = parentRowId + "_pager";

                $("#" + parentRowId).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + '></div>');

                $("#" + childGridID).jqGrid({
                    url: 'src/GetDataCategory.php?id_category=' + id_category,
                    datatype: 'json',
                    colNames: ['ID', 'Producto', 'Cantidad de caracter&iacute;sticas'],
                    colModel: [{
                            name: 'id_product',
                            index: 'id_product',
                            width: 60,
                            hidden: true,
                            sortable: false
                        },
                        {
                            name: 'name',
                            index: 'name',
                            width: 460,
                            sortable: false
                        },
                        {
                            name: 'count',
                            index: 'count',
                            width: 200,
                            sortable: false,
                            align: 'center'
                        },
                    ],
                    rowNum: 25,
                    rowList: [5, 10, 25, 50, 100],
                    pager: '#' + childGridPagerID,
                    viewrecords: true,
                    height: '100%',
                    subGrid: true,
                    subGridRowExpanded: secondSubGrid
                });
            }

            function secondSubGrid(parentRowId2, id_product) {
                let childGridID2 = parentRowId2 + "_table";
                let childGridPagerID2 = parentRowId2 + "_pager";

                $("#" + parentRowId2).append('<table id=' + childGridID2 + '></table><div id=' + childGridPagerID2 + '></div>');

                $("#" + childGridID2).jqGrid({
                    url: 'src/GetDataProduct.php?id_product=' + id_product,
                    datatype: 'json',
                    colNames: ['ID', ' Caracter&iacute;stica', 'Valor'],
                    colModel: [{
                            name: 'id_feature',
                            index: 'id_feature',
                            width: 60,
                            hidden: true,
                            sortable: false
                        },
                        {
                            name: 'name',
                            index: 'name',
                            width: 400,
                            sortable: false,
                            align: 'center'
                        },
                        {
                            name: 'value',
                            index: 'value',
                            width: 220,
                            sortable: false,
                            align: 'center'
                        },
                    ],
                    rowNum: 10,
                    rowList: [5, 10, 25, 50, 100],
                    pager: '#' + childGridPagerID2,
                    viewrecords: true,
                    height: '100%'
                });
            }
        });
    </script>
</head>
<body>
    <h2>Categor&iacute;as y productos</h2>

    <table id="list"></table>

    <div id="pager"></div>
</body>
</html>