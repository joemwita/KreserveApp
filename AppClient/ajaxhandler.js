// Before using Ajax in xdk, be sure you imported xhr.js in the index.html otherwise you will face same origin policy.

//In mobile app, instead of using alert use intel.xdk.notification.alert(message,title,buttontext); because alert showing name of the file like index.html in the title.

// In mobile app because we don't have same origin policy problem we must change urlprefix variable value: "http://www.kreserve.com".
var urlprefix = "http://www.kreserve.com";

function loading(showOrHide) {
    setTimeout(function(){
        $.mobile.loading(showOrHide);
    }, 1); 
	}

$(document).on('pagecreate',function(){ 
$(".localname").html(localStorage.name);
$(".localpoints").html("Total Points: "+localStorage.points);
return false;
});

$(document).ajaxSend(function() {
   loading('show');
   return false;
});
$(document).ajaxComplete(function() {
   loading('hide');
   return false;
	});

//This section is submitting the login form in the #Loginpanel. Ajax flag 1
$(document).on('pagecreate', '#Loginpanel', function(){  
	
 if(((localStorage.getItem("name") !== null) && (localStorage.getItem("name") != "")) && ((localStorage.getItem("email") !== null) && (localStorage.getItem("email") != ""))) {
	     //$.mobile.changePage("#afui");
 }	
 
	if((localStorage.getItem("firsttimeflag") === null) && (localStorage.getItem("firsttimeflag") != "1")){ // it means it is the first time user use this app after install so signup page is coming first instead of login page.
     $.mobile.changePage("#signuppanel");
	 localStorage.firsttimeflag = "1";
         }
		 
        $(document).on('click', '#submitlogin', function() {
            if($('#username').val().length > 0 && $('#pass').val().length > 0){
					//following function is converting all form values to one JSON format Object
					$.fn.serializeObject = function()
						{
							var o = {};
							var a = this.serializeArray();
							$.each(a, function() {
								if (o[this.name] !== undefined) {
									if (!o[this.name].push) {
										o[this.name] = [o[this.name]];
									}
									o[this.name].push(this.value || '');
								} else {
									o[this.name] = this.value || '';
								}
							});
							return o;
						};
					//Following line converts the JSON Format object to JSON Format string
					jsondata = JSON.stringify($('#loginform').serializeObject());
					
                    $.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {
                           // $.mobile.loading('show'); //show ajax spinner
                        },
                        complete: function() {
                            //$.mobile.loading('hide'); //hide ajax spinner
                        },
                        success: function (result) {
                            if(result.status) {
								localStorage.email = $('#username').val();
								localStorage.name = result.name;
								localStorage.points = result.points;
                                $.mobile.changePage("#afui");                         
                            } else {
                                alert(result.massage +' Please try again.'); 
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! please check your Internet connection.');
                        }
                    });                   
            } else {
                alert('Please enter your email and password.');
            }           
           return false;
        });
return false;		
});

//Sign up with ajaxflag 2.
$(document).on('pagecreate', '#signuppanel', function(){ 
	$(document).on('click', '#submitsignup', function() {
			if($('#uname').val().length > 0 && $('#upass').val().length > 0 && $('#uemail').val().length > 0){
				if($('#upass').val()==$('#confirmpass').val()){
					//following function is converting all form values to one JSON format Object
					$.fn.serializeObject = function()
						{
							var o = {};
							var a = this.serializeArray();
							$.each(a, function() {
								if (o[this.name] !== undefined) {
									if (!o[this.name].push) {
										o[this.name] = [o[this.name]];
									}
									o[this.name].push(this.value || '');
								} else {
									o[this.name] = this.value || '';
								}
							});
							return o;
						};
					//Following line converts the JSON Format object to JSON Format string
					jsondata = JSON.stringify($('#signupform').serializeObject());
					
                    $.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {
                        //    $.mobile.loading('show'); //show ajax spinner
                        },
                        complete: function() {
                          //  $.mobile.loading('hide'); //hide ajax spinner
                        },
                        success: function (result) {
                            if(result.status) { 
								localStorage.email = $('#uemail').val();
								localStorage.name = $('#uname').val();
								localStorage.points = "50";
                                $.mobile.changePage("#afui");                         
                            } else {
                                alert(result.massage); 
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! please try again.');
                        }
                    });                   
            } else{ 
			alert('Your password is not same as the confirmation! Please type it again.');
			}
			}else {
                alert('Please fill up all fields.');
            }           
            return false;	
	});    
return false;
});

//Sign out is clearing all the user data from client side database and redirects to the home page.
$(document).on('click', '.signout', function() {
    	localStorage.removeItem("email");
    	localStorage.removeItem("name");
    	localStorage.removeItem("points");
        $.mobile.changePage("#Loginpanel");
		return false;
});

//Forgot password section. Ajax flag 3
$(document).on('pagecreate', '#forgotpanel', function(){  
        $(document).on('click', '#submitforgot', function() {
            if($('#forgotemail').val().length > 0){
					//following function is converting all form values to one JSON format Object
					$.fn.serializeObject = function()
						{
							var o = {};
							var a = this.serializeArray();
							$.each(a, function() {
								if (o[this.name] !== undefined) {
									if (!o[this.name].push) {
										o[this.name] = [o[this.name]];
									}
									o[this.name].push(this.value || '');
								} else {
									o[this.name] = this.value || '';
								}
							});
							return o;
						};
					//Following line converts the JSON Format object to JSON Format string
					jsondata = JSON.stringify($('#forgotform').serializeObject());
					
                    $.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {
                       //     $.mobile.loading('show'); //show ajax spinner
                        },
                        complete: function() {
                         //   $.mobile.loading('hide'); //hide ajax spinner
                        },
                        success: function (result) {
                            if(result.status) {
							    alert(result.massage); 
                                $.mobile.changePage("#Loginpanel");                         
                            } else {
                                alert(result.massage); 
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! please try again.');
                        }
                    });                   
            } else {
                alert('Please enter your email address.');
            }           
            return false;
        });    
return false;
});

