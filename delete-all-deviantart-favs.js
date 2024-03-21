// why?
// as deviantart become bad I deleted everything I had from there but
// unfaving everything is hard. I had 5k+ in 19 years. So I made this
// small script.

// how to use?
// just go to https://www.deviantart.com/[YOUR USERNAME]/favourites/all 
// open dev console (f11 in most browsers) and copy this in and press enter or run
// then just press up arrow key and press enter again and repeat
// or write a loop for this, I wanted to see my old favs while deleting them.

buttons = document.getElementsByTagName('button');
for (var i = 0; i < buttons.length; i++) {
  var button = buttons[i];
  // this is the fav star this is the only way we can identify the button
  var pathElement = button.querySelector('path[d="M11.054 3a1 1 0 00-.87.506L8.123 7.134l-4.57.641a1 1 0 00-.812.68l-.545 1.672a1 1 0 00.266 1.038l3.264 3.07-.765 4.33a1 1 0 00.416.997l1.567 1.081a1 1 0 001.021.069L12 18.66l4.116 2.07a1 1 0 001.025-.074l1.524-1.072a1 1 0 00.408-.999l-.8-4.35 3.257-3.063a1 1 0 00.261-1.052l-.564-1.65a1 1 0 00-.807-.666l-4.58-.643-2.066-3.653a1 1 0 00-.87-.508h-1.85z"]');
  if (pathElement) {button.click();}
}
	 
window.scrollBy(0, 500);
