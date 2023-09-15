<?php 
/**
* KATA 14-09-2023 - Mini Tetris (https://retosdeprogramacion.com/semanales2023) (Windows CLI version)
* The game is about moving a piece of tetris ('L' shape) across a 10 x 10 board
* Allowed user moves are LEFT ('a' key), RIGHT ('d' key), DOWN ('x' key) and ROTATE ('space') (Clockwise)
* The piece cannot move beyond the board limits
* 
* Developer notes:
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
*/

/**
 * Function to clear the console screen
 */
function cls(){
    /* print("\033[2J\033[;H"); */
    pclose(popen('cls','w'));
}

/**
 * Function that sets a blank board
 */
function clear_board(){
    global $board;
    $w = json_decode('"\u2b1c"'); // white square
    // Define a white/empty board
    $board = [];
    for ($i=0; $i < 10; $i++) { 
        for ($j=0; $j < 10; $j++) { 
            $board[$i][$j] = $w;
        }
    }
}

/**
 * Function that draws the piece on the board based on its center coordinate and its 2D position
 */
function draw_piece_in_board(){
    global $board, $center, $pos;
    // set a blank board
    clear_board();
    // define white square
    $b = json_decode('"\u2b1b"'); // black square
    // draw piece in board
    switch ($pos) {
        case 1:
            $board[$center[0]][$center[1]] = $b;
            $board[$center[0]-1][$center[1]-1] = $b;
            $board[$center[0]][$center[1]-1] = $b;
            $board[$center[0]][$center[1]+1] = $b;
            break;
        case 2:
            $board[$center[0]][$center[1]] = $b;
            $board[$center[0]-1][$center[1]] = $b;
            $board[$center[0]-1][$center[1]+1] = $b;
            $board[$center[0]+1][$center[1]] = $b;
            break;
        case 3:
            $board[$center[0]][$center[1]] = $b;
            $board[$center[0]][$center[1]-1] = $b;
            $board[$center[0]][$center[1]+1] = $b;
            $board[$center[0]+1][$center[1]+1] = $b;
            break;
        case 4:
            $board[$center[0]][$center[1]] = $b;
            $board[$center[0]-1][$center[1]] = $b;
            $board[$center[0]+1][$center[1]] = $b;
            $board[$center[0]+1][$center[1]-1] = $b;
            break;
    }
}

/**
 * Prints the given board on screen
 */
function print_board_on_screen(){
    global $board;
    cls();
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
/**********************************************/
$center = [1,1];
$pos = 1;

draw_piece_in_board();
print_board_on_screen();
echo "Next move: ";

// Infinite loop that Waits for the user input and moves the piece accordingly
while(true){
    $key = readline();
    // Filter accepted moves
    switch ($key) {
        case 'a':
            move_left();
            break;
        case 'd':
            move_right();
            break;
        case 'x':
            move_down();
            break;
        case ' ':
            rotate();
            break;
        case 'w':
            move_up();
            break;
        case 'q':
            echo "Goodbye!" . PHP_EOL;
            return;
        default:
            break;
    }
}
?>