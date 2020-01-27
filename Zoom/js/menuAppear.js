	var menuBtn = document.querySelectorAll(".menu");
	var serviceItem = document.querySelectorAll('.serviceItem');
	function mouseLeave(){
		for(var x = 0; x<menuBtn.length;x++){
		menuBtn[x].style.transition = "all 0.5s";
			}	
		}
		window.addEventListener('scroll',function(){
			const scrollable = document.documentElement.scrollHeight - window.innerHeight;
			const scrolled = window.scrollY;
			if(scrolled >= 300){
				for(var x = 0; x<serviceItem.length;x++){
			serviceItem[x].style.transition = "all 1s";
			serviceItem[x].style.opacity = 100;
			}				
			}		
		})