//this section is loading the necessary data for home page. afui page.
$(document).on('pagecreate', '#afui', function(){  
	//this section is loading areas for area select tag in the homepage. Ajax Flag 4.                    
                        $( document ).on( "swiperight", "#afui", function( e ) {
                        if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
                                $( "#SlidePanel" ).panel( "open" );
                        }
                    });				
    
                    var counter1=0;
					var jsondata1 = '{"ajaxflag":"4"}';
					var appendSelect1 = ""; //we will make the codes which we want to append to the select tag in this variable
  //  alert("loading afui");
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata1},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {
                            //loading('show');
                        },
                        complete: function() {
                         //loading('hide');   
                        },
                        success: function (result) {
                            if(result.status) {
                            //alert(result.status);
							//alert(result.counter);
							while(counter1<result.counter){
								//alert(result.val[result.counter]);
								 appendSelect1 += '<option class="filteroption area22" value="'+result.val[counter1]+'">'+result.val[counter1]+'</option>';				
								counter1++;
								}
								$("#areafront").append(appendSelect1);
								
                            } else {
                               //alert(result.status);
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! please check your Internet connection.');
                        }
                    });  					

	//this section is loading cuisine options for cuisine select tag in the homepage. Ajax Flag 5.                    
					counter2=0;
					jsondata2 = '{"ajaxflag":"5"}';
					var appendSelect2 = ""; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata2},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {
                           // $.mobile.loading('show'); //show ajax spinner
                        },
                        complete: function() {
                           // $.mobile.loading('hide'); //hide ajax spinner
                        },
                        success: function (result2) {
                            if(result2.status) {
							while(counter2<result2.counter){
								 appendSelect2 += '<option class="filteroption cusi22" value="'+result2.val[counter2]+'">'+result2.val[counter2]+'</option>';				
								counter2++;
								}
								$("#cuisine").append(appendSelect2);
                            } else {
                               // alert("Counter is 0."); 
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! please check your Internet connection.');
                        }
                    });
					
	//this section is loading event options for event select tag in the homepage. Ajax Flag 6.                    
					counter3=0;
					jsondata3 = '{"ajaxflag":"6"}';
					var appendSelect3 = ""; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata3},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {
                           // $.mobile.loading('show'); //show ajax spinner
                        },
                        complete: function() {
                        //    $.mobile.loading('hide'); //hide ajax spinner
                        },
                        success: function (result3) {
                            if(result3.status) {
							while(counter3<result3.counter){
								appendSelect3 += '<option class="filteroption even22" value="'+result3.val[counter3]+'">'+result3.val[counter3]+'</option>';				
								counter3++;
								}
								$("#event").append(appendSelect3);
                            } else {
                               // alert("Counter is 0."); 
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! please check your Internet connection.');
                        }
                    });  					

//Load all restaurants. Ajax flag 7 and 8 (8 is for free listings and 7 is for non-free. It is a nested ajax.)
					
					var jsondata4 = '{"ajaxflag":"7"}';
					var appendSelect4 = ""; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata4},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() {},
                        complete: function() {},
                        success: function (result4) {
                            if(result4.status) {
							var counter4=0;
							loading('show');
								while(counter4<result4.counter){
									appendSelect4 = '<a href="#eachpanel?restaurant='+result4.name[counter4]+'&branch='+result4.area[counter4]+'&cus='+result4.cus[counter4]+'&events='+result4.events[counter4]+'&GPS=NO&branchID='+result4.branchid[counter4]+'" style="cursor:pointer;text-decoration:none;color: white;font-weight: normal;z-index:10;overflow-x:hidden;" class="panel22 block'+counter4+'"><div class="each"><div class="eachimg"><img class="resimg" src="http://www.kreserve.com/images/'+result4.picname[counter4]+'"/></div><div class="namebox"><div class="resname">'+result4.name[counter4]+'</div></div><div class="rescuisine">'+result4.cus[counter4]+'</div><div class="resaddress">'+result4.area[counter4]+'</div><div class="rate">';
									var staronrate=result4.rate[counter4];
									var staroffrate= (5-staronrate);
									while(staronrate >= 1) {
									appendSelect4 += '<img class="star"  src="images/mon-star.png"/>';
									staronrate--;
									}
									if(staronrate != 0){
									appendSelect4 += '<img class="star"  src="images/mstar.png"/>';
									}
									while(staroffrate >= 1) {
									appendSelect4 += '<img class="star"  src="images/moff-star.png"/>';
									staroffrate--;
									}
									appendSelect4 += '</div><div id="averageprice"><div>Average Price:<span style="color:#333;">&nbsp;RM '+result4.price[counter4]+'</span></div></div></div></a>';
									$("#homecontent").append(appendSelect4);
									counter4++;
									}
									 $(document).on('click', '.panel22', function() {
										var eachUrl = $(this).attr('href');
										var urlIndex = eachUrl.indexOf("GPS=NO&branchID=");
										urlIndex = urlIndex + 16;
										localStorage.branchID = eachUrl.slice(urlIndex);										
									}); 
///////////////////////////////////////////////////// Loading all free listing restaurants after loading subscribed ones. Ajax flag 8. (nested in Ajax flag 7 success.)								
										var counter5=0;
										var jsondata5 = '{"ajaxflag":"8"}';
										var appendSelect5 = ""; //we will make the codes which we want to append to the select tag in this variable
										$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata5},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() {},
											complete: function() {},
											success: function (result5) {
												if(result5.status) {
												loading('show');
													while(counter5<result5.counter){
														appendSelect5 = '<a href="#eachpanel?restaurant='+result5.name[counter5]+'&branch='+result5.area[counter5]+'&cus='+result5.cus[counter5]+'&events='+result5.events[counter5]+'&GPS=NO&branchID='+result5.branchid[counter5]+'" style="cursor:pointer;text-decoration:none;color: white;font-weight: normal;z-index:10;overflow-x:hidden;" class="panel22 block'+counter4+'"><div class="each"><div class="eachimg"><img class="resimg" src="http://www.kreserve.com/images/'+result5.picname[counter5]+'"/></div><div class="namebox"><div class="resname">'+result5.name[counter5]+'</div></div><div class="rescuisine">'+result5.cus[counter5]+'</div><div class="resaddress">'+result5.area[counter5]+'</div><div class="rate">';
														var staronrate=result5.rate[counter5];
														var staroffrate= (5-staronrate);
														while(staronrate >= 1) {
														appendSelect5 += '<img class="star" src="images/mon-star.png"/>';
														staronrate--;
														}
														if(staronrate != 0){
														appendSelect5 += '<img class="star" src="images/mstar.png"/>';
														}
														while(staroffrate >= 1) {
														appendSelect5 += '<img class="star" src="images/moff-star.png"/>';
														staroffrate--;
														}
														appendSelect5 += '</div><div id="averageprice"><div>Average Price:<span style="color:#333;">&nbsp;RM '+result5.price[counter5]+'</span></div></div></div></a>';
														$("#homecontent").append(appendSelect5);
														counter5++;
														counter4++;
														
														}
				/////////////////////////////////////////end of ajax flag 8

//////////// This block is for filtering the restaurants by area, cuisine, events and GPS. First filter is GPS and others are in another block after the GPS codes.											
												var searchcus="allcus";
												var searchevents="allevent";
												var searcharea="allarea";
												$(document).ready(function(){
												$(document).on("change", ".formfront", function() {	
												//alert("click");
												var emptyflag=0; //this flag will be more than 0 if one restaurant or more are in our filter criteria. If no restaurant is in search criteria then this flag will remain 0 and we can show a message to user that we couldn't find any restaurant by these filters.   												
												var totalcount = counter4 - 1;
												var totalres= counter4 - 1;
												$(".panel22").css("display","none");
												searcharea = $( "#areafront option:selected" ).val();
												searchcus = $( "#cuisine option:selected" ).val();
												searchevents= $( "#event option:selected" ).val();
												var flaggps = "0";
												if(searcharea == "GPS"){
												flaggps = "1";	
							////////////////////////Get current location from XDK
													var currentLatitude = 0;
													var currentLongitude = 0;
													function getlocation(){
														

function HTML5Location() {
    if (navigator.geolocation) {
	//alert("start HTML5");
        navigator.geolocation.getCurrentPosition(showPos,showError);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}

function showPos(position) {
   //alert("gps success");
	currentLatitude = position.coords.latitude;
	currentLongitude = position.coords.longitude;
	$( "#gpsalti" ).val(currentLatitude);
	$( "#gpslongi" ).val(currentLongitude);																
	//alert("XDK Latitude: "+currentLatitude+"XDK Longi: "+currentLongitude);
	loadnearby($( "#gpsalti" ).val(),$( "#gpslongi" ).val());
	//alert("success");
    //alert("HTML5 Latitude: "+position.coords.latitude+" Longitude: "+position.coords.longitude);	
}														
																												
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
	intel.xdk.geolocation.getCurrentPosition(suc,fail);
}
														HTML5Location();
														function suc(p){
														if (p.coords.latitude !== undefined)
															{
																currentLatitude = p.coords.latitude;
																currentLongitude = p.coords.longitude;
																$( "#gpsalti" ).val(currentLatitude);
																$( "#gpslongi" ).val(currentLongitude);																
																//alert("XDK Latitude: "+currentLatitude+"XDK Longi: "+currentLongitude);
																loadnearby($( "#gpsalti" ).val(),$( "#gpslongi" ).val());
															}
															else{
															loading('hide');
															alert("Current Location is undefined! Please check your device's GPS settings."); 
															}

														}
														function fail(){
														loading('hide');
														alert("GPS can't find your current location.Please check your device's GPS settings!"); 
														return false;
														}
														//intel.xdk.geolocation.getCurrentPosition(suc,fail);
														}
			////////////////////////Send current location to server by Ajax Flag 9 and display nearby restaurants (within 3 miles). GPS calculations are in server side.					
														function loadnearby(currentLatitude,currentLongitude){
														var counter9=0;
														var jsondata9 = '{"ajaxflag":"9","curlat":"'+currentLatitude+'","curlong":"'+currentLongitude+'"}';
														var appendSelect9 = ""; //we will make the codes which we want to append to the select tag in this variable
														loading('hide');
														$.ajax({url: urlprefix+'/appserver/indexserver.php',
															data: {formData : jsondata9},
															type: 'post',                   
															async: 'true',
															dataType: 'json',
															beforeSend: function() {},
															complete: function() {},
															success: function (result9) {
																if(result9.status) {
																	loading('show');
																	while(counter9<counter4){
																		var str9 = new String($(".block"+counter9).attr("href"));
																		var index9 = str9.lastIndexOf("ID=");
																		var branchID = str9.slice(index9+3);
																		var n9 = result9.nearbyid.indexOf(branchID);
																		if(n9 != "-1"){															
																			$(".block"+counter9).css("display","inline");	
																		}											
																		if(searchcus != "allcus"){
																			var n = str9.search(searchcus);													
																			if((n == "-1")&&($(".block"+counter9).css("display")=="inline")) {
																				$(".block"+counter9).css("display","none");
																			
																			}																																						
																		}												
																		if(searchevents != "allevent"){
																			var n = str9.search(searchevents);													
																				if((n == "-1")&&($(".block"+counter9).css("display")=="inline")) {
																					$(".block"+counter9).css("display","none");
																			} 
																		}
																		if($(".block"+counter9).css("display")=="inline") {
																		emptyflag++;
																		}
																		counter9++;
																	}//end of while loop												
																if(emptyflag==0) {alert("No restaurant could be found. You may change the search criteria to find more restaurants.");}  															
																}
															},
															error: function (request,error) {              
																alert('Network error! please check your Internet connection.');
															}
														});
							////////////////////////End of Ajax flag 9														
														}
														loading('show');
														getlocation();													
														//currentLatitude = 3.160415; 
														//currentLongitude = 101.736445;													
												}																						
//////////// This block is for filtering the restaurants by area, cuisine, events. It is working purely by js in client side. No need to process with ajax on the server.																						
												else{ //if no gps selected. Normal filters are working in this mode
												var resqty=0;
												while(resqty<counter4) {
												var totalcount = resqty;
												var str = new String($(".block"+totalcount).attr("href"));
												var flagcus = "0";
												var flagarea = "0";												
												if(searchcus != "allcus"){
													flagcus = "1";
													var n = str.search(searchcus);													
															if(n != "-1"){															
																$(".block"+totalcount).css("display","inline");
															}													
												}
												if(searcharea != "allarea"){
													flagarea = "1";	
													var n = str.search(searcharea);													
													if(flagcus=="1"){
														if((n == "-1")&&($(".block"+totalcount).css("display")=="inline")) {
															$(".block"+totalcount).css("display","none");
														}
													} else{
															if(n != "-1"){															
																$(".block"+totalcount).css("display","inline");
															}													
													}
												}												
												if(searchevents != "allevent"){
													var n = str.search(searchevents);													
													if((flagcus=="1")||(flagarea == "1")){
														if((n == "-1")&&($(".block"+totalcount).css("display")=="inline")) {
															$(".block"+totalcount).css("display","none");
														}
													} else{
															if(n != "-1"){															
																$(".block"+totalcount).css("display","inline");
															}													
													}
												}
												if((searchcus == "allcus")&&(searcharea == "allarea")&&(searchevents == "allevent")){										
												$(".panel22").css("display","inline");
												}
												if($(".block"+totalcount).css("display")=="inline") {
												emptyflag++;}
												resqty++; 
												}//end of while loop												
												if(emptyflag==0) {alert("No restaurant could be found. You may change the search criteria to find more restaurants.");												
												}  
											} // end of else condition	
										return false;											
										}); // end of click event
										});
												} else {
													//alert("Counter is 0."); 
												}
											},
											error: function (request,error) {              
												alert('Network error! Please check your Internet connection.');
											}
										});
										
                            } else {
                                //alert("Counter is 0."); 
                            }
                        },
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
                        }
                    });  					
					
    return false;
});
////////////////////////////////////////////////////////// End of afui Page

