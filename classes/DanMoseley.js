// Dan Moseley
// danomoseley@gmail.com
// JS Code Sample 2011
// JSON,JQuery,prototyping,classical inheritance,geolocation,google map APIv3,datatables

// Small segment of framework class heirarchy //
// Views are user facing segment
// Screens hold sets of views and help views navigate through the screen states
// Windows hold sets of screens, and allow for parallel screen states

// WINDOWS //

function Window(window,num,wall)
{
	this.wall = wall;
	this.window = window;
	this.currentScreen = undefined;
	this.name = window.ID;
	this.ID = window.ID;
	this.windowNum = num;
    this.screenNavWidth = 0;
	this.screens = {};
	this.screenLayout = [];
	var ref = this;
	this.lastHide = undefined;
	this.screenContainer = $("<div>").addClass("screenContainer");
	this.screenNav = $("<div>").addClass("screenNav");
	this.html = $("<div>").addClass("window").append(this.screenNav,this.screenContainer);	
		
	if(animations){
		this.screenContainer.addClass("animated");
	}
	this.screenContainer.css("height",(Object.size(window.screens)*100)+'%');
	
	var i=0;
	$.each(window.screens,function(name,screen){
		ref.screenLayout.push(screen.ID);
		ref.screens[screen.ID] = new Screen(screen,i,ref);
		ref.screenContainer.append(ref.screens[screen.ID].html);
		if(i==0) ref.currentScreen = ref.screens[screen.ID];
		if(screen.title){
			var theNav = $("<div>").addClass("button").draggable().html($(screen).attr("title")).click(function(){
				$(".active",ref.screenNav).removeClass("active");
				$(this).addClass("active");
				ref.changeScreen(ref.screens[screen.ID]);
			});
			ref.screenNav.append(
				theNav
			);
			ref.screenNavWidth += 140;
		}
		i++;
	});
	ref.screenNav.width(ref.screenNavWidth).css("margin-left",(-1*(ref.screenNavWidth/2))+"px");
	$(".screen",this.screenContainer).css("height",(100/Object.size(window.screens))+"%");
}

Window.prototype.scrollDown = function(){
	if(this.screenLayout[this.currentScreen.screenNum+1]!=undefined){
		this.changeScreen(this.screenLayout[this.currentScreen.screenNum+1]);	
	}
}

Window.prototype.scrollUp = function(){
	if(this.screenLayout[this.currentScreen.screenNum-1]!=undefined){
		this.changeScreen(this.screenLayout[this.currentScreen.screenNum-1]);	
	}
}

Window.prototype.center = function(){
	$(".screenContainer",this.html).removeClass("animated").css("margin-top",(-1*this.currentScreen.screenNum*getViewportHeight())+"px").toggleClass("animated");
	$.each(this.screens, function(key, value) { 
		value.center();
	});
}

Window.prototype.changeScreen = function(screen,hide){
	if(hide == undefined) hide = true;
	if(screen){
		if(hide){
			$(".viewContainer",this.screenContainer).hide();
			this.currentScreen.viewContainer.show();
			clearTimeout(this.lastHide);
			var lastScreen = this.currentScreen;
			if(lastScreen.ID != screen.ID){
				this.lastHide = setTimeout(function(){ lastScreen.viewContainer.hide(); },500);
			}
			screen.viewContainer.show();
		}
		
		if(this.currentScreen){
			if(this.currentScreen.screenID != screen.screenID){
				var ref = this.currentScreen.obj;
			}	
		}
		
		this.screenContainer.css("margin-top",(-1*screen.screenNum*getViewportHeight())+"px");
		this.currentScreen = screen;
		
		localStorage[GLOBAL_appVersion + "_" + this.wall.ID + "_currentScreen"] = this.currentScreen.ID;
		return screen;
	}
}

Window.prototype.changeScreenByID = function(ID,hide){
	this.changeScreen(this.screens[ID],hide);
}	

// SCREEN //

function Screen(screen,num,window2)
{
	this.window = window2;
	this.ID = screen.ID;
	this.currentView = undefined;
	this.screenNum = undefined;
	this.form = undefined;
	this.viewHistory = new Array();
	if(num!=undefined){
		this.screenNum = num;
	}
	this.views = {};
	var ref = this;
	this.viewContainer = $("<div>").addClass("viewContainer wide");
	this.html = $("<div>").addClass("screen").append(this.viewContainer);
	
	if(screen.views){
		$.each(screen.views,function(i,view){
			if(view.ID == undefined && i==0) view.ID  = "default";
			if(view.ID  == undefined && i>0) view.ID  = "default"+i;
			
			var win = undefined;
			if(window[view.viewType]){
				win = new window[view.viewType](view,ref)
				ref.views[view.ID] = win;
				
			}else{
				win = new View(view,ref)
				ref.views[view.ID] = win;
			}
			ref.viewContainer.append(win.html);
			if(ref.viewHistory.length == 0){
				ref.viewHistory.push(view.ID);
				win.html.addClass("active frontSide");
				$(".goBack",win.html).hide();
			}else{
				win.html.hide();
			}
			if(ref.currentView == undefined){
				ref.currentView = ref.views[view.ID];
			}
		});
	}
}

