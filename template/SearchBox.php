
<div id="search-box" class="searchBox2">
			<div class="title">Vyhledávání</div>
		   	<form role="search" action="/search" method="get" class="">
				<div class="input-group">
				    <input type="text" class="form-control" value="<?php print $search_value; ?>" name="q" placeholder="<?php print $translator->prelozitFrazy("hledej_label"); ?>" id="srch-term">
				    <div class="input-group-btn">
				        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				    </div>
				</div>
	        </form>
		</div>