/////////////////////////////////////////Start of Offers panel view. Loading offered restaurants. Ajax Flag 10
$(document).on('pagecreate', '#offerspanel', function(){  
	var jsondata10 = '{"ajaxflag":"10"}';
	var appendSelect10 = ""; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata10},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result10) {
                            if(result10.status) {
								var counter10=0;							
								while(counter10<result10.counter){
									appendSelect10 = '<a href="#eachpanel?restaurant='+result10.name[counter10]+'&branch='+result10.area[counter10]+'&cus='+result10.cus[counter10]+'&GPS=NO&branchID='+result10.branchid[counter10]+'" style="cursor:pointer;text-decoration:none;color: white;font-weight: normal;z-index:10;overflow-x:hidden;" class="panel22 block'+counter10+'"><div class="each"><div class="eachimg" style="min-height:110px;"><img class="resimg" src="http://www.kreserve.com/images/'+result10.picname[counter10]+'"/></div><p class="promotions-percent">'+result10.discount[counter10]+'%</p><div class="namebox"><div class="resname">'+result10.name[counter10]+'</div></div><div class="rescuisine">'+result10.cus[counter10]+'</div><div class="resaddress">'+result10.area[counter10]+'</div>';
									appendSelect10 += '<div id="averageprice"><div>Average Price:<span style="color:#333;">&nbsp;RM '+result10.price[counter10]+'</span></div></div><div id="averageprice"><div><span style="color:red;">'+result10.discount[counter10]+'% OFF </span>for '+result10.offertitle[counter10]+'</div></div></div></a>';
									$("#offercontent").append(appendSelect10);
									counter10++;
									}
								loading('hide');	
							}
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
                        }
                    }); 
return false;
}); 
////////////////////////////////////////////////////////// end of Offers Panel View