Screen.prototype.center = function(){
	$.each(this.views, function(key, value) { 
		value.center();
	});
}

Screen.prototype.changeView = function(viewID,refresh){
	if(refresh == undefined) refresh = true;
	if(this.views[viewID]){
		if(this.viewHistory[this.viewHistory.length-1] != viewID){
			this.viewHistory.push(viewID);
			$(".view",this.viewContainer).removeClass("backSide").hide();
			$(".view.active",this.viewContainer).addClass("backSide").removeClass("active").removeClass("frontSide").removeClass("active");
			this.views[viewID].html.addClass("active frontSide").show();
			if(refresh && this.views[viewID].refresh){
				this.views[viewID].refresh();
			}
			$(".viewNav",this.views[viewID].html).forceRedraw(true);
		}
	}else{
		console.log("View " + viewID + " not found");
	}
}

// VIEW // 

function View(view,screen)
{
	this.screen = screen;
	this.view=view;
	var ref = this;
	this.theDataTable = undefined;
	this.filters = {};
	this.content = $("<div style='width:100%;height:100%;-moz-box-sizing:border-box;-webkit-box-sizing: border-box;box-sizing:border-box;'>").addClass("content");	
	this.html = $("<div>").addClass("view").append(this.content);;
	
	this.html.addClass("rounded");
	this.html.addClass("shadow");
	
	if(view && view.cssClass){
		this.html.addClass(view.cssClass);
	}
	
	$(document).ready(function(){
		ref.center();
	});
	
	$(window).resize(function(){
		ref.resize();
	});
	this.addNav();
}

View.prototype.setObj = function(obj){
	this.obj = obj;
	this.addNav();
}

View.prototype.defaultAjaxParameters = function(){
	var data = {};
	data["sessionID"] = IDS.getSession();
	if(IDS.lastLocation){
		data["latitude"] = IDS.lastLocation.coords.latitude;
		data["longitude"] = IDS.lastLocation.coords.longitude;
	}
	return data;
}

View.prototype.addNav = function(){
	var ref = this;
	if(this.view && this.view.title){
		this.html.prepend(
			$("<div>").addClass("viewNav").append(
				ref.goBack ? 
				$("<div>").addClass("goBack").click(function(){
					ref.goBack();
				}) : "",
				$("<h2 class='viewTitle'>").html(this.view.title),
				ref.refresh ? 
				$("<div>").addClass("refresh").click(function(){
					ref.refresh();
				}) : "",
				ref.map ? 
				$("<div>").addClass("map").click(function(){
					ref.map();
				}) : ""
			)
		);
	}
}

View.prototype.loading = function(){
	$(this.html).append(
		$("<div>").addClass("loading rounded").click(function(){
			$(this).remove();
		})
	);
}

View.prototype.complete = function(){
	$(".loading",this.html).remove();
}
 
View.prototype.center = function()
{
	var windowHidden = false;
	var viewHidden = false;
	if(!$(this.obj).parent().parent().is(":visible")) windowHidden = true;
	if(!$(this.obj).is(":visible")) viewHidden = true;
	
	if(windowHidden) $(this.obj).parent().parent().show();
	if(viewHidden) $(this.obj).show();
	
    $(this.html).css("margin-top",(getViewportHeight()-parseInt($(this.html).css("max-height"))+$(".viewNav",this.html).outerHeight(true))/2);
	
	if(windowHidden) $(this.obj).parent().parent().hide();
	if(viewHidden) $(this.obj).hide();
}

View.prototype.getMaxRows = function(){
	var exHeight = $(this.html).height() - ($(".dataTables_wrapper",this.html).outerHeight(true) - $(".dataTables_wrapper table",this.html).outerHeight(true) + $(".filters",this.html).outerHeight(true) + 75);	
	return parseInt((exHeight-$(".dataTables_wrapper tr",this.html).outerHeight(true))/$(".dataTables_wrapper tr",this.html).outerHeight(true));
}

View.prototype.resize = function(){	
	if(this.theDataTable != undefined){
		this.theDataTable.fnSettings()._iDisplayLength = this.getMaxRows();
		this.theDataTable.fnDraw();
	}
}

