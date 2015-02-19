 jQuery(document).ready(function() {
     var type="tous";
       var isData=false;
       
 $("#motcle").keyup(function(){
                if($(this).val().length>=4){
              var motcle = $("#motcle").val();       
             var DATA =       {
                                  "critere":type,
                                  "motcle":motcle
                              };
              $.ajax({
            type: "post",
            //url: "/toubarefane/web/article_rechercherajax",
            url:Routing.generate('toubarefanesite_article_rechercherajax'),
           
            beforeSend: function(){
                if($(".loading").length===0)
              $(".resultat").append('<a class="loading col-xs-12 col-lg-2 col-md-2 hidden-xs"></a>'); 
             
            },
            data:DATA,
            success: function(data){
           
             try {
                console.log(data);
           } catch (e) {
             console.error("Parsing error:", e); 
             }
                   
                     /*console.log( JSON.parse(data));  var found = $.inArray('coran', value) > -1;   var myJsonString = JSON.stringify(value);*/
                $(".resultat").text('');
                $.each(data,function(index,value){
                 isData=true;                
               $(".loading").hide(); 
                if($(".panel_resultat").length===0)
                $(".resultat2").append(' <header class="panel panel-info col-lg-12 col-md-12 col-xs-12 panel_resultat"> Resultat de recherche</header>'); 
               if(index.slice(-1)==='v'){
                  
              $(".resultat").append('<div class="btn" ><a href="'+Routing.generate('toubarefanevideo_voir',{ id:index.slice(0, -1) })+'" >'+value+'</a></div>'); 
               }
               
               else if(index.slice(-1)==='a'){
                  
              $(".resultat").append('<div class="btn" ><a href="'+Routing.generate('toubarefaneaudio_voir',{ id:index.slice(0, -1) })+'" >'+value+'</a></div>'); 
               }
               else if(index.slice(-1)==='d'){
                  
              $(".resultat").append('<div class="btn" ><a href="'+Routing.generate('toubarefanephoto_voir',{ id:index.slice(0, -1) })+'" >'+value+'</a></div>'); 
               }
              else if(index.slice(-1)==='p'){
                  
              $(".resultat").append('<div class="btn" ><a href="'+Routing.generate('toubarefanephoto_voir',{ id:index.slice(0, -1) })+'" >'+value+'</a></div>'); 
               }else
              $(".resultat").append('<div class="btn" ><a href="'+Routing.generate('toubarefanesite_voir',{ id:index })+'" >'+value+'</a></div>'); 
      
          });
          if(!isData){
               $(".panel_resultat").hide(); 
              $(".resultat").text('aucune valeur trouvée'); 
              $(".loading").hide();  
                  } 
                 } 
                 }); 
                } 
            }); 
            
  selectThis=function(obj) {
      i = document.Choix.choice.selectedIndex;
    //var critere=  document.getElementById(obj.id).checked;
  
   if(i===1)
   type="article" ;
   if(i===2)
   type="video" ;
   if(i===3)
   type="audio" ;
   if(i===4)
   type="dol" ;
   if(i===5)
   type="photo" ; 
   };
             }); 
             
  
 