/////////////////////////////////////////This section is related to loading of each restaurant page. each panel view.
$(document).on('pageshow', '#eachpanel', function(){
		
		$('#maineach').hide();
		////// Ajax Flag 11 : for loading data of each panel.
		var jsondata11 = '{"ajaxflag":"11","branchID":"'+localStorage.branchID+'"}';
		var appendSelect11 = ""; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata11},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result11) {
                            if(result11.status) {								
								localStorage.res = result11.res;
								localStorage.branch = result11.branch;
								if(result11.minor != "Select"){
								$('#resname').html(localStorage.res+'</br><span style="font-size:90%;">'+result11.major+' - '+result11.minor+'</span>');																								    
								} else {
								$('#resname').html(localStorage.res+'</br><span style="font-size:90%;">'+result11.major+'</span>');																								    								
								}
								$('#eachrate').html(appendSelect11);
								$("#mainpic").attr("src", urlprefix+'/images/'+result11.banner);
								$('#eachdescription').html(result11.description);
								$('#eachWorkHour').html(result11.workHour);
								$('#eachAddress').html(result11.address);
								
								////Putting star rates on the page
								var eachStaronrate=result11.rate;
								var eachStaroffrate= (5-eachStaronrate);
								while(eachStaronrate >= 1) {
								appendSelect11 += '<img class="eachstar"  src="images/mon-star.png"/>';
								eachStaronrate--;
								}
								if(eachStaronrate != 0){
								appendSelect11 += '<img class="eachstar"  src="images/mstar.png"/>';
								}
								while(eachStaroffrate >= 1) {
								appendSelect11 += '<img class="eachstar"  src="images/moff-star.png"/>';
								eachStaroffrate--;
								}
								$('#eachrate').html(appendSelect11);
								
								//// start of adding google map codes
								var mapIndex = result11.googleMap.indexOf('src=');
								mapSrcStart = mapIndex + 4;
								var mapSrcEnd = result11.googleMap.indexOf('style=');
								var mapSrc = result11.googleMap.slice(mapSrcStart,mapSrcEnd);
								
								var hrefIndex = result11.googleMap.indexOf('href=');
								mapHrefStart = hrefIndex + 5;
								var mapHrefEnd = result11.googleMap.indexOf('style="color:#0000FF;text-align:');
								var mapHref = result11.googleMap.slice(mapHrefStart,mapHrefEnd);
								
								var mapAppend = '<iframe width="100%" height="200" frameborder="0" src='+mapSrc+'></iframe><br /><small><a href='+mapHref+' style="color:#0000FF;text-align:left">View Larger Map</a></small>';
								$('#googleMapApp').html(mapAppend);
								////end of adding google map codes
								
								////fill up the branch list combo box.
								var counter11=0;
								var appendBranch11 = '<ul data-role="listview" data-inset="true" style="min-width:210px;" ><li data-role="divider" style="background-color:#900;color:white;text-shadow:none;border-color:#900;">Choose Your Favorite Branch:</li>';
								while(counter11<result11.counter){
								appendBranch11 +='<li><a class="selectBranch" href="#reservation3">'+result11.branchListing[counter11]+'</a></li>';
								counter11++;
								}
								appendBranch11 += '</ul>';
								$('#branchMenu').html(appendBranch11);
								$("#branchMenu").trigger("create");
								$('#maineach').show();
								loading('hide');
								
								$(document).off('click', '.selectBranch').on('click', '.selectBranch', function() {
								localStorage.branch = $(this).html();
								localStorage.uid = "NULL1";			
		});								
							}
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
							loading('hide');
                        }
                    });
	   
return false;
}); 
////////////////////////////////////////////////////////// end of each restaurant page. each panel view.

////////////////////////////////////////////////////////// Start of Dining Offers View. dinepanel view.(It is a page inside the eachpanel page)
$(document).on('pageshow', '#dinepanel', function(){
		
		$('#dinepanel #maineach').hide();
		////// Ajax Flag 12 : for loading data of dining offers
		var jsondata12 = '{"ajaxflag":"12","res":"'+localStorage.res+'"}';
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata12},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result12) {
                            if(result12.status) {	
								////fill up the branch list combo box.
								var counter12b=0;
								var appendBranch12 = '<ul data-role="listview" data-inset="true" style="min-width:210px;" ><li data-role="divider" style="background-color:#900;color:white;text-shadow:none;border-color:#900;">Choose Your Favorite Branch:</li>';
								while(counter12b<result12.counter){
								appendBranch12 +='<li><a class="selectBranch" href="#reservation3">'+result12.branchListing[counter12b]+'</a></li>';
								counter12b++;
								}
								appendBranch12 += '</ul>';
							
								var append12 = "";
								var counter12 = 0;
								while (counter12 < 4) {
									if(result12.title[counter12] != ""){
									append12 += '<!--loop --><div class="eachdineblock"><table style="width:100%;"><tr class="titlebar" style="height:60px;"><td class="offerimg"><img id="checklogo" src="./images/dinelogo.png" style="margin:0px;vertical-align:middle;"/></td>';
									append12 += '<td class="offertitle">'+result12.title[counter12]+'</td></table><p class="eachcontent" style="padding-left:10px;">'+result12.detail[counter12]+'</p>';
									append12 += '<span style="color:black;font-size:110%;padding-left:10px;">Average Price: </span><span style="color:red;font-size:100%;">'+result12.price[counter12]+'</span><br><br>';
									append12 += '<span style="color:black;font-size:110%;padding-left:10px;">Dress Code: </span><span style="color:red;font-size:100%;">'+result12.attire[counter12]+'</span>';
									append12 += '<a href="#offerBranchMenu'+counter12+'" data-rel="popup" data-role="button" data-transition="none" data-inline="true" class="ui-btn ui-corner-all" style="background-color:#900;color:white;text-shadow:none;width:80%;max-width:250px;margin:5px auto;display:inherit;">Book a table Now!</a>';
									append12 += '<div data-role="popup" id="offerBranchMenu'+counter12+'">'+appendBranch12+'</div>';
									append12 += '</div><!-- /loop -->';
									}
									counter12++;
								}								
								$('#dinepanel #maineach').html(append12);																
								$("#dinepanel #maineach").trigger("create");
								$('#dinepanel #maineach').show();
								loading('hide');
								
								$(document).off('click', '.selectBranch').on('click', '.selectBranch', function() {
								localStorage.branch = $(this).html();
								localStorage.uid = "NULL1";			
								});								
							}
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
							loading('hide');
                        }
                    });
	   
return false;
}); 
////////////////////////////////////////////////////////// end of Dining Offers View. dinepanel view.

////////////////////////////////////////////////////////// Start of loading photo gallery (inside the eachpanel) gallerypanel view.
$(document).on('pageshow', '#gallerypanel', function(){
		
		$('#gallerypanel #maineach').hide();
		////// Ajax Flag 13 : for loading the number of pictures
		var jsondata13 = '{"ajaxflag":"13","res":"'+localStorage.res+'","branch":"'+localStorage.branch+'"}';
		var append13 = ""; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata13},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result13) {
                            if(result13.status) {
								var counter13 = 1;
								while(counter13 <= result13.number) {
									append13 += '<img src="'+urlprefix+'/images/'+localStorage.res+'/'+localStorage.branch+'/'+counter13+'.png" class="gallerypic"/>';
									counter13++;
								}
								$('#maineachgallery').html(append13);
								$('#gallerypanel #maineach').show();
							}														
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
							loading('hide');
                        }
                    });
	   