View.prototype.createTable = function(table,data,columns,theDataTable){
	var ref = this;
	
	if(theDataTable == undefined){
		theDataTable = $(table).dataTable({
			"aaData": data,
			"aoColumns": columns,
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": false,
			"iDisplayLength": 30,
			"bFilter": true,
			"bSort": true,
			"bInfo": false,
			"bAutoWidth": false,
			"bRetrive": true,
			"bDestroy": true,
			"sDom": 'lftip',
			"fnDrawCallback": function() {
				$("tbody tr",table).unbind();
				$("tbody tr",table).bind('click',function(event) {
					var aData = ref.theDataTable.fnGetData( event.target.parentNode );
					ref.loadDetail(aData);
				});
			}
		});
	}else{
		theDataTable.fnClearTable();
		theDataTable.fnAddData(data);
	}
	return theDataTable;
}

View.prototype.makeTable = function(table,data,columns,aaSorting,rowSelectFunction){
	var ref = this;
	var theDataTable = table.dataTable({
		"aaData": data,
		"aoColumns": columns,
		"bPaginate": true,
		"sPaginationType": "full_numbers",
		"bLengthChange": false,
		"iDisplayLength": 10,
		"bFilter": true,
		"bSort": true,
		"bInfo": false,
		"bAutoWidth": false,
		"bRetrive": true,
		"bDestroy": true,
		"sDom": 'lftip',
		"fnDrawCallback": function() {
			if(rowSelectFunction!=undefined){
				$("tbody tr",table).unbind();
				$("tbody tr",table).bind('click',function(event) {
					var aData = theDataTable.fnGetData( event.target.parentNode );
					rowSelectFunction(aData);
				});
			}
		},
		"aaSorting": aaSorting
	});
	table.forceRedraw(true);
	
	return theDataTable;
}

View.prototype.goBack = function(){
	this.screen.viewHistory.pop();
	var lastScreenID = this.screen.viewHistory.pop();
	this.screen.changeView(lastScreenID);
}

