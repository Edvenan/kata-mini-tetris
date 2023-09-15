<?php 
/**
* KATA 14-09-2023 - Mini Tetris (Linux CLI version)
* The game is about moving a piece of tetris ('L' shape) across a 10 x 10 board
* Allowed user moves are LEFT, RIGHT, DOWN and ROTATE (Clockwise) (arrow keys and 'Space' for rotation)
* The piece cannot move beyond the board limits
* 
* Developer notes:
*   The key detection technique that does not require to press enter after pressing the key
*   works only on Linux CLI
*
*   Piece 2D positions:
*       position 1 =  ⬜⬛⬛   
*                     ⬜⬜⬜
*                     ⬛⬛⬛
*   
*       position 2 = ⬛⬜⬜   
*                    ⬛⬜⬛
*                    ⬛⬜⬛
*
*       position 3 =  ⬛⬛⬛
*                     ⬜⬜⬜   
*                     ⬛⬛⬜
*   
*       position 4 =  ⬛⬜⬛
*                     ⬛⬜⬛
*                     ⬜⬜⬛
*   
*/


/**
 * Key detection processing
 */
$stdin = fopen('php://stdin', 'r');
stream_set_blocking($stdin, 0);
system('stty cbreak -echo');

function translateKeypress($string) {
    switch ($string) {
      case "\033[A":
        return "UP";
      case "\033[B":
        return "DOWN";
      case "\033[C":
        return "RIGHT";
      case "\033[D":
        return "LEFT";
      case "\n":
        return "ENTER";
      case " ":
        return "SPACE";
      case "\010":
      case "\177":
        return "BACKSPACE";
      case "\t":
        return "TAB";
      case "\e":
        return "ESC";
     }
    return $string;
}

/**
 * Function that sets a blank board
 */
function clear_board(){
    $w = json_decode('"\u2b1c"'); // white square
    // Define a white/empty board
    $board = [];
    for ($i=0; $i < 10; $i++) { 
        for ($j=0; $j < 10; $j++) { 
            $board[$i][$j] = $w;
        }
    }
    return $board;
}
/**
 * Function that draws the piece on the board based on its center coordinate and its 2D position
 */
function draw_piece_in_board(){
    global $board, $center, $pos;
    $board = clear_board();
    $b = json_decode('"\u2b1b"'); // black square
    // draw piece in board
    if ($pos == 1) {
        $board[$center[0]][$center[1]] = $b;
        $board[$center[0]-1][$center[1]-1] = $b;
        $board[$center[0]][$center[1]-1] = $b;
        $board[$center[0]][$center[1]+1] = $b;
    } elseif ($pos == 2){
        $board[$center[0]][$center[1]] = $b;
        $board[$center[0]-1][$center[1]] = $b;
        $board[$center[0]-1][$center[1]+1] = $b;
        $board[$center[0]+1][$center[1]] = $b;
    } elseif ($pos == 3){
        $board[$center[0]][$center[1]] = $b;
        $board[$center[0]][$center[1]-1] = $b;
        $board[$center[0]][$center[1]+1] = $b;
        $board[$center[0]+1][$center[1]+1] = $b;
    } elseif ($pos == 4){
        $board[$center[0]][$center[1]] = $b;
        $board[$center[0]-1][$center[1]] = $b;
        $board[$center[0]+1][$center[1]] = $b;
        $board[$center[0]+1][$center[1]-1] = $b;
    }
}
/**
 * Prints the given board on screen
 */
function print_board_on_screen(){
    global $board;
    system('clear');
    // print board on screen
    for ($i=0; $i < 10; $i++) { 
        for ($j=0; $j < 10; $j++) { 
            echo $board[$i][$j]." ";
        }
        echo "\n";
    }
}

/**
 * Functions that move the piece, draws it on the board and prints both on screen
 */
