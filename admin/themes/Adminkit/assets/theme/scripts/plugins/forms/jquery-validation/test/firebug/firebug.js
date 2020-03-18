<!DOCTYPE html>
<html id="html">
<head>
	<title>jQuery - Validation Test Suite</title>
	<link rel="Stylesheet" media="screen" href="qunit/qunit.css" />
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="../lib/jquery.form.js"></script>
	<script type="text/javascript" src="qunit/qunit.js"></script>
	<script type="text/javascript" src="../lib/jquery.metadata.js"></script>
	<script type="text/javascript" src="../lib/jquery.mockjax.js"></script>
	<script type="text/javascript" src="../jquery.validate.js"></script>
	<script type="text/javascript" src="../additional-methods.js"></script>
	<script type="text/javascript" src="test.js"></script>
	<script type="text/javascript" src="rules.js"></script>
	<script type="text/javascript" src="messages.js"></script>
	<script type="text/javascript" src="methods.js"></script>
</head>
<body id="body">
	<h1 id="qunit-header">
		<a href="http://bassistance.de/jquery-plugins/jquery-plugin-validation/">jQuery Validation Plugin</a> Test Suite
		<a href="?jquery=1.3.2">jQuery 1.3.2</a>
		<a href="?jquery=1.4.2">jQuery 1.4.2</a>
		<a href="?jquery=1.4.4">jQuery 1.4.4</a>
		<a href="?jquery=1.5.2">jQuery 1.5.2</a>
		<a href="?jquery=1.6.1">jQuery 1.6.1</a>
		<a href="?jquery=1.7.2">jQuery 1.7.2</a>
		<a href="?jquery=git">jQuery Latest (git)</a>
		</h1>
	<div>
	</div>
	<h2 id="qunit-banner"></h2>
	<div id="qunit-testrunner-toolbar"></div>
	<h2 id="qunit-userAgent"></h2>
	<ol id="qunit-tests"></ol>

	<!-- Test HTML -->
	<div id="other" style="display:none;">
		<input type="password" name="pw1" id="pw1" value="engfeh" />
		<input type="password" name="pw2" id="pw2" value="" />
	</div>
	<div id="qunit-fixture">
		<p id="firstp">See <a id="simon1" href="http://simon.incutio.com/archive/2003/03/25/#getElementsBySelector" rel="bookmark">this blog entry</a> for more information.</p>
		<p id="ap">
			Here are some links in a normal paragraph: <a id="google" href="http://www.google.com/" title="Google!">Google</a>,
			<a id="groups" href="http://groups.google.com/">Google Groups</a>.
			This link has <code><a href="#" id="anchor1">class="blog"</a></code>:
			<a href="http://diveintomark.org/" class="blog" hreflang="en" id="mark">diveintomark</a>

		</p>
		<div id="foo">
			<p id="sndp">Everything inside the red border is inside a div with <code>id="foo"</code>.</p>
			<p lang="en" id="en">This is a normal link: <a id="yahoo" href="http://www.yahoo.com/" class="blogTest">Yahoo</a></p>
			<p id="sap">This link has <code><a href="#2" id="anchor2">class="blog"</a></code>: <a href="http://simon.incutio.com/" class="blog link" id="simon">Simon Willison's Weblog</a></p>

		</div>
		<p id="first">Try them out:</p>
		<ul id="firstUL"></ul>
		<ol id="empty"></ol>

		<form id="testForm1">
			<input type="text" class="{required:true,minlength:2}" title="buga" name="firstname" id="firstname" />
			<label id="errorFirstname" for="firstname" class="error">error for firstname</label>
			<input type="text" class="{required:true}" title="buga" name="lastname" id="lastname" />
			<input type="text" class="{required:true}" title="something" name="something" id="something" value="something" />
		</form>

		<form id="testForm1clean">
			<input title="buga" name="firstname" id="firstnamec" />
			<label id="errorFirstname" for="firstname" class="error">error for firstname</label>
			<input title="buga" name="lastname" id="lastnamec" />
			<input name="username" id="usernamec" />
		</form>

		<form id="userForm">
			<input type="text" class="{required:true}" name="username" id="username" />
			<input type="submit" name="submitButton" value="submitButtonValue" />
		</form>

		<form id="signupForm" action="form.php">
			<input id="user" name="user" title="Please enter your username (at least 3 characters)" class="{required:true,minlength:3}" />
			<input type="password" name="password" id="password" class="{required:true,minlength:5}" />
		</form>

		<form id="testForm2">
			<input class="{required:true}" type="radio" name="agree" id="agb" />
			<label for="agree" id="agreeLabel" class="xerror">error for agb</label>
		</form>

		<form id="testForm3">
			<select class="{required:true}" name="meal" id="meal" >
				<option value="">Please select...</option>
				<option value="1">Food</option>
				<option value="2">Milk</option>
			</select>
		</form>
		<div class="error" id="errorContainer">
			<ul>
				<li class="error" id="errorWrapper">
					<label for="meal" id="mealLabel" class="error">error for meal</label>
				</li>
			</ul>
		</div>

		<form id="testForm4">
			<input class="{foo:true}" name="f1" id="f1" />
			<input class="{bar:true}" name="f2" id="f2" />
		</form>

		<form id="testForm5">
			<input class="{equalTo:'#x2'}" value="x" name="x1" id="x1" />
			<input class="{equalTo:'#x1'}" value="y" name="x2" id="x2" />
		</form>

		<form id="testForm6">
			<input class="{required:true,minlength:2}" type="checkbox" name="check" id="form6check1" />
			<input type="checkbox" name="check" id="form6check2" />
		</form>

		<form id="testForm7">
			<select class="{required:true,minlength:2}" name="selectf7" id="selectf7" multiple="multiple">
				<option id="optionxa" value="0">0</option>
				<option id="optionxb" value="1">1</option>
				<option id="optionxc" value="2">2</option>
				<option id="optionxd" value="3">3</option>
			</select>
		</form>

		<form id="dateRangeForm">
			<input id="fromDate" name="fromDate" class="requiredDateRange" value="x" />
			<input id="toDate" name="toDate" class="requiredDateRange" value="y" />
			<span class="errorContainer"></span>
		</form>

		<form id="testForm8">
			<input id="form8input" class="{required:true,number:true,rangelength:[2,8]}" name="abc" />
			<input type="radio" name="radio1"/>
		</form>

		<form id="testForm9">
			<input id="testEmail9" class="{required:true,email:true,messages:{required:'required',email:'email'}}" />
		</form>

		<form id="testForm10">
			<input type="radio" name="testForm10Radio" value="1" id="testForm10Radio1" />
			<input type="radio" name="testForm10Radio" value="2" id="testForm10Radio2" />
		</form>

		<form id="testForm11">
			<!-- HTML5 -->
			<input required type="text" name="testForm11Text" id="testForm11text1" />
		</form>

		<form id="testForm12">
			<!-- empty "type" attribute -->
			<input name="testForm12text" id="testForm12text" class="{required:true}" />
		</form>

		<form id="dataMessages">
			<input name="dataMessagesName" id="dataMessagesName" class="required" data-msg-required="You must enter a value here" />
		</form>

		<div id="simplecontainer">
			<h3></h3>
		</div>

		<div id="container"></div>

		<ol id="labelcontainer"></ol>

		<form id="elementsOrder">
			<select class="required" name="order1" id="order1"><option value="">none</option></select>
			<input class="required" name="order2" id="order2"/>
			<input class="required" name="order3" type="checkbox" id="order3"/>
			<input class="required" name="order4" id="order4"/>
			<input class="required" name="order5" type="radio" id="order5"/>
			<input class="required" name="order6" id="order6"/>
			<ul id="orderContainer">
			</ul>
		</form>

		<form id="form" action="formaction">
			<input type="text" name="action" value="Test" id="text1"/>
			<input type="text" name="text2" value="   " id="text1b"/>
			<input type="text" name="text2" value="T " id="text1c"/>
			<input type="text" name="text2" value="T" id="text2"/>
			<input type="text" name="text2" value="TestTestTest" id="text3"/>

			<input type="text" name="action" value="0" id="value1"/>
			<input type="text" name="text2" value="10" id="value2"/>
			<input type="text" name="text2" value="1000" id="value3"/>

			<input type="radio" name="radio1" id="radio1"/>
			<input type="radio" name="radio1" id="radio1a"/>
			<input type="radio" name="radio2" id="radio2" checked="checked"/>
			<input type="radio" name="radio" id="radio3"/>
			<input type="radio" name="radio" id="radio4" checked="checked"/>

			<input type="checkbox" name="check" id="check1" checked="checked"/>
			<input type="checkbox" name="check" id="check1b" />

			<input type="checkbox" name="check2" id="check2"/>

			<input type="checkbox" name="check3" id="check3" checked="checked"/>
			<input type="checkbox" name="check3" checked="checked"/>
			<input type="checkbox" name="check3" checked="checked"/>
			<input type="checkbox" name="check3" checked="checked"/>
			<input type="checkbox" name="check3" checked="checked"/>

			<input type="hidden" name="hidden" id="hidden1"/>
			<input type="text" style="display:none;" name="foo[bar]" id="hidden2"/>

			<input type="text" readonly="readonly" id="name" name="name" value="name" />

			<button name="button">Button</button>

			<textarea id="area1" name="area1">foobar</textarea>


			<textarea id="area2" name="area2"></textarea>

			<select name="select1" id="select1">
				<option id="option1a" value="">Nothing</option>
				<option id="option1b" value="1">1</option>
				<option id="option1c" value="2">2</option>
				<option id="option1d" value="3">3</option>
			</select>
			<select name="select2" id="select2">
				<option id="option2a" value="">Nothing</option>
				<option id="option2b" value="1">1</option>
				<option id="option2c" value="2">2</option>
				<option id="option2d" selected="selected" value="3">3</option>
			</select>
			<select name="select3" id="select3" multiple="multiple">
				<option id="option3a" value="">Nothing</option>
				<option id="option3b" selected="selected" value="1">1</option>
				<option id="option3c" selected="selected" value="2">2</option>
				<option id="option3d" value="3">3</option>
			</select>
			<select name="select4" id="select4" multiple="multiple">
				<option id="option4a" selected="selected" value="1">1</option>
				<option id="option4b" selected="selected" value="2">2</option>
				<option id="option4c" selected="selected" value="3">3</option>
				<option id="option4d" selected="selected" value="4">4</option>
				<option id="option4e" selected="selected" value="5">5</option>
			</select>
			<select name="select5" id="select5" multiple="multiple">
				<option id="option5a" value="0">0</option>
				<option id="option5b" value="1">1</option>
				<option id="option5c" value="2">2</option>
				<option id="option5d" value="3">3</option>
			</select>
		</form>

		<form id="v2">
			<input id="v2-i1" name="v2-i1" class="required" />
			<input id="v2-i2" name="v2-i2" class="required email" />
			<input id="v2-i3" name="v2-i3" class="url" />
			<input id="v2-i4" name="v2-i4" class="required" minlength="2" />
			<input id="v2-i5" name="v2-i5" class="required" minlength="2" maxlength="5" customMethod1="123" />
			<input id="v2-i6" name="v2-i6" class="required customMethod2 {maxlength: 5}" minlength="2" />
			<input id="v2-i7" name="v2-i7" />
		</form>

		<form id="checkables">
			<input type="checkbox" id="checkable1" name="checkablesgroup" class="required" />
			<input type="checkbox" id="checkable2" name="checkablesgroup" />
			<input type="checkbox" id="checkable3" name="checkablesgroup" />
		</form>


		<form id="subformRequired">
			<div class="billingAddressControl">
            	<input type="checkbox" id="bill_to_co" name="bill_to_co" class="toggleCheck" checked="checked" style="width: auto;" tabindex="1" />
            	<label for="bill_to_co" style="cursor:pointer">Same as Company Address</label>
          	</div>
			<div id="subform">
				<input  maxlength="40" class="billingRequired" name="bill_first_name" size="20" type="text" tabindex="2" value="" />
			</div>
			<input id="co_name" class="required" maxlength="40" name="co_name" size="20" type="text" tabindex="1" value="" />
		</form>

		<form id="withTitle">
			<input class="required" name="hastitle" type="text" title="fromtitle" />
		</form>

		<form id="ccform" method="get" action="">
			<input id="cardnumber" name="cardnumber" />
		</form>

		<form id="productInfo">
			<input class="productInfo" name="partnumber">
			<input class="productInfo" name="description">
			<input class="productInfo" name="color">
			<input class="productInfo" type="checkbox" name="discount" />
		</form>

	</div>

</body>
</html>
