<html>
<head>
    <title>HTML Nested div positioning</title>
    <style type="text/css">
        .outerDiv {
            border: solid 1px #000000;
            width: 300px;
            height: 150px;
            position: relative;
            color: #000000;
            font-family: verdana;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
        }
        
        .nestedDivTL {
            background-color: #FF0000;
            width: 100px;
            position: relative;
			
        }
        
        .nestedDivTR {
            background-color: #0000FF;
            width: 100px;
            position: absolute;
            top: 10px;
            right: 10px;
			color: #FFFFFF;
        }
        
        .nestedDivBL {
            background-color: #CCCCCC;
            width: 100px;
            position: absolute;
            bottom: 10px;
            left: 10px;
        }
        
        .nestedDivBR {
            background-color: #FF8800;
            width: 100px;
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="outerDiv">
        <div class="nestedDivTL">
            div position top left
        </div>
        <div class="nestedDivTR">
            div position top right
        </div>
        <div class="nestedDivBL">
            div position bottom left
        </div>
        <div class="nestedDivBR">
            div position bottom right
        </div>
    </div>
</body>
</html>