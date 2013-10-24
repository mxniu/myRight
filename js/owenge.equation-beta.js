/*

Author: Chris Ongsuco a.k.a. "owenge"
Blog: http://owenge.blogspot.com (a link to my blog would be nice)
Version: Beta
License: New BSD License
Summary: A simple equation parser that computes string-based equation like in MS Excel.

Sample Usage:
	var eq = owenge.equation.parse('1+2');
	document.writeln(eq.answer);

	Answer: 3
	
	eq = owenge.equation.parse('(((-1+2)*5+-10)/3*2)+100/2/3/4/-5+(90*5)');
	document.writeln(eq.answer);
	
	Answer: 445.8333333333333
	
Support:
	Math functions are yet supported.

FAQ:
	I wrote this for the sake of learning more about JavaScript and 
	to have fun, of course!
	
*/

var owenge = function() {
	var symbol = {
		mul: '*',
		div: '/',
		add: '+',
		sub: '-',
		grpbeg: '(',
		grpend: ')'
	};
	
	var ex = {
		divZero: 'divZero',
		isNan: 'isNan',
		invalidArgument: 'invalidArgument'
	};
	
	var operator = [symbol.mul, symbol.div, symbol.add, symbol.sub];
	var group = [symbol.grpbeg, symbol.grpend];
	
	// Just another way I want to make a namespace. I
	// don't want to have another js file that has to
	// be referenced just to make this parser works!
	var ns = {
		equation: {
			parse: function(s) {}
		}
	};
	
	// Function for parsing the string-based equation.
	//
	// Returns: Object with properties - "answer" and "error"
	ns.equation.parse = function(s) {
		// Function for splitting operators and numbers
		// into valid elements.
		//
		// Returns: Array of numbers and operators
		var split = function(s) {
			var ar = [];
			var len = s.length;
			var i = 0;
			var start = 0;
			
			for (i = 0; i < len; i++) {
				// Get the current character of the formula.
				var ch = s.charAt(i);
				
				// Get the left character of the current character.
				var left = i == 0 ? '' : s.charAt(i - 1);
				
				// Ignore if it is not an operator so letters
				// and numbers will be skipped.
				if (!Array.contains(operator, ch)) {
					continue;
				}

				// Evaluate if the operator is actually a "sign".
				// This is for negative numbers where the left
				// character is usually a math operator.
				if (Array.contains(operator, ch) && Array.contains(operator, left)) {
					continue;
				}
				
				// Parse the number starting from the index of the
				// previous operator upto the current one.
				Array.add(ar, s.substr(start, i - start));
				
				// Add the operator to the array.
				Array.add(ar, ch);
				
				// Track the index of the current operator. This
				// will be used for the next numeric parsing.
				start = i + 1;
			}

			// If the array has no elements it only means
			// that the formula doesn't have any operator(s)
			// so we have to assume that the value is a
			// number.
			if (ar.length == 0) {
				return s;
			}
			
			// The right most number of the formula will NOT be
			// included when parsing so we have to add it to the
			// array based on the last index of the last operator.
			if (start > 0) {
				Array.add(ar, s.substr(start));
			}
			
			// Return the parsed array values.
			return mdas(ar);
		};
	
		// Function for eliminating equation groups.
		//
		// Returns: Number as the answer of the equation
		var recurse = function(s) {
			var len = s.length;
			var i = 0;
			var start = 0;
			var prevGrp;
			var parsed = '';
			
			for (i = 0; i < len; i++) {
				var ch = s.charAt(i);
				
				// Update the starting index with the latest value.
				if (ch === symbol.grpbeg) {
					start = i + 1;
				}
				
				// Update the new parsed formula
				parsed += ch;
				
				// Ignore other characters that is not a group symbol.
				if (!Array.contains(group, ch)) {
					continue;
				}
				
				if (prevGrp === symbol.grpbeg && ch === symbol.grpend) {
					// Get the inner formula with the parenthesis
					var formula = s.substr(start, i - start);
					
					// Compute the inner formula using MDAS
					var ans = split(formula);
					
					// Compute the length of the new formula
					var clen = parsed.length - (formula.length + 2);
					parsed = parsed.substr(0, clen);
					
					// Add the answer of the parsed inner formula.
					parsed += ans;
				}
				
				// Track the group symbols
				prevGrp =  ch;
			}
			
			// If the newly concatenated formula still has 
			// groupings then we recurse until all groups
			// are eliminated.
			if ((parsed.indexOf(symbol.grpbeg) != -1) || (parsed.indexOf(symbol.grpend) != -1)) {
				return recurse(parsed);
			}
			
			// If you reach this part it only means that
			// all groups were eliminated and the final
			// result is ready for the last computation.
			return split(parsed);
		};
		
		var error = '';
		var ans;
		
		try {
			ans = recurse(s);

			if (isNaN(ans)) {
				throw ex.isNan;
			}
		}
		catch (e) {
			ans = 'n/a';
			
			if (e == ex.divZero) {
				error = 'Cannot perform division by zero';
			}
			else if (e == ex.isNan) {
				error = 'Invalid formula';
			}
			else if (e == ex.invalidArgument) {
				error = 'Invalid argument';
			}
		}
		
		return {
			error: error,
			answer: ans
		};
	};
	
	// Function for computing equation based on MDAS.
	//
	// Returns: Numeric value as result of computation
	var mdas = function(ar) {
		// Function for computing basic math operation.
		//
		// Returns: Numeric value as result computation
		var compute = function(n1, n2, op) {
			switch (op) {
				case symbol.add:
					return Number(n1) + Number(n2);
				case symbol.sub:
					return Number(n1) - Number(n2);
				case symbol.mul:
					return Number(n1) * Number(n2);
				case symbol.div:
					if (Number(n2) == 0) {
						throw ex.divZero;
					}
					
					return Number(n1) / Number(n2);
			}
			
			// You're not suppose to reach this point. If you
			// do then you are passing the wrong values!
			throw ex.invalidArgument;
		};
		
		// Function for computing equation applying
		// MDAS rule. Operators that are passed in
		// the parameter will be basis of computation.
		// Operators not passed will be ignored.
		//
		// Returns: Array of COMPUTED numbers and operators
		var applyRule = function(ar, ops) {
			var len = ar.length;
			var i = 0;
			var prevOp;
			var parsed = [];
			
			for (i = 0; i < len; i++) {
				var mod = i % 2;
				
				// Skip if it is not an operator.
				if (mod == 0) {
					continue;
				}
				
				// If the equation is 2+3 then
				// num1 is 2
				// num2 is 3
				// op is +
				var num1 = ar[i - 1];
				var num2 = ar[i + 1];
				var op = ar[i];

				// If the current operator is the one
				// that will be used for computation then
				// we ignore it.
				if (!Array.contains(ops, op)) {
					// Check if the previous operator is used
					// for the calculation. If not then we
					// add the current number to the parsed array.
					if (!Array.contains(ops, prevOp)) {
						Array.add(parsed, num1);
					}
					
					// Add ignored operator to the parsed array.
					Array.add(parsed, op);
				}
				else {
					// If the previous operator is found in
					// the list of operators to be used for 
					// computation, then we get the previous
					// oomputed value in the array.
					if (Array.contains(ops, prevOp)) {
						num1 = parsed[parsed.length - 1];
					}
					
					// Compute the equation.
					var ans = compute(num1, num2, op);
					
					// Replace the last value in the array
					// with the new parsed value.
					if (Array.contains(ops, prevOp)) {
						parsed[parsed.length - 1] = ans;
					}
					else {
						Array.add(parsed, ans);
					}
				}
				// Track the previous operator.
				prevOp = op;
			}
			
			// We have to add the last value of the formula if the
			// last operator it used for computation.
			if (!Array.contains(ops, prevOp)) {
				// Get the last operator in the array.
				Array.add(parsed, ar[len - 1]);
			}
			
			return parsed;
		};
		
		// Apply MDAS rules to the equation
		ar = applyRule(ar, ['*', '/']);
		ar = applyRule(ar, ['+', '-']);
		
		// Return the final answer of the computation
		return ar.length == 0 ? 0 : ar[0];
	};
	
	// Array extensions
	if (!Array.contains) {
		Array.contains = function(array, o) {
			var len = array.length;
			var i = 0;
			
			for (i = 0; i < len; i++) {
				if (array[i] === o) {
					return true;
				}
			}
			
			return false;
		};
	}

	if (!Array.add) {
		Array.add = function(array, o) {
			array[array.length] = o;
		};
	}
	
	return ns;
}();