View.prototype.initializeMap = function(){
	var id = (new Date()).getTime();
	this.mapDiv = $("<div style='height:100%;width:100%;'>").attr("id",id);
	$("body").append(this.mapDiv);
	var myOptions = {
	  zoom: 8,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	this.googleMap = new google.maps.Map(document.getElementById(id),
		myOptions);
	this.googleMap.setCenter(new google.maps.LatLng(IDS.lastLocation.coords.latitude,IDS.lastLocation.coords.longitude));
	this.mapMarkers = [];
	$("body #"+id).remove();
}

View.prototype.writeDataMap = function(data,callback){
	if(!this.googleMap) this.initializeMap();
	
	var ref = this;
	
	for( i in this.mapMarkers){
		this.mapMarkers[i].setMap(null);
	}
	
	var bounds = new google.maps.LatLngBounds();
	$.each(data,function(k,markerData){
		if(markerData.Latitude && markerData.Longitude){
			var loc = new google.maps.LatLng(markerData.Latitude, markerData.Longitude);	
			var pin = new google.maps.Marker({
				map: ref.googleMap,
				position: loc,
				draggable: true
			});
			google.maps.event.addListener(pin, 'click', function(){ callback(markerData); });
			ref.mapMarkers.push(pin);
			bounds.extend(loc);
		}
	});
	ref.googleMap.fitBounds(bounds);
	
	
	return this.mapDiv;	
}

// UserDetail (Instance of View) //

UserDetail.prototype = new View();
function UserDetail(view,screen)
{
	View.apply(this, arguments);
	this.getCurrentUser();
}

UserDetail.prototype.getCurrentUser = function(){
	var ref = this;
	if(!appData.currentUser){
		$.ajax({
			url: APP_PATH + 'app.asmx/getCurrentUser',
			type: 'POST',
			cache: false,
			data: ref.defaultAjaxParameters(),
			dataType: "json",
			traditional: true,
			success: function (data) {
				if(data.success == "true"){
					for (userID in data.json.user.collection) break;
					appData["currentUser"] = data.json.user.collection[userID];
					ref.load(appData["currentUser"]);
					ref.paint();
				}
			}
		});
	}else{
		ref.load(appData["currentUser"]);
	}
}

UserDetail.prototype.load = function(user){
	this.user = new Data(user);
	this.user.dataType = "User";
}

UserDetail.prototype.paintInfo = function(){
	var ref = this;	
	
	this.info = $("<div class='info'>").append(
		$("<div class='label'>").html("First Name"),$("<div class='value'>").html(ref.user.FirstName),
		$("<div class='label'>").html("Last Name"),$("<div class='value'>").html(ref.user.LastName),
		
		$("<div class='label'>").html("Phone Number"),$("<div class='value'>").html(ref.user.Phone),
		$("<div class='label'>").html("Email"),$("<div class='value'>").html(ref.user.Email)
	);
	
	return this.info;
}

UserDetail.prototype.paintAddDevice = function(){
	var ref = this;
	var reset = $("<div style='clear:both;'>").append(
		$("<input type='submit' value='Add New Device'>").click(function(){
			var data = {};
			data["userID"] = ref.user.ID;	
			
			$.ajax({
				url: APP_PATH + 'app.asmx/addFieldDevice',
				type: 'POST',
				cache: false,
				data: $.extend(data,ref.defaultAjaxParameters()),
				dataType: "json",
				traditional: true,
				success: function (data) {
					if(data.success == "true"){
						ref.refresh();
					}
				}
			});
		})
	);
	
	return reset;
}

UserDetail.prototype.paintInfoEdit = function(){
	var ref = this;	
	
	this.info = $("<div class='info'>").append(
		$("<div class='label'>").html("Username"),$("<div class='value'>").html(ref.user.Username),
		$("<div class='label'>").html("First Name"),$("<div class='value'>").append(
			$("<input type='text'>").val(ref.user.FirstName).change(function(){
				ref.user.set("FirstName",$(this).val());
			})
		),
		$("<div class='label'>").html("Last Name"),$("<div class='value'>").append(
			$("<input type='text'>").val(ref.user.LastName).change(function(){
				ref.user.set("LastName",$(this).val());
			})
		),
		$("<div class='label'>").html("Phone Number"),$("<div class='value'>").append(
			$("<input type='text'>").val(ref.user.Phone).change(function(){
				ref.user.set("Phone",$(this).val());
			})
		),
		$("<div class='label'>").html("Email"),$("<div class='value'>").append(
			$("<input type='text'>").val(ref.user.Email).change(function(){
				ref.user.set("Email",$(this).val());
			})
		)
	);
	
	return this.info;
}

UserDetail.prototype.paint = function(){
	this.content.html("");
	this.content.append(
		this.paintInfoEdit(),
		this.paintAddDevice(),
		this.paintDeviceList()
	);
	this.content.forceRedraw(true);
}

UserDetail.prototype.paintDeviceList = function(view){	
	var ref = this;
	var data = {};
	data["userID"] = this.user.ID;	
	
	var deviceList = $("<table>").append("<thead>","<tbody>");
	
	var deviceSection = $("<div style='clear:both;'>").append(
		deviceList
	);
	
	$.ajax({
		url: APP_PATH + 'app.asmx/getDeviceList',
		type: 'POST',
		cache: false,
		data: $.extend(data,ref.defaultAjaxParameters()),
		dataType: "json",
		traditional: true,
		success: function (data) {
			if(data.success == "true"){
				
				ref.devices = new collection(data.json.device.collection,"FieldDevice");
				var columns = [
					{"sTitle": "ID", "mDataProp": "ID"},
					{"sTitle": "Active", "mDataProp": "ActiveType"},
					{"sTitle": "Name", "mDataProp": "Name", "bVisible": false},
					{"sTitle": "Name", "mDataProp": "NameEdit","iDataSort": 2},
					{"sTitle": "Auth Code", "mDataProp": "AuthorizationCode"},					
					{"sTitle": "Billing", "mDataProp": "BillingID", "bVisible": false},
					{"sTitle": "Billing", "mDataProp": "BillingIDEdit","iDataSort": 5},
					{"sTitle": "LastActivity", "mDataProp": "LastActivity"},
					{"sTitle": "Current", "mDataProp": "currentDevice", "bVisible": false},
					{"sTitle": "Current", "mDataProp": "currentDeviceCheck","iDataSort": 8},
					
				];
				
				var theDataTable = deviceList.dataTable({
					"aaData": ref.devices.array,
					"aoColumns": columns,
					"bPaginate": true,
					"sPaginationType": "full_numbers",
					"bLengthChange": false,
					"iDisplayLength": 11,
					"bFilter": true,
					"bSort": true,
					"bInfo": false,
					"bAutoWidth": false,
					"bRetrive": true,
					"bDestroy": true,
					"sDom": 'lftip',
					"aaSorting": [[ 9, "desc" ],[ 7, "desc" ]]
				});
				$("tr",deviceList).click(function(event) {
					var aData = theDataTable.fnGetData( event.target.parentNode );
					if(!aData) aData = theDataTable.fnGetData( event.target.parentNode.parentNode );
					var fieldDeviceDetail = ref.screen.views["10018"];
					fieldDeviceDetail.load(aData);
					fieldDeviceDetail.paint();
					ref.screen.changeView("10018",false);
				});
				$("tr input:not([disabled='disabled'])",deviceList).click(function(event){
					event.preventDefault();
					return false;
				});
				
				$("tr input",deviceList).change(function(event){
					var aData = theDataTable.fnGetData( event.target.parentNode.parentNode );
					aData.set($(this).attr("fieldname"),$(this).val());
					return false;
				});
				deviceList.forceRedraw(true);
			}
		}
	});
	
	return deviceSection;
}

UserDetail.prototype.refresh = function(){
	this.info = this.paint();
}
