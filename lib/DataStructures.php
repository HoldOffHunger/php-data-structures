<?php

					// PHP Data Structure Utilities
					
					// DataStructures.php
					// By: HoldOffHunger@gmail.com
					// BSD 3-Clause "New" or "Revised" License
					
					// Check us out!
					// https://github.com/HoldOffHunger/php-data-structures

	class DataStructures {
			/* __construct($args)
			 *
			 * Standard constructor.
			 */
			 
		public function __construct($args) {
			return TRUE;
		}
		
			/* cleanupArrayPiece($args)
			 *
			 * Cleanup a particular piece from an array, whether key or value.
			 *
			 * Expected Input:
			 *	'hello'
			 *	"hello"
			 *	"123"
			 *	456
			 *	"123",
			 *	"456")
			 *	"789"]
			 *	"012",)
			 *	"456",]
			 *	789,)
			 *	000,]
			 *
			 * Expected Output:
			 *	hello
			 *	hello
			 *	123
			 *	456
			 *	123
			 *	456
			 *	789
			 *	012
			 *	456
			 *	789
			 *	000
			 */
			 
		public function cleanupArrayPiece($args) {
			$piece = trim($args['piece']);
			
			$first_letter = $piece[0];
			
			if($first_letter == '\'' || $first_letter == '"') {
				$piece = substr($piece, 1);
			}
			
			$last_letter = $piece[strlen($piece) - 1];
			
			if($last_letter == ',') {
				$piece = substr($piece, 0, -1);
			}
			
			$last_letter = $piece[strlen($piece) - 1];
			
			if($last_letter == '\'' || $last_letter == '"') {
				$piece = substr($piece, 0, -1);
			} else {
				if($last_letter == ']' || $last_letter == ')') {
					$piece = rtrim(substr($piece, 0, -1));
					
					$last_letter = $piece[strlen($piece) - 1];
					
					if($last_letter == '\'' || $last_letter == '"') {
						$piece = substr($piece, 0, -1);
					}
				}
			}
			
			return $piece;
		}
		
			/* findDuplicateArrayKeys($args)
			 *
			 * Find duplicates of the text of an array.
			 *
			 * Expected Input:
			 *    "\$array = [
			 *      'hello1'=>123,
			 *      'hello1'=>456,
			 *      'hello2'=>789
			 *    ];"
			 *
			 * Expected Output: 
			 *     [
			 *          "hello1"=>[
			 *              123,
			 *              456,
			 *          ],
			 *     ],
			 */
		
		public function findDuplicateArrayKeys($args) {
			$text = $args['text'];
			preg_match_all('/([\'"].*?[\'"][\s\n\r]*=>[\s\n\r]*[\'"]{0,1}.*?[\'"]{0,1})[\s\n\r]*[\]\),]{1}/', $text, $matches);
			
			$matches = $matches[0];
			$matched = [];
			$duplicates = [];
			
			for($i = 0; $i < count($matches); $i++) {
				$match = $matches[$i];
				$match_pieces = explode('=>', $match);
				$key = $this->cleanupArrayPiece(['piece'=>$match_pieces[0]]);
				$value = $this->cleanupArrayPiece(['piece'=>$match_pieces[1]]);
				
				if($matched[$key]) {
					if(!$duplicates[$key]) {
						$duplicates[$key] = [
							$matched[$key],
						];
					}
					
					$duplicates[$key][] = $value;
				} else {
					$matched[$key] = $value;
				}
			}
			
			return $duplicates;
		}
	}

?>