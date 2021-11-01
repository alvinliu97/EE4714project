window.onload=function(){
    //first slide 
    var pic_lis=document.getElementById('b_pic').getElementsByTagName('li');
    var an_lis=document.getElementById('b_an').getElementsByTagName('li');
    an_lis[0].style.background='#2f4869';
    var c=0;

    function h_slide(){
        c++;
        if(c==pic_lis.length){c=0;}
        for(var i=0; i<pic_lis.length; i++){
            pic_lis[i].style.display='none';
            an_lis[i].style.background='#5b82b7';
        }
        pic_lis[c].style.display='block';
        an_lis[c].style.background='#2f4869';	
    }
    var timer=setInterval(h_slide,3000);

    for(var j=0; j<pic_lis.length; j++){
        an_lis[j].index=j;
        an_lis[j].onmouseover=function(){
            index=this.index;
            clearInterval(timer);
            for(var k=0; k<an_lis.length; k++){
                pic_lis[k].style.display='none';
                an_lis[k].style.background='#5b82b7';
            }
            pic_lis[index].style.display='block';
            an_lis[index].style.background='#2f4869';
        }

        an_lis[j].onmouseout=function(){
            timer=setInterval(h_slide,3000);
        }
    }
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
        } else {
          panel.style.display = "block";
        }
      });
    }
}
