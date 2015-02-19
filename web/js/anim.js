jQuery(document).ready(function() {

                   var ar=$("#article");
                  var delai=1000;
                  var i=1;

                  $(".play").click(function(){ 
                       $(".msg").hide();
                    if (i%2) {
                    $("#splay").removeClass("glyphicon-play");
                    $("#splay").addClass("glyphicon-pause"); 
                     i++;
                     play();
                  }
                  else{
                     $("#splay").removeClass("glyphicon-pause");
                    $("#splay").addClass("glyphicon-play");
                    i++;
                  }
                  });
                  
                  $("#next").click(function () {
                      $(".msg").hide();
                     var sec=$("#article section:nth-child(1)");
                     sec.hide("fast","linear",function(){
                     ar.append($(this));
                     $(this).css("display","block");
                   });
                   
                  });
                  $("#prev").click(function () {
                       $(".msg").hide();
                     var sec=$("#article section").prev();
                     sec.hide("fast","linear",function(){
                     ar.append($(this));
                     $(this).css("display","block");
                   });
                   
                  });
                   $(".img").click(function () {
                      $(".msg").hide();
                     var sec=$("#article section:nth-child(1)");
                     sec.hide("fast","linear",function(){
                     ar.append($(this));
                     $(this).css("display","block");

                    

                   });
                   
                  });
                   
                  function play () {
                     var sec=$("#article section:nth-child(1)");
                     sec.delay(delai).hide("fast","linear",function(){
                     ar.append($(this));
                     $(this).css("display","block");
                     if (!(i%2))
                     play();

                   });
                   
                  }

                 $("#plus").click(function(){
                   delai=delai+1000;
                      if (delai>=100000) {
                        delai=1000;
                      };
                       
                          $("#minus").hide();
                          $("#minus").show().html("&nbsp;&nbsp;&nbsp;"+(delai/1000)+"s");
                           $("#op").css("width",(delai/1000));
                 });
                 $("#minus").click(function(){
                   delai=delai-1000;
                      if (delai<=1000) {
                        delai=100000;
                      };
                  $("#minus").hide();
                          $("#minus").show().html("&nbsp;&nbsp;&nbsp;"+(delai/1000)+"s");
                            $("#op").css("width",(delai/1000));
          });
               
            
           
              
          
    
                  var url = window.location.href;
                 var url2=url.replace("http://localhost","");
                
                   $('li a[href="'+url2+'"]').parent().addClass('active');
                   if($('li').hasClass("active"))
                       $('ul .active').parent().parent().addClass('active');
                  
                 
    	    });
		
       