return false;
}); 
////////////////////////////////////////////////////////////// end of photo gallery

//////////////////////////////////////////////////////////////Start of Read Reviews View
$(document).on('pageshow', '#reviewpanel', function(){
		
		$('#reviewpanel #maineach').hide();
		////// Ajax Flag 14 : for loading the reviews
		var jsondata14 = '{"ajaxflag":"14","res":"'+localStorage.res+'"}';
		var append14 = '<p class="addcomment" style="background:white;color:#900;">Comments:</p>'; //we will make the codes which we want to append to the select tag in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata14},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result14) {
                            if(result14.status) {
								var counter14 = 0;
								if(result14.counter != "0") {
									while(counter14 < result14.counter) {
										append14 +=	'<!--each comment block start -->';
										append14 +=	'<div class="eachcomment cssmain">';
										append14 +=	'<p class="commentauthor">'+result14.title[counter14]+'</p>';
										append14 +=	'<p class="commentdate">'+result14.date[counter14]+'</p>';
										append14 +=	'<h4 class="comment">'+result14.comment[counter14]+'</h4>';
										append14 +=	'</div>';
										append14 +=	'<!-- /each comment block -->';
										counter14++;
									}
								} else{
								append14 +=	'<p>No review has been submitted for this restaurant yet. Be the first!</p>';
								}
								append14 += '<a href="#writepanel" class="ui-btn ui-corner-all" style="background-color:#900;color:white;text-shadow:none;width:80%;max-width:250px;margin:5px auto;display:inherit;">Post a Comment</a>';
								$('#reviewpanel #maineach').html(append14);
								$('#reviewpanel #maineach').show();
							}														
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
							loading('hide');
                        }
                    });
	   
return false;
}); 
//////////////////////////////////////////// end of read reviews

/////////////////////////////////////////////////////////Start of write reviews. Ajax Flag 15.
$(document).on('pageshow', '#writepanel', function(){
		
		$(document).off('click', '#submitRev').on('click', '#submitRev', function(){
			var comment15 =  $('#resReview').val();
			
			////// Ajax Flag 15 : for submitting the reviews
			var jsondata15 = '{"ajaxflag":"15","res":"'+localStorage.res+'","comment":"'+comment15+'","name":"'+localStorage.name+'","email":"'+localStorage.email+'"}';
						$.ajax({url: urlprefix+'/appserver/indexserver.php',
							data: {formData : jsondata15},
							type: 'post',                   
							async: 'true',
							dataType: 'json',
							beforeSend: function() { loading('show');},
							success: function (result15) {
								if(result15.status) {
									$('#resReview').val("");
									$.mobile.changePage("#eachpanel");
								}														
							},
							error: function (request,error) {              
								alert('Network error! Please check your Internet connection.');
								loading('hide');
							}
						}); 

	}); 	   
return false;
}); 


/////////////////////////////////////////This section has scripts of reservation form on reservation 3 page 
localStorage.dine="NULL";	
$(document).on('pageshow', '#reservation3', function(){

$("#res3HeaderInfo").html(localStorage.name+"</br>"+localStorage.email+"</br>"+localStorage.res+"</br>"+localStorage.branch);

/////// Taking reservation settings for dining packages and also filling up dine-in type combo box by Ajax Flag 20   
	var jsondata20 = '{"ajaxflag":"20","res":"'+localStorage.res+'","branch":"'+localStorage.branch+'"}';
	var res3config;
	var thisDine, enddate, indexResult, today, kidsFlag, maxdate; 
	var appendSelect20; //we will make the codes which we want to append to the dine-in combo box in this variable
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata20},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result20) {
                            if(result20.status) {
								res3config = result20;
								var counter20=0;
								appendSelect20 = '<option value="nullSelected" selected>Select a Dining Package</option>';								
								while(counter20<result20.counter){
									appendSelect20 += '<option class="selectDine" value="'+result20.dit[counter20]+'">'+result20.dit[counter20]+'</option>';
									counter20++;
									}
								$("#dine").html(appendSelect20);								
								loading('hide');
								if(localStorage.dine != "NULL"){
								indexResult = res3config.dit.indexOf(localStorage.dine);
								}
								if(indexResult >= 0) {
								$("#dine").val(localStorage.dine);
								}
								$(document).off("change", "#dine").on("change", "#dine", function() {	
									if($(this).val() == "nullSelected") {
										$('#restForm').hide();
										}
									else {
										$('#restForm').show();	
										thisDine = $(this).val();
										indexResult = res3config.dit.indexOf(thisDine);	
										localStorage.dine = thisDine;
										////////////////////////set min and max time for HTML5 Calendars
										var d = new Date();
										today = d.getFullYear()+"-"+("0" + (d.getMonth() + 1)).slice(-2)+"-"+("0" + d.getDate()).slice(-2); // it is making todays date in yyyy-mm-dd format
										enddate = res3config.enddate[indexResult];
										maxdate = enddate.slice(6)+"-"+enddate.slice(0,2)+"-"+enddate.slice(3,5);
										$('#datepicker').attr('min',today);
										$('#datepicker').attr('max',maxdate);	

										//////////////////////decide to display to input type for adult and kids quantity or just show one input for total guests.
										kidsFlag = res3config.kidsflag[indexResult];
										if(kidsFlag == "1") { //if the prices of kid and adult are different
											$(".guest2").hide();
											$(".guest1").show();
										////Fill up the age criteria for kids label
											$("#kidslabel").html("Number of Kids ("+res3config.agefrom[indexResult]+" to "+res3config.ageupto[indexResult]+" years old):");
											}
										else { // if price of kids and adults are same
											$(".guest1").hide();
											$(".guest2").show();
											}
										}	
								});
								$(document).off("click", "#submitres3").on("click", "#submitres3", function(event) {
								event.preventDefault();
				///////////////////////////////////////////////////// reservation 3 form validation has 4 steps as follow:
								////Step1: check all mandatory fields are not empty.
								var validateFlag=0;
								if($('#phno').val() == "") { 
									alert("Please enter your phone number.");
									validateFlag++;
									return false;
									}
								else if($('#datepicker').val() == "") { 
									alert("Please choose a date.");
									validateFlag++;
									}
								else if($('#checkin').val() == "") { 
									alert("Please enter the check-in time.");
									validateFlag++;
									}								
								else if($('#checkout').val() == "") { 
									alert("Please enter the check-out time.");
									validateFlag++;
									}
								else if(($('#guest2').is(":visible"))&&($('#guest2').val() == "")) {
									alert("Please enter the total number of guests.");
									validateFlag++;
									}									
								else if(($('#guest').is(":visible"))&&($('#guest').val() == "")) {
									alert("Please enter the number of adult guests.");
									validateFlag++;
									}
								else if(!($("#terms-0").prop("checked"))) { 
									alert("Please check I agree the terms and conditions.");
									validateFlag++;
									}
								//////////Step2: Check the entered phone number has right characters or not. Eligible characters are plus(+), white space, dash(-), dot(.) and numbers(0-9).  
								var RE= /^(?:\s*\+)?[\d\s\.\-]+$/;
								if(!RE.test($('#phno').val()))
									{
										validateFlag++;
										alert("You have entered an invalid phone number");
										return false;
									}																
								/////////Step3: Check the time they selected for check-in and check-out is in working hours of the branch or not.							
								if (Date.parse('01/01/2011 '+$('#checkin').val()+':00') < Date.parse('01/01/2011 '+res3config.opentime+':00')) 
									{
									alert("Sorry. At the selected Check-in time, the restaurant is closed. This branch opens at "+res3config.opentime+".");
									validateFlag++;
									return false;
									}
								if (Date.parse('01/01/2011 '+$('#checkout').val()+':00') > Date.parse('01/01/2011 6:00:00')) { // it means don't check the check out date is after midnight.
									if(Date.parse('01/01/2011 '+$('#checkout').val()+':00') > Date.parse('01/01/2011 '+res3config.closetime+':00')) 
										{
										alert("Sorry. The restaurant is closed at the selected Check-out time. This branch closes at "+res3config.closetime+".");
										validateFlag++;
										return false;
										}
								}
								if (Date.parse('01/01/2011 '+$('#checkout').val()+':00') > Date.parse('01/01/2011 6:00:00')) { // it means don't check if the check out date is after midnight.
									if (Date.parse('01/01/2011 '+$('#checkout').val()+':00') <= Date.parse('01/01/2011 '+$('#checkin').val()+':00'))
										{
										alert("Your check-out time must be later than your check-in time!");
										validateFlag++;
										return false;
										}
								}									
								////////Step4: Check date of reservation is between today's date and max date.
								if (Date.parse($("#datepicker").val()+' 11:00:00') < Date.parse(res3config.today+' 11:00:00')) 
									{
									alert("Your reservation date must be today or later");
									validateFlag++;
									return false;
									}
								if (Date.parse($("#datepicker").val()+' 11:00:00') > Date.parse(enddate+' 11:00:00')) 
									{
									alert("This dining offer will be finished until "+maxdate+". Please select another date.");
									validateFlag++;
									return false;
									}								

								//////// When all validation passed then our validate Flag must be remained 0. So we can submit form data
								if(validateFlag==0) {
								//alert("successful validation");
								////Submit form data via ajax. Ajax Flag 21.
								$('#name').val(localStorage.name);
								$('#email').val(localStorage.email);
								$('#branch').val(localStorage.branch);
								$('#res').val(localStorage.res);
								$('#uid').val(localStorage.uid);
								//alert(thisDine);
								$('#guestflag').val(res3config.kidsflag[indexResult]);
								$('#maxguest').val(res3config.maxguest[indexResult]);
					////////////following function is converting all form values to one JSON format Object
								$.fn.serializeObject = function()
									{
										var o = {};
										var a = this.serializeArray();
										$.each(a, function() {
											if (o[this.name] !== undefined) {
												if (!o[this.name].push) {
													o[this.name] = [o[this.name]];
												}
												o[this.name].push(this.value || '');
											} else {
												o[this.name] = this.value || '';
											}
										});
										return o;
									};
									jsondata21 = JSON.stringify($('#bookingform').serializeObject());		
								
								//// after submission if ajax said restaurant is closed or fully booked then alert error message to customer.	
									$.ajax({url: urlprefix+'/appserver/indexserver.php',
									data: {formData : jsondata21},
									type: 'post',                   
									async: 'true',
									dataType: 'json',
									beforeSend: function() {
									loading('show'); //show ajax spinner
									},
									success: function (result21) {
										if(result21.status) {
											localStorage.uid = result21.uid;
											localStorage.dbname = result21.serial; //saves particular restaurant's database name
											localStorage.layout = result21.layout; // name of the table in database for loading layout of the restaurant in reservation 9 from that. 
											localStorage.resDate = result21.resDate;
											localStorage.cin = result21.cin;
											localStorage.cout = result21.cout;
											localStorage.totalguest = result21.totalguest;
											localStorage.maxchair = result21.maxchair;
											//alert(result21.nextpage);
											$.mobile.changePage("#"+result21.nextpage);
											loading('hide');
											}
										else {
												loading('hide');
												alert(result21.massage);
											}		
									//return false;
									},
									error: function (request,error) {              
										alert('Connection error! please Check your internet settings.');
										}	
									
									}); 
								
										}
								return false;
								});

							}
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
                        }
                    }); 
