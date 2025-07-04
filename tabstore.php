<style>
    body {
  padding : 10px ;
  
}

#exTab1 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

#exTab2 h3 {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

/* remove border radius for the tab */

#exTab1 .nav-pills > li > a {
  border-radius: 0;
}

/* change border radius for the tab , apply corners on top*/

#exTab3 .nav-pills > li > a {
  border-radius: 4px 4px 0 0 ;
}

#exTab3 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}





</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<div class="container"><h1>Bootstrap  tab panel example (using nav-pills)  </h1></div>
<div id="exTab1" class="container">	
<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#1a" data-toggle="tab">Overview</a>
			</li>
			<li><a href="#2a" data-toggle="tab">Using nav-pills</a>
			</li>
			<li><a href="#3a" data-toggle="tab">Applying clearfix</a>
			</li>
  		<li><a href="#4a" data-toggle="tab">Background color</a>
			</li>
		</ul>

			<div class="tab-content clearfix">
			  <div class="tab-pane active" id="1a">
          <h3>Content's background color is the same for the tab</h3>
				</div>
				<div class="tab-pane" id="2a">
          <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
				</div>
        <div class="tab-pane" id="3a">
          <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
				</div>
          <div class="tab-pane" id="4a">
          <h3>We use css to change the background color of the content to be equal to the tab</h3>
				</div>
			</div>
  </div>


<hr></hr>
<div class="container"><h2>Example tab 2 (using standard nav-tabs)</h2></div>

<div id="exTab2" class="container">	
<ul class="nav nav-tabs">
			<li class="active">
        <a  href="#1" data-toggle="tab">Overview</a>
			</li>
			<li><a href="#2" data-toggle="tab">Without clearfix</a>
			</li>
			<li><a href="#3" data-toggle="tab">Solution</a>
			</li>
		</ul>

			<div class="tab-content ">
			  <div class="tab-pane active" id="1">
          <h3>Standard tab panel created on bootstrap using nav-tabs</h3>
				</div>
				<div class="tab-pane" id="2">
          <h3>Notice the gap between the content and tab after applying a background color</h3>
				</div>
        <div class="tab-pane" id="3">
          <h3>add clearfix to tab-content (see the css)</h3>
				</div>
			</div>
  </div>

<hr></hr>

<div class="container"><h2>Example 3 </h2></div>
<div id="exTab3" class="container">	
<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#1b" data-toggle="tab">Overview</a>
			</li>
			<li><a href="#2b" data-toggle="tab">Using nav-pills</a>
			</li>
			<li><a href="#3b" data-toggle="tab">Applying clearfix</a>
			</li>
  		<li><a href="#4a" data-toggle="tab">Background color</a>
			</li>
		</ul>

			<div class="tab-content clearfix">
			  <div class="tab-pane active" id="1b">
          <h3>Same as example 1 but we have now styled the tab's corner</h3>
				</div>
				<div class="tab-pane" id="2b">
          <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
				</div>
        <div class="tab-pane" id="3b">
          <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
				</div>
          <div class="tab-pane" id="4b">
          <h3>We use css to change the background color of the content to be equal to the tab</h3>
				</div>
			</div>
  </div>


<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>