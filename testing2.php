<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        
        <style type="text/css">
		
		/* These inline styles will always be active even if an alternate
		   stylesheet is selected with the stylesheet swticher */
		
		#example {
		 float:right;
		 width:400px;
		}
		
		#example div {
		}
		
		#div-before, #div-after {
		 background-color:#88d;
		 color:#000;
		}
		#div-1 {
		 background-color:#000;
		 color:#fff;
		}
		#div-1-padding {
		 padding:10px;
		}
		#div-1a {
		 background-color:#d33;
		 color:#fff;
		}
		#div-1b {
		 background-color:#3d3;
		 color:#fff;
		}
		#div-1c {
		 background-color:#33d;
		 color:#fff;
		}
		#example div p {
		 margin:0 .25em;
		 padding:.25em 0;
		}
		#description {
		 float:left;
		 width:40%;
		}
		pre {
		 padding:1em;
		 border:1px dashed #aaa;
		 background:#fafafa;
		}
		p {
		 margin:0.5em 0;
		}
		h3 {
		 color:#999;
		}
		
		.job {
		margin-top:1em;
		border:1px solid #aaa;
		padding:1em;
		background:#ddd;
		}
		</style>
        
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
       
	   	
       
		<div id="example">

            <div id="div-before">
            	<p>id = div-before</p>
            </div>
            
            <div id="div-1">
            	<div id="div-1-padding">
            		<p>id = div-1</p>
            
            		<div id="div-1a">
           				<p>id = div-1a</p>
            			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer pretium dui sit amet felis. Integer sit amet diam. Phasellus ultrices viverra velit.</p>
            		</div>
            
            		<div id="div-1b">
           				<p>id = div-1b</p>
            			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer pretium dui sit amet felis. Integer sit amet diam. Phasellus ultrices viverra velit. Nam mattis, arcu ut bibendum commodo, magna nisi tincidunt tortor, quis accumsan augue ipsum id lorem.</p>
            		</div>
            
            		<div id="div-1c">
                    	<p>id = div-1c</p>
                    </div>
            
            	</div>
            </div><!-- /id=div-1-padding /id=div-1 -->
            
            <div id="div-after">
            	<p>id = div-after</p>
            </div>
            
        </div><!-- /id=example -->
       

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