return false;
}); 
////////////////////////////////////////////////////////end of  reservation 3.

/////////////////////////////////////////This section has scripts of restaurant layout and maps on reservation 9 page 
$(document).on('pageshow', '#reservation9', function(){

////This page role has 3 parts. Part 1 is about loading tables and layouts in the page. Ajax Flag 22
var jsondata22 = '{"ajaxflag":"22", "tableproperties":"'+localStorage.layout+'", "resDate":"'+localStorage.resDate+'", "UID":"'+localStorage.uid+'", "branch":"'+localStorage.branch+'", "dbname":"'+localStorage.dbname+'", "cin":"'+localStorage.cin+'", "cout":"'+localStorage.cout+'", "maxchair":"'+localStorage.maxchair+'", "dine":"'+localStorage.dine+'"}';
var appendSelect22 = '<fieldset id="res9Fieldset" data-role="controlgroup"> ';
					$.ajax({url: urlprefix+'/appserver/indexserver.php',
                        data: {formData : jsondata22},
                        type: 'post',                   
                        async: 'true',
                        dataType: 'json',
                        beforeSend: function() { loading('show');},
                        success: function (result22) {
							if(result22.redirect) { //it means if map section is disabled by cms options then redirect to bill and don't show the map.
								$.mobile.changePage("#bill");
								return false;
							}
                            if(result22.status) {
								var counter22=0;							
								while(counter22<result22.counter){
									appendSelect22 += '<label for="checkbox-'+counter22+'" class="';
									if (result22.vip[counter22]=="1"){
										appendSelect22 += 'vipTable';
									}
									else {
										appendSelect22 += 'notVipTable';
									}							
									appendSelect22 += '"> Table '+result22.tableno[counter22]+' : '+result22.chair[counter22]+' Seats';
									if (result22.vip[counter22]=="1"){
										appendSelect22 += ' (VIP)';
									}
									appendSelect22 += '</label><input type="checkbox" class="';
									if (result22.vip[counter22]=="1"){
										appendSelect22 += 'vipTable';
									}
									else {
										appendSelect22 += 'notVipTable';
									}
									appendSelect22 += '" name="checkbox-'+counter22+'" id="checkbox-'+counter22+'" value="'+counter22+'"/>';
									counter22++;
									}
								appendSelect22 += ' </fieldset>';
								$("#maineachr9").html(appendSelect22);	
								$("#maineachr9>").trigger("create");								
					
							//// This is part 2. This part validates the selected tables for different criteria. 
								var selectedTables = ["ZZNULL", "ZZNULL", "ZZNULL"]; // this array is save the value of checkboxes for tables which are selected by user. With this value we can access to all information of that table including, number of chairs, table number and vip status.We use ZZNULL because at the end when we sort the array all empty element which starts with zz automatically will be sorted by sort function and will shift to the end of array.
								var ckBoxVal, ckBoxFlag, ckBoxIndex, counter22b;
								var vipFlag=0;
								loading('hide');
								
								$(document).off('change', '.ui-checkbox').on('change', '.ui-checkbox', function() {								
									ckBoxVal = $(this).children("input").val();
									ckBoxFlag = selectedTables.indexOf(ckBoxVal);
									if (ckBoxFlag == -1) { // it means user checked a table
										ckBoxIndex = selectedTables.indexOf("ZZNULL");
										if (ckBoxIndex == -1) {
											alert("Sorry, You can't select any more table as you have already selected 3 tables!");
											$(this).children("input").attr('checked', false); // Unchecks it
											return false;
										}
										else{
											selectedTables[ckBoxIndex] = ckBoxVal; // insert the table number into the array.
											if(result22.vip[ckBoxVal]=="1"){
												vipFlag++;
											}
											else {
												vipFlag--;
											}
										}
									}
									else { // it means user unchecked selected table
										selectedTables[ckBoxFlag] = "ZZNULL"; // remove the table number from the array and put null in its place.
										if(result22.vip[ckBoxVal]=="1"){
												vipFlag--;
											}
											else {
												vipFlag++;
											}
									}
									if(vipFlag > 0) { // it means users selected vip tables
										$(".notVipTable").hide();
										$(".vipTable").show();
									}
									else if(vipFlag == 0){ //it means so table has been selected.
										$(".notVipTable").show();
										$(".vipTable").show();
									}									
									else { //it means users selected a normal table
										$(".vipTable").hide();
										$(".notVipTable").show();										
									}
								}); 
								
								$(document).off('click', '#res9Btn').on('click', '#res9Btn', function() {
									jsondata23 = '{"ajaxflag":"23", "UID":"'+localStorage.uid+'"';		
									selectedTables.sort();		
									if(selectedTables[0]=="ZZNULL") {
										alert("Please select a table.");
										return false;
									}
									counter22b=0;
									var totalChairs=0;
									var tb1;
									while(counter22b < 3){
										tb1 = "NULL1";
										if(selectedTables[counter22b]!="ZZNULL") {
											totalChairs += result22.chair[selectedTables[counter22b]];
											tb1=result22.tableno[selectedTables[counter22b]];
										}
										counter22b++;
										jsondata23 += ', "tb'+counter22b+'":"'+tb1+'"';	
									}
									if(localStorage.totalguest > parseInt(totalChairs)){
										alert("The table you selected is small for "+localStorage.totalguest+" guests. Please add more table or select a bigger one!");
										return false;
									}
									if(vipFlag > 0) {
									localStorage.vipflag = 1; //save it to use in bill page.
									}
									else {
									localStorage.vipflag = 0; //save it to use in bill page.
									}
									jsondata23 += ', "serial":"'+localStorage.dbname+'"}';

							//////// This is part 3. in this part we submit the selected tables to database. Ajax flag 23
										$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata23},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() { loading('show');},
											success: function (result23) {
												if(result23.status) {
												$.mobile.changePage("#bill");
												}
											},
											error: function (request,error) {              
												alert('Network error! Please check your Internet connection.');
											}
										}); 						
								}); 								
							}
						},
                        error: function (request,error) {              
                            alert('Network error! Please check your Internet connection.');
                        }
                    }); 

		
