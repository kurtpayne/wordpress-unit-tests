    <div>
    <form onsubmit="return liveSearchSubmit()" id="searchform" name="searchform" method="get" action="/?s=">
    <input type="text" id="livesearch" name="s" value="search this site" onkeypress="liveSearchStart()" onblur="setTimeout('closeResults()',2000); if (this.value == '') {this.value = '';}"  onfocus="if (this.value == 'search this site') {this.value = '';}"  />
    <input type="submit" id="searchsubmit" style="display: none;" value="Search" />
    <div id="LSResult" style="display: none;"><div id="LSShadow"></div></div>
    </form>
    </div>
