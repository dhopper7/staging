 <div id="container">
	<div id="header">
    	<div class="box-content">
			<div id="logo">
				<a href="http://www.finley-cook.com" target= "_blank">
					<img alt="Finley & Cook" src="img/logo.png">
				</a>
        	</div>
<div id="navigation">
<ul class="nav-header">
    <li class="nav-selected"><a href="#charts">Charts</a></li>
    <li class="nav-selected"><a href="#reports">Reports</a></li>
    <li class="nav-selected"><a href="#contacts">Contacts</a></li>
    
    
</ul>
<div class="ccm-spacer"> </div>
</div>
        <div id="header-right">
          	<ul class="user-info">
        		<li class="nav-selected"><?php echo $user ?></li>
    			<li class="nav-selected"><?php echo date("F d, Y") ?></li>
                <li class="nav-selected"><a href="<?php echo "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes"; ?>">Logout</a></li>
        	</ul>
        </div>
        <div class="clearer"></div>
      </div><!-- end box-content -->
    </div><!-- end header -->
</div>