return false;
}); 
////////////////////////////////////////////////////////end of  reservation 9.

///////////////////////////////This part is taking bill values and prices from server and show i to the user. Also redirect the user to thank you page or online payment to paypal website outside of the app in a browser.
$(document).on('pageshow', '#bill', function(){
										//// Ajax flag 24, takes the bill data from calculation function in the server.
										jsondata24 = '{"ajaxflag":"24", "serial":"'+localStorage.dbname+'", "UID":"'+localStorage.uid+'", "vipflag":"'+localStorage.vipflag+'", "res":"'+localStorage.res+'"}';
										$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata24},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() { loading('show');},
											success: function (result24) {
												if(result24.redirect) { //it means if map section is disabled by cms options then redirect to bill and don't show the map.
													localStorage.totalbill = result24.totalamount;
													$.mobile.changePage("#thankyou");
													return false;
												}
												if(result24.status) {
												
													if(localStorage.vipflag == 1){
														var vipTitle = " VIP";													
													}
													else{
														var vipTitle = "";	
													}
													if(result24.kidPrice == 0){
														$("#kidTitleRow").hide();
														$("#aduTitle").html(localStorage.dine+" for "+result24.guestqty + vipTitle+" pax");													
														$("#aduPrice").html("RM "+result24.adultPrice);																										
													}
													else {
														$("#kidTitleRow").show();
														$("#aduTitle").html(localStorage.dine+" for "+result24.guestqty + vipTitle+" adults");													
														$("#aduPrice").html("RM "+result24.adultPrice);													
														$("#kidTitle").html(localStorage.dine+" for "+result24.kidqty + vipTitle+" kids");													
														$("#kidPrice").html("RM "+result24.kidPrice);													
													}
													localStorage.totalbill = result24.deposit + result24.balance;
													$("#disPrice").html("RM "+result24.discount);
													$("#taxPrice").html("RM "+result24.sAndTax);
													$("#depPrice").html("RM "+result24.deposit);
													$("#balPrice").html("RM "+result24.balance);
													$("#totPrice").html("RM "+localStorage.totalbill);
													$("#billName").html(localStorage.name);
													$("#billRes").html(localStorage.res);
													$("#billBranch").html(localStorage.branch);
													
												////// this part redirects user to paypal or thank you page on click on Next.													

													$(document).on('click', '#nextBill', function() {
													if(result24.payFlag=="true"){
													var itemname = "Reservation at "+localStorage.res;
													//intel.xdk.device.launchExternal("http://www.kreserve.com/manualpayment.php?pagecode=1000&uid="+localStorage.uid+"&uid1="+result24.dbuid+"&amount="+result24.deposit+"&return=MakeManual&itemname="+itemname);
													window.location="http://www.kreserve.com/manualpayment.php?pagecode=1000&uid="+localStorage.uid+"&uid1="+result24.dbuid+"&amount="+result24.deposit+"&return=MakeManual&itemname="+itemname;
													}
													else {
													$.mobile.changePage("#thankyou");
													}
													});
												}
											},
											error: function (request,error) {              
												alert('Network error! Please check your Internet connection.');
												loading('hide');
											}
										}); 
return false;
});

//// This part is related to thank you page. The server is updating reservation status, calculates kreserve commissions and user points and sends notification emails.
$(document).on('pageshow', '#thankyou', function(){
										//// Ajax flag 25, takes the new user points and also some of the information which it wants to show on the page.
										jsondata25 = '{"ajaxflag":"25", "serial":"'+localStorage.dbname+'", "UID":"'+localStorage.uid+'", "branch":"'+localStorage.branch+'", "res":"'+localStorage.res+'", "totalguests":"'+localStorage.totalguest+'", "totalamount":"'+localStorage.totalbill+'", "email":"'+localStorage.email+'", "points":"'+localStorage.points+'"}';
										$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata25},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() { loading('show');},
											success: function (result25) {
												if(result25.status) {
												$("#tnxRefId").html(result25.refNo);
												$("#tnxBookingId").html(result25.bookingNo);
												$("#tnxDate").html(result25.date);
												$("#tnxCin").html(result25.checkin);
												$("#tnxCout").html(result25.checkout);
												$("#tnxAddress").html(result25.address);
												$("#tnxPhone").html(result25.phone);
												$("#tnxRes").html(localStorage.res);
												$("#tnxGuest").html(localStorage.totalguest);
												$("#tnxDine").html(localStorage.dine);
												localStorage.points = result25.newPoints;
												$(".localpoints").html("Total Points: "+localStorage.points);
												loading('hide');
												}
											},
											error: function (request,error) {              
												alert('Network error! Please check your Internet connection.');
												loading('hide');
											}
										}); 												

