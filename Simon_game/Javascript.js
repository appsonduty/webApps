
var gamepattern = [];

var buttoncolors = ["red", "blue" , "yellow","green"];


var userpattern = [];

var levelnum = 0;

var level = "level "+levelnum;
var started = false;




function nextsequence(){

    userpattern=[];

    levelnum++;
    Level ="level "+levelnum;
    $("#level-title").text(Level );
var Randomnumber =Math.floor(Math.random()*4);
var Randomchoosecolor = buttoncolors[Randomnumber];
gamepattern.push(Randomchoosecolor);
$("#"+Randomchoosecolor).fadeIn(100).fadeOut(100).fadeIn(100);
playsound(Randomchoosecolor);


}



$(".btn").click( function(event){

    
 
   var userchoosecolor = event.target.id;
   userpattern.push(userchoosecolor);

    animatepress(userchoosecolor)
    playsound(userchoosecolor);

    checkanswer(userpattern.length-1);

    

});

function playsound(name) {

   
    var audio = new Audio("sounds/" + name + ".mp3");
    audio.play();
  }


  function animatepress(currentparameter){

    $("#"+currentparameter).addClass("pressed");

    setTimeout(() => {
        $("#"+currentparameter).removeClass("pressed");
        
    }, 100);
  }

  $(document).keypress(function(){
    if(!started){
    $("#level-title").text(level);
nextsequence();
started=true;
    }


  });

  function checkanswer(currentlevel){

    if(gamepattern[currentlevel]==userpattern[currentlevel]){

        console.log("win");

        if (userpattern.length === gamepattern.length){

            
            setTimeout(function () {
              nextsequence();
            }, 1000);
    
          }
    }
    else{
        console.log("lose");
        startover();     
  }

  }

  function startover(){

    var wrong  = new Audio("sounds/wrong.mp3");
        wrong.play();

        $("body").addClass("game-over");
        



        setTimeout(() => {
            $("body").removeClass("game-over"); 
             $("#level-title").text("Gameover-press any key to start" );
        }, 200);
            levelnum=0;
            level = "level "+levelnum;
         
            gamepattern=[];
            started=false;
                }