function move_left(){
    global $center, $pos;

    // check piece 2D position
    if ($pos != 2){
        // check coordinates of center of the piece
        if ($center[1] > 1 ) {
            $center[1] -= 1;
            draw_piece_in_board();
            $msg = 'Key pressed: LEFT ';
        } else {
            $msg = 'Cannot move! ';
        }
    } elseif ($pos == 2){
        if ($center[1] > 0 ) {
            $center[1] -= 1;
            draw_piece_in_board();
            $msg = 'Key pressed: LEFT ';
        } else {
            $msg = 'Cannot move! ';
        }
    }
    print_board_on_screen();
    echo $msg;
}
function move_right(){
    global $center, $pos;

    if ($pos != 4){
        if ($center[1] < 8 ) {
            $center[1] += 1;
            draw_piece_in_board();
            $msg = 'Key pressed: RIGHT ';
        } else {
            $msg = 'Cannot move! ';
        }
    } elseif ($pos == 4){
        if ($center[1] < 9 ) {
            $center[1] += 1;
            draw_piece_in_board();
            $msg = 'Key pressed: RIGHT ';
        } else {
            $msg = 'Cannot move! ';
        }
    } 
    print_board_on_screen();
    echo $msg;
}
function move_down(){
    global $center, $pos;

    if ($pos != 1){
        if ($center[0] < 8 ) {
            $center[0] += 1;
            draw_piece_in_board();
            $msg = 'Key pressed: DOWN ';
        } else {
            $msg = 'Cannot move! ';
        }
    } elseif ($pos == 1){
        if ($center[0] < 9 ) {
            $center[0] += 1;
            draw_piece_in_board();
            $msg = 'Key pressed: DOWN ';
        } else {
            $msg = 'Cannot move! ';
        }
    }
    print_board_on_screen();
    echo $msg;
}
function rotate(){
    global $center, $pos;

    if ($pos == 1){
        // rotate only if piece is within the board's limits
        if ($center[1] > 0 && $center[1] < 9 && $center[0] > 0 && $center[0] < 9 ) {
            // update piece 2D position
            $pos = ($pos + 1 > 4) ? 1 : $pos+1;
            draw_piece_in_board();
            $msg = 'Key pressed: ROTATE ';
        } else {
            $msg = 'Cannot move! ';
        }
    } elseif ($pos == 2){
        if ($center[1] > 0 && $center[1] < 9 ) {
            $pos = ($pos + 1 > 4) ? 1 : $pos+1;
            draw_piece_in_board();
            $msg = 'Key pressed: ROTATE ';
        } else {
            $msg = 'Cannot move! ';
        }
    } elseif ($pos == 3){
        if ($center[0] > 0 ) {
            $pos = ($pos + 1 > 4) ? 1 : $pos+1;
            draw_piece_in_board();
            $msg = 'Key pressed: ROTATE ';
        } else {
            $msg = 'Cannot move! ';
        }    
    } elseif ($pos == 4){
        if ($center[1] > 0 && $center[1] < 9 && $center[0] >0 && $center[0] < 9 ) {
            $pos = ($pos + 1 > 4) ? 1 : $pos+1;
            draw_piece_in_board();
            $msg = 'Key pressed: ROTATE ';
        }  else {
            $msg = 'Cannot move! ';
        }
    }
    print_board_on_screen();
    echo $msg;
}
function move_up(){
    global $board, $center, $pos;

    if ($pos != 3){
        if ($center[0] > 1 ) {
            $center[0] -= 1;
            draw_piece_in_board();
            $msg = 'Key pressed: UP ';
        } else {
            $msg = 'Cannot move! ';
        }
    } elseif ($pos == 3){
        if ($center[0] > 0 ) {
            $center[0] -= 1;
            draw_piece_in_board();
            $msg = 'Key pressed: UP ';
        } else {
            $msg = 'Cannot move! ';
        }
    }
    print_board_on_screen();
    echo $msg;
}
    
/**********************************************/
/* Print board and piece at starting position */
/******** *************************************/
$center = [1,1];  // [row, col]
$pos = 1;

draw_piece_in_board();
print_board_on_screen();
echo "Please move...";

// Infinite loop that waits for the user input and moves the piece accordingly
while(true){
    $keypress = fgets($stdin);
    if ($keypress) {
        $key = translateKeypress($keypress);
        
        // Filter accepted moves
        switch ($key) {
            case 'LEFT':
                move_left();
                break;
            case 'RIGHT':
                move_right();
                break;
            case 'DOWN':
                move_down();
                break;
            case 'SPACE':
                rotate();
                break;
            case 'UP':
                move_up();
                break;
            case 'q':
                echo PHP_EOL . "Goodbye!" . PHP_EOL;
                return;
            default:
                break;
        }
    }
}
?>