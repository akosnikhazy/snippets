// **************************************************************
//
// I made a native JS function from the jQuery Plugin
// https://github.com/akosnikhazy/Valid-Credit-Card-jQuery-Plugin
//
// **************************************************************

function isValidCreditCardNumber(num /* string */)
{ // it will be string because input fields send string
	
    // Not a number and 16 digits long: it ia a creditcard number;
    // you have to sanitize it before this. Get rid of spaces and stuff
    // people type in (or do not let them type it in in the first place
    if(num.length != 16) {return false;}
   
    // Hans Peter Luhn algorithm
    for(var digits = num.split('').map(Number), i = 14; i >= 0; i -= 2)
    {
	      if(digits[i]*2 > 9)
	      {
		        digits[i] = 1 + (digits[i]*2-10);
		        continue;
	      }
		
	      digits[i] = digits[i]*2;
		
    }
	
    // if the total is not dividable by ten it is not valid
    return digits.reduce((a, b) => a + b, 0)%10 == 0;
 
}