return false;
});

///////////////////////////////////////////////////////This part is related to rate a restaurant in each panel.
var mainUL = $('#rateUL').html();
									
$(document).on('pageshow', '#ratepanel', function(){
									
									$('#rateUL').html(mainUL);
									$("#rateUL").listview('refresh');	
									var newRate, currentRate = 0; //It means there is no rate.
									//// Ajax flag 16, takes the new user points and also some of the information which it wants to show on the page.
									jsondata16 = '{"ajaxflag":"16", "res":"'+localStorage.res+'", "branch":"'+localStorage.branch+'", "email":"'+localStorage.email+'"}';
									$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata16},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() { loading('show');},
											success: function (result16) {
												if(result16.status) {
													var append16 = '';
													var counter16 = 1;
													while(counter16 <= result16.rate){
														append16 += '<img class="rateimg" src="./images/yellow-star.png"/>';
														counter16++;
													}
													$('#rate'+ result16.rate).html(append16);
													currentRate = result16.rate;												
												}
												loading('hide');
												$("#maineachrate").show();
												
												$(document).off('click', '.rateStar').on('click', '.rateStar', function(e){
												e.preventDefault();
												newRate = $(this).attr('href');
												//// Ajax flag 17, takes the new user points and also some of the information which it wants to show on the page.
												jsondata17 = '{"ajaxflag":"17", "res":"'+localStorage.res+'", "branch":"'+localStorage.branch+'", "email":"'+localStorage.email+'", "newRate":"'+newRate+'","oldRate":"'+currentRate+'","name":"'+localStorage.name+'"}';
												$.ajax({url: urlprefix+'/appserver/indexserver.php',
														data: {formData : jsondata17},
														type: 'post',                   
														async: 'true',
														dataType: 'json',
														beforeSend: function() { loading('show');},
														success: function (result17) {
															if(result17.status) {
																loading('hide');
																alert("Your rate has been submitted successfully.");
															} else {
															loading('hide');
															alert("Sorry! The submission is failed. Please try later.");
															}
														$.mobile.changePage("#eachpanel");	
														},
												error: function (request,error) {              
														alert('Network error! Please check your Internet connection.');
														loading('hide');
														}
													}); ////end of AJAX.
												}); /////end of click Event.
												
											},
									error: function (request,error) {              
											alert('Network error! Please check your Internet connection.');
											loading('hide');
											}
									}); 												
return false;
});	



$(document).on('pageshow', '#blogpanel', function(){
										var append18 = '';
										jsondata18 = '{"ajaxflag":"18"}';
										$("#blogLoop").hide();
										$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata18},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() { loading('show');},
											success: function (result18) {
												if(result18.status) {
												var counter18 = 0;
												while(counter18 < result18.counter){
												append18 += '<a id="bloglink" class="bloglink" href="'+result18.blogID[counter18]+'" style="text-decoration:none;" rel="external" data-role="none">';
												append18 += '<div class="post cssmain">';
												append18 += '<h2 class="cssmain postname">';
												append18 += result18.title[counter18];
												append18 += '</h2><div class="postimgmain cssmain">';
												append18 += '<img class="postimg"  src="'+urlprefix+'/blog/images/'+result18.picture[counter18]+'"/>';
												append18 += '</div>';
												append18 += '<p class="posttext cssmain">'+result18.brief[counter18]+'</p>';
												append18 += '<div class="readmore cssmain" style="color:white;">Read more</div></div></a>';
												counter18++;
												}
												$("#blogLoop").html(append18);	
												$(document).off('click', '#bloglink').on('click', '#bloglink', function(e){
													e.preventDefault();
													localStorage.blogid = $(this).attr('href');
													$.mobile.changePage("#eachblog");	
												});
												loading('hide');
												$("#blogLoop").show();
												}
											},
											error: function (request,error) {              
												alert('Network error! Please check your Internet connection.');
												loading('hide');
											}
										}); 	


return false;
});		

$(document).on('pageshow', '#eachblog', function(){	
										var append19 = '';
										jsondata19 = '{"ajaxflag":"19","blogID":"'+localStorage.blogid+'"}';
										$("#eachblog #maineach").hide();
										$.ajax({url: urlprefix+'/appserver/indexserver.php',
											data: {formData : jsondata19},
											type: 'post',                   
											async: 'true',
											dataType: 'json',
											beforeSend: function() {loading('show');},
											success: function (result19) {
												if(result19.status) {
												append19 += '<h3 class="blogheader">'+result19.title+'</h3>';
												append19 += '<p>By '+result19.author+'</p>';
												append19 += '<img style="width:80%;"  src="'+urlprefix+'/blog/images/'+result19.picture+'"/>';
												append19 += '<p style="text-align:justify; float:left;"><br>';
												append19 += result19.description;
												append19 += '</p>';
												var counter19 = 0;
												var append19b= "";
												while(counter19 < result19.counter) {
													append19b +=	'<div class="eachcomment cssmain">';
													append19b +=	'<p class="commentauthor">'+result19.name[counter19]+'</p>';
													append19b +=	'<p class="commentdate">'+result19.date[counter19]+'</p>';
													append19b +=	'<h4 class="comment">'+result19.comment[counter19]+'</h4>';
													append19b +=	'</div>';
													counter19++;
												}
												
												append19b +=	'<p class="addcomment">Add a Comment</p>';
												append19b +=	'<input type="hidden" name="id" id="id" value="" />';
												append19b +=	'<p class="fields cssmain">Your Comment: <strong style="color:#aa0000;">* </strong></p>';
												append19b +=	'<textarea placeholder="Write Your comment Here..." class="fieldsin cssmain" name="comment" id="comment" style="width:94%;"></textarea>';
												append19b +=	'<input class="commentbutton cssmain" type="submit" value="POST COMMENT" data-role="none" id="postCommentBlog"/>';
												
												$("#eachBlogPost").html(append19);
												$("#eachBlogcmt").html(append19b);
												loading('hide');
												$("#eachblog #maineach").show();
												
												$(document).off('click', '#postCommentBlog').on('click', '#postCommentBlog', function(e){
												e.preventDefault();
												var blogComment = $("#comment").val();
												//// Ajax flag 26, takes the new user points and also some of the information which it wants to show on the page.
												jsondata26 = '{"ajaxflag":"26", "name":"'+localStorage.name+'", "email":"'+localStorage.email+'", "comment":"'+blogComment+'","blogID":"'+localStorage.blogid+'"}';
												$.ajax({url: urlprefix+'/appserver/indexserver.php',
														data: {formData : jsondata26},
														type: 'post',                   
														async: 'true',
														dataType: 'json',
														beforeSend: function() { loading('show');},
														success: function (result26) {
															if(result26.status) {
																loading('hide');
																alert("Thanks, your comment has been submitted successfully.");
															} else {
															loading('hide');
															alert("Sorry! The submission is failed. Please try later.");
															}
														$.mobile.changePage("#blogpanel");	
														},
												error: function (request,error) {              
														alert('Network error! Please check your Internet connection.');
														loading('hide');
														}
													}); ////end of AJAX.
												}); /////end of click Event.
												
												}
											},
											error: function (request,error) {              
												alert('Network error! Please check your Internet connection.');
												loading('hide');
											}
										}); 	
return false;
});							
