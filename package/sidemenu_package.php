<div class="wrapper ">
    <div class="sidebar" data-color="lightblue">
        <div class="logo">
            <a href="/" class="simple-text logo-mini">
                <img src="/img/logo.png" />
            </a>
            <a href="/" class="simple-text logo-normal">
          Usage Data
        </a>

        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="dropdown">
                    <a href="/package" id="dropdownsumm" role="button"><i class="material-icons">home</i> Consortium Summary</a>
                </li>
                <hr />
                <li class="dropdown">
                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownvendor" role="button"><i class="material-icons">shopping_cart</i> Vendors</a>
                    <div style="width:98%">
                        <div aria-labelledby="dropdownvendor" class="optionmenu dropdown-menu">
								<?php
								  foreach ($allvendors as $db){
									  echo '<a class="dropdown-item" href="vendor.php?product=' . $db['vendor_abbrev'] . '">' . $db['Vendor'] . '</a>';
								  }
								  ?>
							</div>
						</div>
					</li>
					<li class="dropdown">
						<a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownMenuLink" role="button"><i class="material-icons">laptop_mac</i> Databases</a>
						<div aria-labelledby="dropdownMenuLink" class="optionmenu dropdown-menu">
							<?php
							  foreach ($alldatabases as $db){
								  echo '<a class="dropdown-item" href="database.php?product=' . $db['product_abbrev'] . '">' . $db['Product'] . '</a>';
							  }
							  ?>
						</div>
					</li>
					<li class="dropdown">
						<a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownjournal" role="button"><i class="material-icons">description</i> Journals</a>
						<div aria-labelledby="dropdownjournal" class="optionmenu dropdown-menu">
							<?php
								  foreach ($alljournals as $db){
									  echo '<a class="dropdown-item" href="journal.php?product=' . $db['product_abbrev'] . '">' . $db['Product'] . '</a>';
								  }
							              ?>
						</div>
					</li>
					<li class="dropdown">
						<a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownbook" role="button"><i class="material-icons">import_contacts</i> E-Books</a>
						<div aria-labelledby="dropdownbook" class="optionmenu dropdown-menu">
							<?php
							  foreach ($allebooks as $db){
								  echo '<a class="dropdown-item" href="ebook.php?product=' . $db['product_abbrev'] . '">' . $db['Product'] . '</a>';
							  }
							            ?>
						</div>
                </li>
                <hr />
                <li>
                    <a aria-controls="datemenu" aria-expanded="false" data-toggle="collapse" href="#datemenu" role="button"><i class="material-icons">date_range</i>
                                        <p>Set Date Range</p></a>
                </li>
                <li class="collapse" id="datemenu">
                    <ul class="nav" id="datemenu">
                        <li>
                            <input id='rangerec' name='range' type='radio' value='recent'>
                            <label for='rangerec'>Most Recent Year</label>
                        </li>
                        <li>
                            <input id='rangeall' name='range' type='radio' value='all'>
                            <label for='rangeall'>All Dates</label>
                        </li>
                        <li>
                            <input type='radio' value='custom' name='range' id='rangecustom' />
                            <label for='rangecustom' data-toggle="collapse" href="#collapsedates" aria-expanded="false" aria-controls="collapsedates">Custom Range</label>
                            <div class="collapse" id="collapsedates">
                
                                <div class="nav-link">
                
                                    <div class="form-group row">
                
                                        <div class="input-group">
                
                                            <div class="input-group-prepend">Start
                
                                            </div>
                
                                            <input type="text" id="startdate" name="startdate" class="date-picker" autocomplete="off" aria-describedby="basic-addon1">
                
                                        </div>
                
                                        <div class="input-group">
                
                                            <div class="input-group-prepend">
                                                End
                
                                            </div>
                
                                            <input type="text" id="enddate" name="enddate" class="date-picker" autocomplete="off" aria-describedby="basic-addon2">
                
                                        </div>
                                        <button class="btn btn-blue btn-xs" id="reload" onclick="reloadpack()">Reload Data</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                </li>
                
                </ul>
                
                </div>
                
                </div>