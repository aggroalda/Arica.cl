
<!DOCTYPE html>
<html dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Google Custom Search</title>
<!--<script type="text/javascript" src="http://www.google.com.ni/jsapi"></script>
<script type="text/javascript">
google.load('search', '1', {language : 'es'});
function searchLoaded() {
var options = {};
options[google.search.Search.RESTRICT_SAFESEARCH] = google.search.Search.SAFESEARCH_STRICT;
options['adoptions'] = {'cseGoogleHosting': 'full'};
var customSearchControl = new google.search.CustomSearchControl(
"partner-pub-0449606115453329:2sqtncu4xiz"
, options);
customSearchControl.setRefinementStyle("link");
customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
customSearchControl.setMoreAds();
var options = new google.search.DrawOptions();
options.setSearchFormRoot('cse-search-form');
customSearchControl.draw('cse', options);
if (customSearchControl.startHistoryManagement(init)) {
customSearchControl.setLinkTarget(
google.search.Search.LINK_TARGET_SELF);
}
}
function init(customSearchControl) {
var num = customSearchControl.getWebSearcher().getNumResultsPerPage();
customSearchControl.execute("");
}
google.setOnLoadCallback(searchLoaded, true);
</script>-->
<link rel="stylesheet" href="//www.google.com/cse/style/look/default.css" type="text/css" />
<style type="text/css">
.gsc-control-cse {
font-family: Arial, sans-serif;
border-color: #336699;
background-color: #FFFFFF;
}
.gsc-control-cse .gsc-table-result {
font-family: Arial, sans-serif;
}
input.gsc-input {
border-color: #D9D9D9;
width:500px
}
input.gsc-search-button {
border-color: #666666;
background-color: #CECECE;
}
.gsc-tabHeader.gsc-tabhInactive {
border-color: #E9E9E9;
background-color: #E9E9E9;
}
.gsc-tabHeader.gsc-tabhActive {
border-top-color: #FF9900;
border-left-color: #E9E9E9;
border-right-color: #E9E9E9;
background-color: #FFFFFF;
}
.gsc-tabsArea {
border-color: #E9E9E9;
}
.gsc-webResult.gsc-result,
.gsc-results .gsc-imageResult {
border-color: #FFFFFF;
background-color: #FFFFFF;
}
.gsc-webResult.gsc-result:hover,
.gsc-imageResult:hover {
border-color: #FFFFFF;
background-color: #FFFFFF;
}
.gsc-webResult.gsc-result.gsc-promotion:hover {
border-color: #FFFFFF;
background-color: #FFFFFF;
}
.gs-webResult.gs-result a.gs-title:link,
.gs-webResult.gs-result a.gs-title:link b,
.gs-imageResult a.gs-title:link,
.gs-imageResult a.gs-title:link b {
color: #0000FF;
}
.gs-webResult.gs-result a.gs-title:visited,
.gs-webResult.gs-result a.gs-title:visited b,
.gs-imageResult a.gs-title:visited,
.gs-imageResult a.gs-title:visited b {
color: #4C4C4C;
}
.gs-webResult.gs-result a.gs-title:hover,
.gs-webResult.gs-result a.gs-title:hover b,
.gs-imageResult a.gs-title:hover,
.gs-imageResult a.gs-title:hover b {
color: #0000CC;
}
.gs-webResult.gs-result a.gs-title:active,
.gs-webResult.gs-result a.gs-title:active b,
.gs-imageResult a.gs-title:active,
.gs-imageResult a.gs-title:active b {
color: #0000CC;
}
.gsc-cursor-page {
color: #0000FF;
}
a.gsc-trailing-more-results:link {
color: #0000FF;
}
.gs-webResult .gs-snippet,
.gs-imageResult .gs-snippet,
.gs-fileFormatType {
color: #000000;
}
.gs-webResult div.gs-visibleUrl,
.gs-imageResult div.gs-visibleUrl {
color: #3D81EE;
}
.gs-webResult div.gs-visibleUrl-short {
color: #3D81EE;
}
.gs-webResult div.gs-visibleUrl-short {
display: none;
}
.gs-webResult div.gs-visibleUrl-long {
display: block;
}
.gs-promotion div.gs-visibleUrl-short {
display: none;
}
.gs-promotion div.gs-visibleUrl-long {
display: block;
}
.gsc-cursor-box {
border-color: #FFFFFF;
}
.gsc-results .gsc-cursor-box .gsc-cursor-page {
border-color: #E9E9E9;
background-color: #FFFFFF;
color: #0000FF;
}
.gsc-results .gsc-cursor-box .gsc-cursor-current-page {
border-color: #FF9900;
background-color: #FFFFFF;
color: #4C4C4C;
}
.gsc-webResult.gsc-result.gsc-promotion {
border-color: #336699;
background-color: #FFFFFF;
}
.gsc-completion-title {
color: #0000FF;
}
.gsc-completion-snippet {
color: #000000;
}
.gs-promotion a.gs-title:link,
.gs-promotion a.gs-title:link *,
.gs-promotion .gs-snippet a:link {
color: #0000CC;
}
.gs-promotion a.gs-title:visited,
.gs-promotion a.gs-title:visited *,
.gs-promotion .gs-snippet a:visited {
color: #0000CC;
}
.gs-promotion a.gs-title:hover,
.gs-promotion a.gs-title:hover *,
.gs-promotion .gs-snippet a:hover {
color: #0000CC;
}
.gs-promotion a.gs-title:active,
.gs-promotion a.gs-title:active *,
.gs-promotion .gs-snippet a:active {
color: #0000CC;
}
.gs-promotion .gs-snippet,
.gs-promotion .gs-title .gs-promotion-title-right,
.gs-promotion .gs-title .gs-promotion-title-right * {
color: #000000;
}
.gs-promotion .gs-visibleUrl,
.gs-promotion .gs-visibleUrl-short {
color: #008000;
}</style>
<style type="text/css">
body {
background-color: #FFFFFF;
color: #000000;
font-family: arial, sans-serif;width:700px
}
#cse-header {
width: 700px;
overflow: auto;

}
#cse-logo {
float: left;
border: none;
}
#cse-search-form {
width: 50px;
float: left;
padding-left: 16px;
}
#cse {
width: 100%;
}
#cse-footer {
clear: both;
font-size: 82%;
text-align: center;
padding: 16px;
}
.gsc-control-cse {
padding: 1%;
padding-top: 10px;
}
.gsc-branding {
display: none;
}
.gsc-adBlock {
padding-bottom: 10px;
}
.gs-webResult {
width: 42em;
padding: 2px 0;
}
.gsc-result .gs-title {
height: 1.25em;
}
.gs-title, .gs-promotion a {
font-weight: normal;
}
.gsc-results .gsc-cursor-box {
text-align: center;
width: 99%;
margin-left: auto;
margin-right: auto;
}
.gsc-webResult,
.gsc-imageResult-classic,
.gsc-imageResult-column {
margin-bottom: 10px;
padding: 0;
}
.gs-webResult div.gs-visibleUrl-short {
display: none;
}
.gs-webResult div.gs-visibleUrl-long {
display: block;
}
.gsc-clear-button {
display: none;
}
</style>
</head>
<body>
<noscript>
<h3>Google Custom Search requires JavaScript</h3>
<p>JavaScript is either disabled or not supported by your browser.
To use Custom Search, either:</p>
<ol>
<li>enable JavaScript by changing your browser options and reloading this page.</li>
<li>or, use our <a href="/cse?cx=partner-pub-0449606115453329:2sqtncu4xiz&ie=ISO-8859-1&q=&sa=Buscar&siteurl=///Idw02/D/AppServ/www/arica/0_SOURCE/indexgoogle.html&ref=&nojs=1">legacy HTML version</a>.
Some features may be missing from this version.</li>
</ol>
</noscript>
<div id="cse-hosted">
<div id="cse-header">
<a id="cse-logo-target" href="">
<img id="cse-logo" src="http://www.searchs.zobyhost.com/resources/img/searchs.jpg" height="24" />
</a>
<div id="cse-search-form">Loading</div>
</div>
<? /*?><div id="cse-body">
<div id="cse">Loading</div>
</div><? */ ?>
<div id="cse-footer">

</div>
</div>
</body>
</html>
