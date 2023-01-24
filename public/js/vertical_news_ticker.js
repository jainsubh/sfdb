(function(){

	function scroller(scroll) {
	  
		var height = scroll.height(); // Gets the height of the scroll div

		var topAdj = -height-10; 
		/* '-height' turns the height of the UL into a negative #, 
		* '- 50' subtracts an extra 50 pixels from the height of 
		* the div so that it moves the trail of the UL higher to 
		* the top of the div before the animation ends
		*/
		var contentHeight;

		/*if(top == ""){*/
			contentHeight = $(scroll).parent().height(); //Get the height of the div inside which content is scrolling
		/*}
		else{
			contentHeight = top;
		}*/
		$(scroll).css("top", contentHeight);
	  
		scroll.animate({
			'top' : [topAdj, 'linear'] 
		}, height*35 , function(){
			scroller(scroll);
			/*
			scroll.css('top', contentHeight); //resets the top position of the Ul for the next cycle

			var scroll1 = $('div#vScroll1');// Sets the div with a class of scroll as a variable
			scroller(scroll1);

			var scroll2 = $('div#vScroll2');// Sets the div with a class of scroll as a variable
			scroller(scroll2);
			*/
		});
	 
	}
	
	var scroll1 = $('div#vScroll1');// Sets the div with a class of scroll as a variable
	scroller(scroll1);

	var scroll2 = $('div#vScroll2');// Sets the div with a class of scroll as a variable
	scroller(scroll2);

	var scroll3 = $('div#vScroll3');// Sets the div with a class of scroll as a variable
	scroller(scroll3);

	var scroll4 = $('div#vScroll4');// Sets the div with a class of scroll as a variable
	scroller(scroll4);
	/*
	$('#vScroll1').on('mouseover',function() {
		$(this).stop();
	});
	   
	$('#vScroll2').on('mouseover',function() {
		$(this).stop();
	   });
	   
	$('#vScroll1').on('mouseout',function() {
		var top = $(scroll1).css("top");
		scroller(scroll1, top);
	});
	   
	$('#vScroll2').on('mouseout',function() {
		var top = $(scroll2).css("top");
		scroller(scroll2, top);
	});
	*/
  
  })();