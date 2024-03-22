// why?
// After I deleted all deviantart favs (https://github.com/akosnikhazy/snippets/blob/main/delete-all-deviantart-favs.js)
// I realized I should delete all watches too.

// how to use?
// go to https://www.deviantart.com/watch/deviations and select the first person in the list
// open dev console (f11 in most browsers) and copy this in and press enter or run
// then just press up arrow key and press enter again and repeat. You might want to wait a
// little so the browser loads the page fully. This is a very semi-automatic way of doing this
// like at the favs I done this so I check everything out a last time.

// what could change:
// a._1Hru3.E7EQn.aToGy._2OXCK part
// "da_minor_version" value at the bottom
// anything really. It works at commit time
function getUsername(url) {
   
    var segments = url.split('/');
    return segments[segments.length - 2];

}

// request the unwatch
var xhr = new XMLHttpRequest();
xhr.open('POST', 'https://www.deviantart.com/_puppy/dashared/user/unwatch', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.onload = function () {
  if (JSON.parse(xhr.responseText).success === true) {
    // if deviantart says success: go to the next one 
    document.querySelectorAll('a._1Hru3.E7EQn.aToGy._2OXCK')[1].click();
	 // this one works on groups if you are on the https://www.deviantart.com/groups/[GROUPNAME]/deviations
    // page. It is not as good as for profile but faster than opening all the groups to unwatch. The random makes it faster
    //   document.querySelectorAll('div._23Yz-._19Ez7')[(Math.floor(Math.random() * (5 - 1 + 1) + 1))].click();
  }
};

xhr.send(jsonData = JSON.stringify({
  "username": getUsername(window.location.href), // the second to last one is the username
  "csrf_token": window.__CSRF_TOKEN__, // deviantart is kind enough to provide this globally
  "da_minor_version": 20230710 // might change in the future
}));
