/*********************************************************************************** 
*  2. számú melléklet az 1996. évi XX. törvényhez	
* A Társadalombiztosítási Azonosító Jel képzési szabálya
* "A TAJ szám első nyolc számjegyéből a páratlan helyen állókat hárommal, a páros 
* helyen állókat héttel szorozzuk, és a szorzatokat összeadjuk. Az összeget tízzel 
* elosztva a maradékot tekintjük a kilencedik, azaz CDV kódnak."
************************************************************************************/
function TAJ(taj) {

	// így int és string is működik, cserébe később parseInt-elni is kell
	var TAJStr = taj.toString().padStart(9, '0');
	
	// gatekeep: early return
	if(TAJStr.length !== 9) return false; // ha nem 9 karakter, minek tovább menni?
	if(!/^\d+$/.test(TAJStr)) return false; // ha nem minden karakter szám itt meg is állunk
	
	// check digit verification érték a TAJ szám utolsó számjegy
	var CDV = parseInt(TAJStr.substring(TAJStr.length - 1));
	
	// a számok, amikkel dolgozunk
	var TAJNums = TAJStr.slice(0,-1);

	// itt végezzük al az összeadásokat
	var sum = 0;	
	TAJNums.split('').forEach(function(digit,index){
		sum += parseInt(digit) * ((index&1)?3:7);
	});
	
	// ellenőrzés
	if(CDV != 10-sum%10) return false;
	
	
	return true;
	
}
